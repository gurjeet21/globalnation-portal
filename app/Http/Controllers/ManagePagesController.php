<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagePages;
use App\Models\Pages;
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

        if (!$privacyPolicy) {
            // If no record exists, create a new one
            $privacyPolicy = Pages::create([
                'page_title' => $data['page_title'],
                'page_slug' =>  $page_slug,
                'description' => $data['description'],
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
                    'status' => 1,
                    'is_preview' => 1,
                ]);
            }else{
                $privacyPolicyPreview->update([
                    'page_title' => $data['page_title'],
                    'description' => $data['description'],
                ]);
            }
        } else {
            // If a record exists, update it
            $privacyPolicy->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
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
                $termsServicePreview->update([
                    'page_title' => $data['page_title'],
                    'description' => $data['description'],
                ]);
            }
        } else {
            // If a record exists, update it
            $termsService->update([
                'page_title' => $data['page_title'],
                'description' => $data['description'],
            ]);
        }

        // You can return a response or redirect as needed
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully', 'termsService' => $termsService], 200);
    }


    public function show_featured(Request $request)
    {
        // You can return a response or redirect as needed
        return view('pages.featured');
    }
}
