<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ManagePages;

class ManageApiController extends Controller
{

    public function downloadContent(Request $request){
        if($request->pagestatus == 2){
            $download = ManagePages::find(3);
        }else{
            $download = ManagePages::first();
        }
        $download->plateform_name = json_decode($download->plateform_name, true);
        $download->plateform_file = json_decode($download->plateform_file, true);
        $download->plateform_status = json_decode($download->plateform_status, true);
        return response()->json(['download' => $download], 200);
    }
    public function downloadTestContent(Request $request){
       
        if($request->pagestatus == 2){
            $download = ManagePages::find(4);
        }else{
            $download = ManagePages::find(2);
        }
        //$baseUrl = public_path('_uploads/builds/');
        $baseUrl = asset('_uploads/builds/');
        $download->plateform_name = json_decode($download->plateform_name, true);
        $download->plateform_file = json_decode($download->plateform_file, true);
        $download->plateform_status = json_decode($download->plateform_status, true);
        $download->background_image = !empty($download->background_image) ? $baseUrl.'/'.$download->background_image : '';
        return response()->json(['download' => $download], 200);
    }

}
