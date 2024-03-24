<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagePages;
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
        // $validator = validator()->make(request()->all(),
        // [
        //     'plateform_name' => 'required',
        //     'disclaimers' => 'required',
        // ]);
        // if ($validator->fails()) {
        //      return response()->json(['status' => 'error','message' => $validator->messages()], 200);
        // }
        $data = $request->all();
        $plateform_file = [];
        $total_plateform = count($data['plateform_name']);
        if($total_plateform > 0){
            for ($x = 0; $x < $total_plateform; $x++) {
            $key_name = 'plateform_file_'.$x;
                if ($request->hasFile($key_name)) {
                        $file = $request->file($key_name);
                        $imageName = time().'_'. $x . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('_uploads/builds'), $imageName);
                        $plateform_file[] = $imageName;
                }else{
                    $plateform_file[] = $data['plateform_file_hidden'][$x];
                }
            }
        }

        $background_image = '';

        // Upload background image if provided
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $imageName = time() . '_background.' . $file->getClientOriginalExtension();
            $file->move(public_path('_uploads/builds'), $imageName);
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
            $page_id = 3;
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
            $key_name = 'plateform_file_'.$x;
                if ($request->hasFile($key_name)) {
                        $file = $request->file($key_name);
                        $imageName = $file->getClientOriginalName();
                        $plateform_file[] = $imageName;
                }else{
                    $plateform_file[] = $data['plateform_file_hidden'][$x];
                }
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
            // Check if a file with the same name already exists
            $existingFilePath = public_path('_uploads/builds/' . $file->getClientOriginalName());
            if (file_exists($existingFilePath)) {
                // Delete the existing file
                unlink($existingFilePath);
            }
            $file->move(public_path('_uploads/builds'), $file->getClientOriginalName());

            echo "File Uploaded new";
        } else {
            echo "File Not Uploaded";
        }
    }
}
