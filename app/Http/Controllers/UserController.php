<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use DB;
class UserController extends Controller
{
    public function index(){
    	$auth_user = \Auth::user()->role;
    	$auth_user_id = \Auth::user()->id;
    	if($auth_user == 'Super Admin'){
    		$users = User::where('role','!=','Super Admin')->get();
    	}else{
    		$users = User::where('id',$auth_user_id)->get();
    	}

    	return view('pages.users',compact('users'));
    }

    public function dashboard_count(){
    	$total_rim = DB::table('rims')->count();
	    //$total_vehicle = DB::table('wheel_modifications')->count();
        // $missing_fitment = DB::table('wheel_modifications as wm')
		//     ->join('modifications as modi', 'modi.id', '=', 'wm.modification_id')
		//     ->selectRaw('SUM(CASE
		//         WHEN (wm.custom_rim_diameter IS  NULL AND wm.custom_rim_diameter != "" AND wm.custom_rim_diameter != "-")
		//         AND (wm.custom_rim_width IS  NULL AND wm.custom_rim_width != "" AND wm.custom_rim_width != "-")
		//         AND (wm.custom_rim_offset IS  NULL AND wm.custom_rim_offset != "" AND wm.custom_rim_offset != "-")
		//         AND (modi.custom_technical_pcd IS  NULL AND modi.custom_technical_pcd != "" AND modi.custom_technical_pcd != "-")
		//         AND (modi.custom_technical_centre_bore IS  NULL AND modi.custom_technical_centre_bore != "" AND modi.custom_technical_centre_bore != "-")
		//         THEN 1 ELSE 0 END ) as no_of_empty_rim_diameter')
		//     ->first();


        //$total_missing_fitment = $missing_fitment->no_of_empty_rim_diameter;
	    return view('dashboard',compact('total_rim'));
    }

    public function add_user(Request $request){
    	if($request->isMethod('get')){
    		return view('pages.add-user');
    	}else{

    		$request->validate([
	            'email' => 'required|email|unique:users',
	        ]);

	        $user = new User([
	            'email' => $request->input('email')
	        ]);

	        $user->save();
	        $user_id = $user->id;
	        return redirect()->route('user.update',['user_id'=>$user_id])->with('success', 'User created successfully!');
    	}
    }

    public function update_user(Request $request,$user_id){

    	if($request->isMethod('get')){
    		$user_detail = User::where('id',$user_id)->first();
    		return view('pages.update-user',compact('user_detail'));
    	}else{

    		// dd($request->all());
    		$request->validate([
	            'name' => 'required',
                'user_role' => 'required|in:Admin,Contributors,Viewers',
	            'email' => [
	                'required',
	                'email',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	            'phone' => [
	                'required',
	                'regex:/^[0-9]{10,15}$/',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	        ]);


	       	$update['name'] = $request->name;
	        $update['first_name'] = $request->first_name;
	        $update['last_name'] = $request->last_name;
	        $update['email'] = $request->email;
	        $update['phone'] = $request->phone;
	        $update['designation'] = $request->designation;

	        if ($request->filled('password')) {
	            $update['password'] = bcrypt($request->password);
	        }

	        if ($request->hasFile('img')) {
	            $image = $request->file('img');
	            $imageName = time() . '.' . $image->getClientOriginalExtension();
	            $image->move(public_path('user_image'), $imageName);
	            $update['img'] = $imageName;
	        }

	        if($request->is_remove == 1){
	        	$update['img'] = '';
	        }

	        User::where('id',$user_id)->update($update);
		    return redirect()->back()->with('success', 'User updated successfully!');

    	}
    }


    public function update_my_profile(Request $request){
    	$user_id = \Auth::id();
    	if($request->isMethod('get')){
   			$user_detail = User::where('id',$user_id)->first();
    		return view('pages.update-my-profile',compact('user_detail'));
    	}else{
    		 $request->validate([
	            'name' => 'required',
	            'email' => [
	                'required',
	                'email',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	            'phone' => [
	                'required',
	                'regex:/^[0-9]{10,15}$/',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
        ]);


       	$update['name'] = $request->name;
        $update['first_name'] = $request->first_name;
        $update['last_name'] = $request->last_name;
        $update['email'] = $request->email;
        $update['phone'] = $request->phone;

        if ($request->filled('password')) {
            $update['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user_image'), $imageName);
            $update['img'] = $imageName;
        }

        if($request->is_remove == 1){
        	$update['img'] = '';
        }

        User::where('id',$user_id)->update($update);
	    return redirect()->back()->with('success', 'User updated successfully!');

    	}
    }

    public function delete_user(Request $request,$user_id){
    	$user_detail = User::where('id',$user_id)->delete();
    	return redirect()->back()->with(['succ_msg'=>'User sucessfully deleted']);
    }

}
