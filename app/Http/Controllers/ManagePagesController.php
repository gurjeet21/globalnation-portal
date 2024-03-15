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
        
        $status = $data['status'];
        $page_id = $data['page_id'];
        if($status == 2){
            $page_id = 3;  
        }

        ManagePages::updateOrCreate(
            ['id' => $page_id],          
            [
            'title' => $data['page_title'],
            'slug' => Str::slug($data['page_title'], '-'),
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

        $status = $data['status'];
        $page_id = $data['page_id'];
        $page_id = $data['page_id'];
        if($status == 2){
            $page_id = 4;  
        }

        ManagePages::updateOrCreate(
            ['id' => $page_id],
            [
            'title' => $data['page_title'],
            'slug' => Str::slug($data['page_title'], '-'),
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['disclaimers'],
            'status' => $status
        ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);

    }
}
