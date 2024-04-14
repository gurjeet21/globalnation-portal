<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use Illuminate\Support\Str;
use App\Models\Artists;
use App\Models\ArtistFeatureds;

class FeaturedPagesController extends Controller
{

    public function index(Request $request)
    {

        $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', 0)->orderBy('id', 'DESC')->get();
        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
        });
        return view('pages.manage-featured', compact('artistFeatureds', 'artists'));
    }


    public function add_artists()
    {
        return view('pages.add-artists');
    }

    public function add_featured()
    {
        $artists = Artists::where('deleted_at', null)->get();
        return view('pages.add-featured', compact('artists'));
    }


    public function store_artist(Request $request){
        // $data = $request->all();
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            //'last_name' => ['required', 'string', 'max:255'],
            //'email' => 'required|email|unique:artists|max:255',
        ]);

        $file_name = null;
        if ($request->hasFile('artist_image')) {
            $file = $request->file('artist_image');
            $file_name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('_uploads/artists'), $file_name);
        }

        $addArtists = Artists::create([
            'first_name' => $request->first_name,
            'last_name' => isset($request->last_name) ? $request->last_name : null,
            'email' => isset($request->email) ? $request->email : null,
            'profile_image' => $file_name,
        ]);

        return response()->json(['status' => 'success','message' => 'Artist added successfully'], 200);
    }

    public function store_featured(Request $request){
        $request->validate([
            'artist_id' => ['required'],
            'featured_title' => ['required', 'string', 'max:255'],
            'video_link' => ['required'],
            'featured_description' => ['required'],
        ]);

        $save_artist = ArtistFeatureds::create([
            'artist_id' => $request->artist_id,
            'title' => $request->featured_title,
            'video_url' => $request->video_link,
            'description' => $request->featured_description,
            'status' => 1,
            'is_preview' => 0,
        ]);

        ArtistFeatureds::create([
            'artist_id' => $request->artist_id,
            'title' => $request->featured_title,
            'video_url' => $request->video_link,
            'description' => $request->featured_description,
            'status' => 1,
            'is_preview' => $save_artist->id,
        ]);

        return response()->json(['status' => 'success','message' => 'Artist added successfully'], 200);
    }

    public function store_featured_post(Request $request){
     
        $disclaimers = explode(',', $request->disclaimers);     
        $length = count($request->artist_id);
        if($request->status == 1){
            ArtistFeatureds::query()->truncate();
            for($i = 0; $i < $length; $i++){
                $save_artist = ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'status' => $request->featured_status[$i],
                    'is_preview' => 0,
                ]);
        
                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);            
            }
        }else{
            ArtistFeatureds::where('is_preview',1)->delete();
            for($i = 0; $i < $length; $i++){
                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);
            }
        }

        return response()->json(['status' => 'success','message' => 'Artist added successfully'], 200);
    }


    public function update_featured(Request $request, $id){

        if ($request->ajax()){

            $request->validate([
                'artist_id' => ['required'],
                'featured_title' => ['required', 'string', 'max:255'],
                'video_link' => ['required'],
                'featured_description' => ['required'],
            ]);

            if($request->is_preview == 1){
                ArtistFeatureds::updateOrCreate(
                    ['is_preview' => $id],
                    [
                    'artist_id' => $request->artist_id,
                    'title' => $request->featured_title,
                    'video_url' => $request->video_link,
                    'description' => $request->featured_description,
                    'status' => 1,
                    'is_preview' => $id,
                ]);
            }else{
                ArtistFeatureds::updateOrCreate(
                    ['id' => $id],
                    [
                    'artist_id' => $request->artist_id,
                    'title' => $request->featured_title,
                    'video_url' => $request->video_link,
                    'description' => $request->featured_description,
                    'status' => 1,
                    'is_preview' => 0,
                ]);
            }
            return response()->json(['status' => 'success', 'is_preview' => $request->is_preview,'message' => 'Featured updated successfully'], 200);
        }else{
            $artists = Artists::where('deleted_at', null)->get();
            $artistFeatureds = ArtistFeatureds::where('id', $id)->first();
            if(empty($artistFeatureds)){
                abort(404);
            }
            return view('pages.edit-featured', compact('artistFeatureds','artists'));
        }

    }

    public function delete_featured(Request $request, $id){
        ArtistFeatureds::where('id',$id)->delete();
        ArtistFeatureds::where('is_preview',$id)->delete();
    	return redirect()->back()->with(['succ_msg'=>'Featured sucessfully deleted']);
    }
}
