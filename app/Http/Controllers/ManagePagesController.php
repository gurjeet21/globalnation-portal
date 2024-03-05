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
        if ($request->file('plateform_file')) {
            foreach($request->file('plateform_file') as $key => $file){                 
                    $imageName = time().'_'. $key . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('download'), $imageName);              
                    $plateform_file[] = $imageName;                   
             }
        }        
        ManagePages::updateOrCreate(
            ['slug' => Str::slug($data['page_title'], '-')],
            [
            'title' => $data['page_title'],
            'slug' => Str::slug($data['page_title'], '-'),
            'plateform_name' => json_encode($data['plateform_name']),
            'plateform_file' => json_encode($plateform_file),
            'plateform_status' => json_encode($data['plateform_status']),
            'disclaimers' => $data['content'],
        ]);

        return response()->json(['status' => 'success','message' => 'Record updated successfully'], 200);
       
    }
}
