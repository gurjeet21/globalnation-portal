<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use App\Models\Artists;
use App\Models\ArtistFeatureds;

class ManageApiController extends Controller
{

    public function downloadContent(Request $request){
        if($request->pagestatus == 2){
            $download = ManagePages::find(3);
        }else{
            $download = ManagePages::first();
        }
        $baseUrl = asset('_uploads/builds/');
        $download->plateform_name = json_decode($download->plateform_name, true);
        $download->plateform_file = json_decode($download->plateform_file, true);
        $download->plateform_status = json_decode($download->plateform_status, true);
        $download->background_image = !empty($download->background_image) ? $baseUrl.'/'.$download->background_image : '';
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

    public function featuredArtist(Request $request){

        $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', 0)->get();
        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
        });
        $result = [];

        foreach($artistFeatureds as $featured){
            $result[] = array('artist_name' => $artists[$featured->artist_id] , 'title' => $featured->title, 'video_url' => $featured->video_url, 'description' => $featured->description );
        }
        return response()->json(['artists' => $result], 200);
    }

    public function featuredArtistPreview(Request $request){
        $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', '!=', 0)->get();
        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
        });
        $result = [];

        foreach($artistFeatureds as $featured){
            $result[] = array('artist_name' => $artists[$featured->artist_id] , 'title' => $featured->title, 'video_url' => $featured->video_url, 'description' => $featured->description );
        }
        return response()->json(['artists' => $result], 200);    

    }

}
