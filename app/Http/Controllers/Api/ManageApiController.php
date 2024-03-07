<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ManagePages;

class ManageApiController extends Controller
{

    public function downloadContent(Request $request){
        $download = ManagePages::first();
        $download->plateform_name = json_decode($download->plateform_name, true);
        $download->plateform_file = json_decode($download->plateform_file, true);
        $download->plateform_status = json_decode($download->plateform_status, true);
        return response()->json(['download' => $download], 200);
    }
    public function downloadTestContent(Request $request){
        $download = ManagePages::find(2);
        $download->plateform_name = json_decode($download->plateform_name, true);
        $download->plateform_file = json_decode($download->plateform_file, true);
        $download->plateform_status = json_decode($download->plateform_status, true);
        return response()->json(['download' => $download], 200);
    }

}
