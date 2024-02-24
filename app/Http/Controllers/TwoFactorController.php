<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PragmaRX\Google2FAQRCode\Google2FA;


class TwoFactorController extends Controller
{
    public function two_fa(){
        $check_2fa = \DB::table('users')->where('id',\Auth::id())->select('is_2fa_enable')->first();
        return view('pages.two-fa',compact('check_2fa'));
    }

    public function generate_qr(Request $request){
        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        $secretKey = $g->generateSecret();
        $email = \Auth::user()->email;
        $app_name = 'globalnation.tv';

        if(\DB::table('users')->where('is_2fa_enable',1)->where('id',\Auth::id())->exists()){
            $qrCodeUrl = '';
        }else{
            $qrCodeUrl = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($email, $secretKey,$app_name );
        }

        \DB::table('users')->where('email',$email)->update(['google2fa_secret'=>$secretKey]);
        return response()->json(['qrCodeUrl'=>$qrCodeUrl]);
    }


    public function complete_registration(Request $request){
        $email = \Auth::user()->email;
        $secret = \Auth::user()->google2fa_secret;

        if(isset($request->is_disble) && $request->is_disble == 1){
            $request->validate([
                'password' => 'required',
            ]);

            if (\Hash::check($request->password, \Auth::user()->password)) {

            }else{
               return redirect()->back()->with('error','Password do not matched');
            }

            \DB::table('users')->where('email',$email)->update(['is_2fa_enable'=>'0']);
            return redirect()->back()->with(['success' =>'Two factor Authentication disabled successfully']);
        }

        $request->validate([
                'code' => 'required',
            ]);

        $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        if ($g->checkCode($secret, $request->code)) {
            \DB::table('users')->where('email',$email)->update(['is_2fa_enable'=>'1','two_fa_now'=>'1']);
            // return redirect()->back()->with(['success' =>'Two factor Authentication enabled successfully']);
            return response()->json(['status'=>'200','msg'=>'Two factor Authentication enabled successfully']);
        } else {
            // return redirect()->back()->with('error','Please Enter Vaild Key!');
            return response()->json(['status'=>'201','msg'=>'Please Enter Vaild Key!']);
        }
    }

    public function login_2fa(Request $request){
        $email = \Auth::user()->email;
        $secret = \Auth::user()->google2fa_secret;
        if($request->isMethod('get')){
            // if(\DB::table('users')->where('email',$email)->where('is_2fa_enable',1)->exists()){
            //     return view('pages.login_2f');
            // }else{
            //     return redirect()->route('dashboard');
            // }
            if(\DB::table('users')->where('email',$email)->exists()){
                return redirect()->route('dashboard');
            }

        }else{
            try {
                $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                    if ($g->checkCode($secret, $request->code)) {
                        \DB::table('users')->where('id',\Auth::id())->update(['two_fa_now'=>'1']);
                        return redirect()->route('dashboard');
                    } else {
                        \DB::table('users')->where('id',\Auth::id())->update(['two_fa_now'=>'0']);
                        return redirect()->back()->with('error','Please Enter Vaild Key!');
                    }
            } catch (\Exception $e) {
                // Log the exception or handle it appropriately
                return redirect()->back()->with('error', $e->getMessage());
            }

        }

    }

}
