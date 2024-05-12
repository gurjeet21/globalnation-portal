<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use App\Models\Artists;
use App\Models\ArtistFeatureds;
use App\Models\Pages;

class ManageApiController extends Controller
{

    public function downloadContent(Request $request){

        if($request->pagestatus == 2){
            $download = ManagePages::where('page_slug', $request->pageslug)->where('status', 1)->first();
        }else{
            $download = ManagePages::where('page_slug', $request->pageslug)->where('status', 2)->first();
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
        if($request->pagestatus == 1){
            $artistFeatureds = ArtistFeatureds::where('page_slug', $request->pageslug)->where('is_preview', 0)->get();

        }else{
            $artistFeatureds = ArtistFeatureds::where('page_slug', $request->pageslug)->where('deleted_at', null)->where('is_preview', 1)->get();
        }

        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name];
        });

        $result = [];
        $baseUrl = asset('_uploads/bg/');
        foreach($artistFeatureds as $featured){
            $result[] = array('id' => $featured->id ,'artist_id' => $artists[$featured->artist_id] , 'page_title' => $featured->page_title, 'page_slug' => $featured->page_slug, 'title' => $featured->title, 'video_url' => $featured->video_url, 'background_image' => !empty($featured->background_image) ? $baseUrl.'/'.$featured->background_image : '', 'description' => $featured->description );
        }
        return response()->json(['artists' => $result], 200);
    }

    public function featuredArtistPreview(Request $request){
        $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', '!=', 0)->orderBy('id', 'ASC')->get();
        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name];
        });
        $result = [];
        $baseUrl = asset('_uploads/bg/');
        foreach($artistFeatureds as $featured){
            $result[] = array('artist_name' => $artists[$featured->artist_id] , 'title' => $featured->title, 'video_url' => $featured->video_url, 'background_image' => !empty($featured->background_image) ? $baseUrl.'/'.$featured->background_image : '', 'description' => $featured->description );
        }
        return response()->json(['artists' => $result], 200);

    }

    public function allPages(Request $request){
        $Pages = Pages::where('deleted_at', null)->where('is_preview', 0)->get();
        $result = [];

        $baseUrl = asset('_uploads/bg/');

        foreach($Pages as $Page){
            $result[] = array(
                'page_title' => $Page->page_title,
                'page_slug' => $Page->page_slug,
                'description' => $Page->description,
                'background_image' => !empty($Page->background_image) ? $baseUrl.'/'.$Page->background_image : ''
            );
        }
        return response()->json(['pages' => $result], 200);

    }

    public function allPagesPreview(Request $request){
        $Pages = Pages::where('deleted_at', null)->where('is_preview', '!=', 0)->get();
        $result = [];
        $baseUrl = asset('_uploads/bg/');
        foreach($Pages as $Page){
            $result[] = array(
                'page_title' => $Page->page_title,
                'page_slug' => $Page->page_slug,
                'description' => $Page->description,
                'background_image' => !empty($Page->background_image) ? $baseUrl.'/'.$Page->background_image : ''
            );
        }
        return response()->json(['pages' => $result], 200);

    }

    public function dynamicPage(Request $request, $page_slug){
        $Pages = Pages::where('page_slug', $page_slug)->where('is_preview', 0)->first();

        $baseUrl = asset('_uploads/bg/');
        if(!empty($Pages)){
            $result = array(
                'page_title' => $Pages->page_title,
                'page_slug' => $Pages->page_slug,
                'description' => $Pages->description,
                'background_image' => !empty($Pages->background_image) ? $baseUrl.'/'.$Pages->background_image : ''
            );
            return response()->json(['pages' => $result, 'status' => 'success'], 200);
        }
        $result = array(
            'page_title' => 'Not Found',
            'page_slug' => 'not-found',
            'description' => 'Page not found',
            'background_image' => ''
        );
        return response()->json(['pages' => $result, 'status' => 'not found'], 200);

    }


    public function all_pages_data(Request $request){
        $download_table = ManagePages::where('page_slug', $request->pageslug)->where('status', 1)->first();
        $page_table = Pages::where('page_slug', $request->pageslug)->where('is_preview', 0)->first();
        $video_table = ArtistFeatureds::where('page_slug', $request->pageslug)->where('is_preview', 0)->get();
        $artists = [];
        $result = [];
        if($download_table) {
            $show_temp_data = $download_table;
        } elseif($page_table) {
            $baseUrl = asset('_uploads/bg/');
            $result = [
                'page_title' => $page_table->page_title,
                'page_slug' => $page_table->page_slug,
                'description' => $page_table->description,
                'background_image' => !empty($page_table->background_image) ? $baseUrl.'/'.$page_table->background_image : ''
            ];

            return response()->json(['pages' => $result], 200);

        } elseif($video_table) {
            //$show_temp_data = $video_table;

            if($request->pagestatus == 1){
                $artistFeatureds = ArtistFeatureds::where('page_slug', $request->pageslug)->where('is_preview', 0)->get();

            }else{
                $artistFeatureds = ArtistFeatureds::where('page_slug', $request->pageslug)->where('deleted_at', null)->where('is_preview', 1)->get();
            }

            $artists = Artists::all()->mapWithKeys(function ($artist) {
                return [$artist->id => $artist->first_name];
            });

            $result = [];
            $baseUrl = asset('_uploads/bg/');
            foreach($artistFeatureds as $featured){
                $result[] = array('id' => $featured->id ,'artist_id' => $artists[$featured->artist_id] , 'page_title' => $featured->page_title, 'page_slug' => $featured->page_slug, 'title' => $featured->title, 'video_url' => $featured->video_url, 'background_image' => !empty($featured->background_image) ? $baseUrl.'/'.$featured->background_image : '', 'description' => $featured->description );
            }
            return response()->json(['artists' => $result], 200);
        } else {
            abort(404);
        }
    }

}
