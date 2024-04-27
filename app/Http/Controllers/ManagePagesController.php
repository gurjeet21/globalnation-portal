<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use App\Models\Pages;
use App\Models\Artists;
use App\Models\ArtistFeatureds;
use Illuminate\Support\Str;

class ManagePagesController extends Controller
{
    //
    public function index(Request $request)
    {
        die('pages.list');
        return view('pages.list');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Print the form data and stop execution
        $plateform_file = [];
        $total_plateform = count($data['plateform_name']);
        if($total_plateform > 0){
            for ($x = 0; $x < $total_plateform; $x++) {
                $plateform_file[] = $data['plateform_file_hidden'][$x];
            }
        }

        $background_image = '';

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $imageName = $file->getClientOriginalName();
            $background_image = $imageName;
        }

        $status = $data['status'];
        $page_id = $data['page_id'];
        $title = $data['page_title'];

        if (strpos($title, '<') !== false && strpos($title, '>') !== false) {
            $page_title = strip_tags($title);
        } else {
            $page_title = $title;
        }
        $page_title = trim($page_title);

        if($status == 2){
            $page_id = 4;
        }

        ManagePages::updateOrCreate(
            ['id' => $page_id],
            [
            'title' => $data['page_title'],
            'slug' => Str::slug($page_title, '-'),
            'background_image' => $background_image,
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
        ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }

    public function store_test(Request $request)
    {
        $data = $request->all();
        // Print the form data and stop execution
        $plateform_file = [];
        $total_plateform = count($data['plateform_name']);
        if($total_plateform > 0){
            for ($x = 0; $x < $total_plateform; $x++) {
                $plateform_file[] = $data['plateform_file_hidden'][$x];
            }
        }

        $background_image = '';

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $imageName = $file->getClientOriginalName();
            $background_image = $imageName;
        }

        $status = $data['status'];
        $page_id = $data['page_id'];
        $title = $data['page_title'];

        if (strpos($title, '<') !== false && strpos($title, '>') !== false) {
            $page_title = strip_tags($title);
        } else {
            $page_title = $title;
        }
        $page_title = trim($page_title);

        if($status == 2){
            $page_id = 4;
        }

        ManagePages::updateOrCreate(
            ['id' => $page_id],
            [
            'title' => $data['page_title'],
            'slug' => Str::slug($page_title, '-'),
            'background_image' => $background_image,
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
        ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }

    public function store_file_progress(Request $request)
    {
        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $file_name = $file->getClientOriginalName();
            // Check if a file with the same name already exists
            $existingFilePath = public_path('_uploads/builds/' . $file->getClientOriginalName());
            if (file_exists($existingFilePath)) {
                // Delete the existing file
                unlink($existingFilePath);
            }
            $file->move(public_path('_uploads/builds'), $file->getClientOriginalName());
            return response()->json(['status' => 'success','file' => $file_name], 200);
        } else {
            return response()->json(['status' => 'error','file' => 'Something went wrong'], 200);

        }
    }

    public function add_privacy_policy(Request $request)
    {
        $currentUrl = $request->path();
        // Check if the current URL is '/privacy-policy'
        if ($currentUrl === 'privacy-policy') {
            // Fetch the privacy policy data based on the slug
            $privacyPolicy = Pages::where('page_slug', 'privacy-policy')->get();
        } else {
            // If URL is not '/privacy-policy', fetch all records (or handle as per your requirement)
            $privacyPolicy = Pages::where('deleted_at', null)->get();
        }

        return view('pages.privacy-policy', compact('privacyPolicy'));

    }

    public function store_privacy_policy(Request $request)
    {
        //dd($request->only(['page_title', 'description', 'page_slug', 'status', 'is_preview']));
        $data = $request->validate([
            'page_title' => ['required'],
            'description' => ['required'],
            'page_slug' => ['required'],
            'status' => ['required'],
            'is_preview' => ['required'],
        ]);

        $title = $data['page_title'];
        $page_slug = $data['page_slug'];
        $status = $data['status'];
        $is_preview = $data['is_preview'];

        // Fetch the privacy policy record based on the slug
        $privacyPolicy = Pages::where('page_slug', $page_slug)->first();

        $background_image = isset($privacyPolicy->background_image) ? $privacyPolicy->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }

        if (!$privacyPolicy) {
            // If no record exists, create a new one
            $privacyPolicy = Pages::create([
                'page_title' => $data['page_title'],
                'page_slug' =>  $page_slug,
                'description' => $data['description'],
                'background_image' => $background_image,
                'status' => 1,
                'is_preview' => $is_preview,
            ]);
        }else if($privacyPolicy && $data['is_preview']== 1){
            $privacyPolicyPreview = Pages::where('page_slug', $page_slug)
                          ->where('is_preview', $is_preview)
                          ->first();
            if (!$privacyPolicyPreview) {
                $privacyPolicyPreview = Pages::create([
                    'page_title' => $data['page_title'],
                    'page_slug' =>  $page_slug,
                    'description' => $data['description'],
                    'background_image' => $background_image,
                    'status' => 1,
                    'is_preview' => 1,
                ]);
            }else{
                Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)
                ->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
                'background_image' => $background_image,
                ]);
            }
        } else {
            // If a record exists, update it
            Pages::where('page_slug', $page_slug)->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
                'background_image' => $background_image,
            ]);
        }

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'privacyPolicy' => $privacyPolicy], 200);
    }


    public function add_terms_service(Request $request)
    {
        $currentUrl = $request->path();
        // Check if the current URL is '/terms-of-service'
        if ($currentUrl === 'pages/terms-of-service') {
            // Fetch the terms of service data based on the slug
            $termsService = Pages::where('page_slug', 'terms-of-service')->first();
        }
        else {
            // If URL is not '/terms-of-service', fetch all records (or handle as per your requirement)
            $termsService = Pages::where('deleted_at', null)->get();
        }

        return view('pages.terms-of-service', compact('termsService'));

    }


    public function store_terms_service(Request $request)
    {
        $data = $request->validate([
            'page_title' => ['required'],
            'description' => ['required'],
            'page_slug' => ['required'],
            'status' => ['required'],
            'is_preview' => ['required'],
        ]);

        $title = $data['page_title'];
        $page_slug = $data['page_slug'];
        $status = $data['status'];
        $is_preview = $data['is_preview'];

        // Fetch the privacy policy record based on the slug
        $termsService = Pages::where('page_slug', $page_slug)->first();

        $background_image = isset($termsService->background_image) ? $termsService->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }

        if (!$termsService) {
            // If no record exists, create a new one
            $termsService = Pages::create([
                'page_title' => $data['page_title'],
                'page_slug' =>  $page_slug,
                'description' => $data['description'],
                'status' => 1,
                'is_preview' => $is_preview,
            ]);
        }else if($termsService && $data['is_preview']== 1){
            $termsServicePreview = Pages::where('page_slug', $page_slug)
                          ->where('is_preview', $is_preview)
                          ->first();
            if (!$termsServicePreview) {
                $termsServicePreview = Pages::create([
                    'page_title' => $data['page_title'],
                    'page_slug' =>  $page_slug,
                    'description' => $data['description'],
                    'status' => 1,
                    'is_preview' => 1,
                ]);
            }else{
                Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)
                ->update([
                    'page_title' => $data['page_title'],
                    'description' => $data['description'],
                    'background_image' => $background_image,
                ]);
            }
        } else {
            // If a record exists, update it
            Pages::where('page_slug', $page_slug)->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
                'background_image' => $background_image,
            ]);
        }

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'termsService' => $termsService], 200);
    }


    public function show_featured(Request $request)
    {
        // You can return a response or redirect as needed
        $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', 0)->orderBy('id', 'ASC')->get();
        $artists = Artists::all()->mapWithKeys(function ($artist) {
            return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
        });
        if(count($artistFeatureds) == 0){
            $artistFeatureds[] = (object)array('artist_id' => '', 'title' => '', 'video_url' => '', 'description' => '', 'status' => 1);
        }

        return view('pages.featured', ['artists' => $artists,'artistFeatureds' => $artistFeatureds]);
    }

    public function template_page_text(Request $request)
    {
        return view('pages.template-page-text');
    }

    public function save_new_page(Request $request)
    {
        $data = $request->validate([
            'page_title' => ['required'],
            'description' => ['required'],
            'page_slug' => ['required'],
            'status' => ['required'],
            'is_preview' => ['required'],
        ]);

        $title = $data['page_title'];
        $page_slug = $data['page_slug'];
        $status = $data['status'];
        $is_preview = $data['is_preview'];

        // Fetch the new page record based on the slug
        //$new_page = Pages::where('page_slug', $page_slug)->first();

        $background_image = isset($new_page->background_image) ? $new_page->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }

        $new_page = Pages::create([
            'page_title' => $data['page_title'],
            'page_slug' =>  $page_slug,
            'description' => $data['description'],
            'background_image' => $background_image,
            'status' => 1,
            'is_dynamic' => 1,
            'is_preview' => $is_preview,
        ]);

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully'], 200);
    }

    public function managePages(Request $request){
    	$dynamicPages = Pages::where('is_preview', 0)->get()->toArray();
        $pages = array(array('page_title' => 'Downloads', 'page_slug'=> 'downloads', 'is_dynamic'=> 0, 'created_at' => '2024-04-06T04:16:39.000000Z'), array('page_title' => 'Featured', 'page_slug'=> 'featured', 'is_dynamic'=> 0, 'created_at' => '2024-04-06T04:16:39.000000Z'));
        foreach($dynamicPages as  $dpage){
            array_push($pages, $dpage);
        }

    	return view('pages.manage-pages',compact('pages'));
    }

    public function updatePage(Request $request, $page_slug){
        $page = Pages::where('page_slug', $page_slug)->where('is_preview', 0)->first();
        return view('pages.update-page',compact('page'));
    }

    public function saveDynamicPage(Request $request){
        $data = $request->validate([
            'page_title' => ['required'],
            'description' => ['required'],
            'page_slug' => ['required'],
            'status' => ['required'],
            'is_preview' => ['required'],
        ]);

        $title = $data['page_title'];
        $page_slug = $data['page_slug'];
        $status = $data['status'];
        $is_preview = $data['is_preview'];

         $pageData = Pages::where('page_slug', $page_slug)->first();

         $background_image = isset($pageData->background_image) ? $pageData->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }

        Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)
        ->update([
            'page_title' => $data['page_title'],
            'description' => $data['description'],
            'background_image' => $background_image,
        ]);

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully'], 200);
    }

    public function deleteDynamicPage(Request $request, $id){
        Pages::where('id',$id)->delete();
        Pages::where('is_preview',$id)->delete();
    	return redirect()->back()->with(['succ_msg'=>'Page sucessfully deleted']);
    }

    public function template_downlaod(Request $request)
    {
        return view('pages.template-download');
    }

    public function add_new_page(Request $request)
    {
        return view('pages.add-page');
    }

    public function load_page(Request $request)
    {
        $page = $request->input('page');
        if ($page === 'page-text-template') {
            return view('pages.template-page-text');
        } else if ($page === 'download-template') {
            return view('pages.template-download');
        } else if ($page === 'video-template') {
            return view('pages.featured');
        }
    }

    public function save_download_template_new_item(Request $request)
    {
        $data = $request->all();
        // Print the form data and stop execution
        $plateform_file = [];
        $total_plateform = count($data['plateform_name']);
        if($total_plateform > 0){
            for ($x = 0; $x < $total_plateform; $x++) {
                $plateform_file[] = $data['plateform_file_hidden'][$x];
            }
        }

        $background_image = '';

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $imageName = $file->getClientOriginalName();
            $background_image = $imageName;
        }

        $status = $data['status'];
        $title = $data['page_title'];
        $page_slug = $data['page_slug'];

        if (strpos($title, '<') !== false && strpos($title, '>') !== false) {
            $page_title = strip_tags($title);
        } else {
            $page_title = $title;
        }
        $page_title = trim($page_title);

        ManagePages::updateOrCreate(
            [
            'title' => $data['page_title'],
            'slug' => $page_slug,
            'background_image' => $background_image,
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
            ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }
}
