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
            'page_title' => $data['page_title'],
            'page_slug' => Str::slug($page_title, '-'),
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
            'page_title' => $data['page_title'],
            'page_slug' => Str::slug($page_title, '-'),
            'background_image' => $background_image,
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
        ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }

    public function update_download_template_page(Request $request)
    {
        $data = $request->all();
        // Get the slug from the request data
        $page_slug = $data['page_slug'];

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

        $update_download_temp = ManagePages::where('page_slug', $page_slug)->first();

        if($update_download_temp && $status == 2){
            $download_temp_preview = ManagePages::where('page_slug', $page_slug)
                          ->where('status', $status)
                          ->first();

            if (!$download_temp_preview) {
                $updated = ManagePages::create([
                    'page_title' => $data['page_title'],
                    'page_slug' => $page_slug, // Use $title variable instead of $page_title
                    'background_image' => $background_image,
                    'plateform_name' => json_encode($data['plateform_name']),
                    'plateform_file' => json_encode($plateform_file),
                    'plateform_status' => json_encode($data['plateform_status']),
                    'disclaimers' => $data['disclaimers'],
                    'status' => $status,
                ]);
            }else{
                $updated = ManagePages::where('page_slug', $page_slug)->where('status', 2)->update([
                    'page_title' => $data['page_title'],
                    'page_slug' => $page_slug, // Use $title variable instead of $page_title
                    'background_image' => $background_image,
                    'plateform_name' => json_encode($data['plateform_name']),
                    'plateform_file' => json_encode($plateform_file),
                    'plateform_status' => json_encode($data['plateform_status']),
                    'disclaimers' => $data['disclaimers'],
                    'status' => $status,
                ]);
            }
        }else{
            $updated = ManagePages::where('page_slug', $page_slug)->where('status', $status)->update([
                'page_title' => $data['page_title'],
                'page_slug' => $page_slug, // Use $title variable instead of $page_title
                'background_image' => $background_image,
                'plateform_name' => json_encode($data['plateform_name']),
                'plateform_file' => json_encode($plateform_file),
                'plateform_status' => json_encode($data['plateform_status']),
                'disclaimers' => $data['disclaimers'],
                'status' => $status
            ]);
        }

        // Check if record was updated successfully
        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Record updated successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update record'], 500);
        }

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

    // public function add_privacy_policy(Request $request)
    // {
    //     $currentUrl = $request->path();
    //     // Check if the current URL is '/privacy-policy'
    //     if ($currentUrl === 'privacy-policy') {
    //         // Fetch the privacy policy data based on the slug
    //         $privacyPolicy = Pages::where('page_slug', 'privacy-policy')->get();
    //     } else {
    //         // If URL is not '/privacy-policy', fetch all records (or handle as per your requirement)
    //         $privacyPolicy = Pages::where('deleted_at', null)->get();
    //     }

    //     return view('pages.privacy-policy', compact('privacyPolicy'));

    // }

    // public function store_privacy_policy(Request $request)
    // {
    //     //dd($request->only(['page_title', 'description', 'page_slug', 'status', 'is_preview']));
    //     $data = $request->validate([
    //         'page_title' => ['required'],
    //         'description' => ['required'],
    //         'page_slug' => ['required'],
    //         'status' => ['required'],
    //         'is_preview' => ['required'],
    //     ]);

    //     $title = $data['page_title'];
    //     $page_slug = $data['page_slug'];
    //     $status = $data['status'];
    //     $is_preview = $data['is_preview'];

    //     // Fetch the privacy policy record based on the slug
    //     $privacyPolicy = Pages::where('page_slug', $page_slug)->first();

    //     $background_image = isset($privacyPolicy->background_image) ? $privacyPolicy->background_image : null;

    //     // Upload background image if provided
    //     if ($request->hasFile('background_image')) {
    //         $file = $request->file('background_image');
    //         $background_image = $file->getClientOriginalName();
    //         $file->move(public_path('_uploads/bg'), $background_image);
    //     }

    //     if (!$privacyPolicy) {
    //         // If no record exists, create a new one
    //         $privacyPolicy = Pages::create([
    //             'page_title' => $data['page_title'],
    //             'page_slug' =>  $page_slug,
    //             'description' => $data['description'],
    //             'background_image' => $background_image,
    //             'status' => 1,
    //             'is_preview' => $is_preview,
    //         ]);
    //     }else if($privacyPolicy && $data['is_preview']== 1){
    //         $privacyPolicyPreview = Pages::where('page_slug', $page_slug)
    //                       ->where('is_preview', $is_preview)
    //                       ->first();
    //         if (!$privacyPolicyPreview) {
    //             $privacyPolicyPreview = Pages::create([
    //                 'page_title' => $data['page_title'],
    //                 'page_slug' =>  $page_slug,
    //                 'description' => $data['description'],
    //                 'background_image' => $background_image,
    //                 'status' => 1,
    //                 'is_preview' => 1,
    //             ]);
    //         }else{
    //             Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)
    //             ->update([
    //             'page_title' => $data['page_title'],
    //             'description' => $data['description'],
    //             'background_image' => $background_image,
    //             ]);
    //         }
    //     } else {
    //         // If a record exists, update it
    //         Pages::where('page_slug', $page_slug)->update([
    //             'page_title' => $data['page_title'],
    //             'description' => $data['description'],
    //             'background_image' => $background_image,
    //         ]);
    //     }

    //     // You can return a response or redirect as needed
    //     return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'privacyPolicy' => $privacyPolicy], 200);
    // }


    public function update_text_template_pages(Request $request)
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
        $text_temp_data = Pages::where('page_slug', $page_slug)->first();

        $background_image = isset($text_temp_data->background_image) ? $text_temp_data->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }

        if($text_temp_data && $data['is_preview']== 1){
            $text_template_preview_data = Pages::where('page_slug', $page_slug)
                          ->where('is_preview', $is_preview)
                          ->first();
            if (!$text_template_preview_data) {
                $text_template_preview_data = Pages::create([
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
            Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
                'background_image' => $background_image,
            ]);
        }

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'privacyPolicy' => $text_temp_data], 200);
    }


    // public function add_terms_service(Request $request)
    // {
    //     $currentUrl = $request->path();
    //     // Check if the current URL is '/terms-of-service'
    //     if ($currentUrl === 'pages/terms-of-service') {
    //         // Fetch the terms of service data based on the slug
    //         $termsService = Pages::where('page_slug', 'terms-of-service')->first();
    //     }
    //     else {
    //         // If URL is not '/terms-of-service', fetch all records (or handle as per your requirement)
    //         $termsService = Pages::where('deleted_at', null)->get();
    //     }

    //     return view('pages.terms-of-service', compact('termsService'));

    // }


    // public function store_terms_service(Request $request)
    // {
    //     $data = $request->validate([
    //         'page_title' => ['required'],
    //         'description' => ['required'],
    //         'page_slug' => ['required'],
    //         'status' => ['required'],
    //         'is_preview' => ['required'],
    //     ]);

    //     $title = $data['page_title'];
    //     $page_slug = $data['page_slug'];
    //     $status = $data['status'];
    //     $is_preview = $data['is_preview'];

    //     // Fetch the privacy policy record based on the slug
    //     $termsService = Pages::where('page_slug', $page_slug)->first();

    //     $background_image = isset($termsService->background_image) ? $termsService->background_image : null;

    //     // Upload background image if provided
    //     if ($request->hasFile('background_image')) {
    //         $file = $request->file('background_image');
    //         $background_image = $file->getClientOriginalName();
    //         $file->move(public_path('_uploads/bg'), $background_image);
    //     }

    //     if (!$termsService) {
    //         // If no record exists, create a new one
    //         $termsService = Pages::create([
    //             'page_title' => $data['page_title'],
    //             'page_slug' =>  $page_slug,
    //             'description' => $data['description'],
    //             'status' => 1,
    //             'is_preview' => $is_preview,
    //         ]);
    //     }else if($termsService && $data['is_preview']== 1){
    //         $termsServicePreview = Pages::where('page_slug', $page_slug)
    //                       ->where('is_preview', $is_preview)
    //                       ->first();
    //         if (!$termsServicePreview) {
    //             $termsServicePreview = Pages::create([
    //                 'page_title' => $data['page_title'],
    //                 'page_slug' =>  $page_slug,
    //                 'description' => $data['description'],
    //                 'status' => 1,
    //                 'is_preview' => 1,
    //             ]);
    //         }else{
    //             Pages::where('page_slug', $page_slug)->where('is_preview', $is_preview)
    //             ->update([
    //                 'page_title' => $data['page_title'],
    //                 'description' => $data['description'],
    //                 'background_image' => $background_image,
    //             ]);
    //         }
    //     } else {
    //         // If a record exists, update it
    //         Pages::where('page_slug', $page_slug)->update([
    //             'page_title' => $data['page_title'],
    //             'description' => $data['description'],
    //             'background_image' => $background_image,
    //         ]);
    //     }

    //     // You can return a response or redirect as needed
    //     return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'termsService' => $termsService], 200);
    // }


    // public function show_featured(Request $request)
    // {
    //     // You can return a response or redirect as needed
    //     $artistFeatureds = ArtistFeatureds::where('deleted_at', null)->where('is_preview', 0)->orderBy('id', 'ASC')->get();
    //     $artists = Artists::all()->mapWithKeys(function ($artist) {
    //         return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
    //     });
    //     if(count($artistFeatureds) == 0){
    //         $artistFeatureds[] = (object)array('artist_id' => '', 'title' => '', 'video_url' => '', 'description' => '', 'status' => 1);
    //     }

    //     return view('pages.featured', ['artists' => $artists,'artistFeatureds' => $artistFeatureds]);
    // }

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

    public function managePages(Request $request)
    {
        // Retrieve dynamic pages with status = 1 from ManagePages model
        // $managePagesData = ManagePages::where('status', 1)
        // ->whereNotNull('page_slug')
        // ->get()->toArray();
        $managePagesData = ManagePages::where('status', 1)
            ->whereNotNull('page_slug')
            ->get(['id', 'page_title', 'page_slug', 'created_at'])
            ->toArray();

        foreach ($managePagesData as &$managepage) {
            $managepage['custom_slug'] = 'download';
        }

        // Retrieve all dynamic pages from Pages model
        // $pagesData = Pages::where('is_preview', 0)
        //     ->whereNotNull('page_slug')
        //     ->get(['id', 'page_title', 'page_slug', 'created_at'])
        //     ->toArray();

        $pagesData = Pages::where('is_preview', 0)
            ->whereNotNull('page_slug')
            ->get(['id', 'page_title', 'page_slug', 'created_at'])
            ->toArray();

        foreach ($pagesData as &$paged) {
            $paged['custom_slug'] = 'pages';
        }

        // Retrieve all dynamic pages from ArtistFeatureds model
        $artistFeaturedsData = ArtistFeatureds::where('is_preview', 0)
            ->whereNotNull('page_slug')
            ->get(['id', 'page_title', 'page_slug', 'created_at'])
            ->toArray();

        foreach ($artistFeaturedsData as &$artistpage) {
            $artistpage['custom_slug'] = 'artist';
        }

        // Merge the arrays and map the fields accordingly
        // $pages = array_map(function($page) {
        //     // If the page is from ManagePages model, map the fields accordingly
        //     if (isset($page['page_title'])) {
        //         return [
        //             'id' => $page['id'],
        //             'table_name' => 'manage_pages', // Add the table name here
        //             'page_title' => $page['page_title'],
        //             'page_slug' => $page['page_slug'],
        //             'custom_slug' => $page['custom_slug'],
        //             'created_at' => $page['created_at'],
        //             // Add other fields as needed
        //         ];
        //     }
        //     // If the page is from Pages model, map the fields accordingly
        //     elseif (isset($page['page_title'])) {
        //         return [
        //             'id' => $page['id'],
        //             'table_name' => 'pages', // Add the table name here
        //             'page_title' => $page['page_title'],
        //             'page_slug' => $page['page_slug'],
        //             'custom_slug' => $page['custom_slug'],
        //             'created_at' => $page['created_at'],
        //             // Add other fields as needed
        //         ];
        //     }

        // }, array_merge($managePagesData, $pagesData, $artistFeaturedsData));


        $pages = array_map(function($page) {
            // Map the fields accordingly
            return [
                'id' => $page['id'],
                'table_name' => $page['table_name'], // Add the table name here
                'page_title' => $page['page_title'],
                'page_slug' => $page['page_slug'],
                'custom_slug' => $page['custom_slug'],
                'created_at' => $page['created_at'],
                // Add other fields as needed
            ];
        }, array_merge(
            array_map(function($page) {
                $page['table_name'] = 'manage_pages'; // Add table name to the array
                return $page;
            }, $managePagesData),
            array_map(function($page) {
                $page['table_name'] = 'pages'; // Add table name to the array
                return $page;
            }, $pagesData),
            array_map(function($page) {
                $page['table_name'] = 'artist_featureds'; // Add table name to the array
                return $page;
            }, $artistFeaturedsData)
        ));


        return view('pages.manage-pages', compact('pages'));
    }

    public function updatePage(Request $request, $page_slug){
        $page = Pages::where('page_slug', $page_slug)->where('is_preview', 0)->first();
        return view('pages.update-page',compact('page'));
    }

    public function show_template_data(Request $request, $page_slug){
        $download_table = ManagePages::where('page_slug', $page_slug)->where('status', 1)->first();
        $page_table = Pages::where('page_slug', $page_slug)->where('is_preview', 0)->first();
        $video_table = ArtistFeatureds::where('page_slug', $page_slug)->where('is_preview', 0)->get();
        $artists = [];

        if($download_table) {
            $show_temp_data = $download_table;
            $view = 'pages.show-download-template-page';
        } elseif($page_table) {
            $show_temp_data = $page_table;
            $view = 'pages.show-text-template-page';
        } elseif($video_table) {
            $show_temp_data = $video_table;
            $view = 'pages.show-featured-template-page';
            $artists = Artists::all()->mapWithKeys(function ($artist) {
                return [$artist->id => $artist->first_name . ' ' . $artist->last_name];
            });
        } else {
            abort(404);
        }

        $show_temp_data->plateform_name = isset($show_temp_data->plateform_name) ? json_decode($show_temp_data->plateform_name, true) : [];
        $show_temp_data->plateform_file = isset($show_temp_data->plateform_file) ? json_decode($show_temp_data->plateform_file, true) : [];
        $show_temp_data->plateform_status = isset($show_temp_data->plateform_status) ? json_decode($show_temp_data->plateform_status, true) : [];

        return view($view, compact('show_temp_data', 'artists'));
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

    public function deleteDynamicPage(Request $request, $page_slug, $table){
        // Determine the model based on the provided table name
        switch ($table) {
            case 'manage_pages':
                $model = ManagePages::class;
                break;
            case 'pages':
                $model = Pages::class;
                break;
            case 'artist_featureds': // Corrected table name
                $model = ArtistFeatureds::class;
                break;
            default:
                return redirect()->back()->with(['error_msg' => 'Invalid table name']);
        }

        // Delete the page from the appropriate model
        $model::where('page_slug', $page_slug)->delete();
        return redirect()->back()->with(['succ_msg' => 'Page successfully deleted']);
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
            $artists = Artists::all();
            return view('pages.template-featured', compact('artists'));
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
            'page_title' => $data['page_title'],
            'page_slug' => $page_slug,
            'background_image' => $background_image,
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
            ]
        );

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }


    public function update_video_template_data(Request $request){
        $data = $request->all();
        $slug = $data['page_slug'];
        $page_title = $data['page_title'];
        $length = count($request->artist_id);
        $artistFeatureds = ArtistFeatureds::first();
        $background_image = isset($artistFeatureds->background_image) ? $artistFeatureds->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }


        if($request->status == 1){
            ArtistFeatureds::where('page_slug', $slug)->where('is_preview', 0)->delete();
            for($i = 0; $i < $length; $i++){
                $save_artist = ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_title' => $page_title,
                    'page_slug' => $slug,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 0,
                ]);

                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_title' => $page_title,
                    'page_slug' => $slug,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);
            }
        }else{
            ArtistFeatureds::where('page_slug', $slug)->where('is_preview',1)->delete();
            for($i = 0; $i < $length; $i++){
                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_slug' => $slug,
                    'page_title' => $page_title,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);
            }
        }

        return response()->json(['status' => 'success','message' => 'Record Successfully Updated'], 200);
    }

    public function save_template_video(Request $request){
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'page_title' => 'required|string|max:255',
            'page_slug' => 'required|string|max:255',
        ]);

        $length = count($request->artist_id);
        $artistFeatureds = ArtistFeatureds::first();
        $background_image = isset($artistFeatureds->background_image) ? $artistFeatureds->background_image : null;

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $background_image = $file->getClientOriginalName();
            $file->move(public_path('_uploads/bg'), $background_image);
        }


        if($request->status == 1){
            for($i = 0; $i < $length; $i++){
                $save_artist = ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_title' => $request->page_title,
                    'page_slug' => $request->page_slug,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 0,
                ]);

                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_title' => $request->page_title,
                    'page_slug' => $request->page_slug,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);
            }
        }else{
            ArtistFeatureds::where('is_preview',1)->delete();
            for($i = 0; $i < $length; $i++){
                ArtistFeatureds::create([
                    'artist_id' => $request->artist_id[$i],
                    'page_title' => $request->page_title,
                    'page_slug' => $request->page_slug,
                    'title' => $request->featured_title[$i],
                    'video_url' => $request->video_link[$i],
                    'description' => $request->disclaimer[$i],
                    'background_image' => $background_image,
                    'status' => $request->featured_status[$i],
                    'is_preview' => 1,
                ]);
            }
        }

        return response()->json(['status' => 'success','message' => 'Record successfully Added'], 200);
    }

    public function all_artists(Request $request)
    {
        $allartists = Artists::all();
        return view('pages.video-types', compact('allartists'));
    }

    public function deleteArtist(Request $request, $artist_id)
    {
        Artists::where('id',  $artist_id)->delete();
        return redirect()->back()->with(['succ_msg' => 'Page successfully deleted']);
    }


    public function update_video_type(Request $request,$video_type_id){
    	if($request->isMethod('get')){
    		$video_type = Artists::where('id',$video_type_id)->first();
    		return view('pages.update-video-type',compact('video_type'));
    	}else{
            $request->validate([
	            'name' => 'required',
	        ]);
            $update['first_name'] = $request->name;

            Artists::where('id',$video_type_id)->update($update);
		    return redirect()->back()->with('success', 'Updateded successfully!');
    	}
    }
}
