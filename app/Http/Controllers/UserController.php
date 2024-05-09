<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\ManagePages;
use DB;
class UserController extends Controller
{
    public function index(Request $request){
		$currentPage = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 10);
    	$auth_user = \Auth::user()->role;
    	$auth_user_id = \Auth::user()->id;
    	if($auth_user == 'Super Admin'){
    		$users = User::paginate($itemsPerPage);
    	}else{
    		$users = User::where('role','!=','Super Admin')->paginate($itemsPerPage);
    	}

    	return view('pages.users',compact('users','itemsPerPage'));
    }

    public function dashboard_count(){
    	$total_users = DB::table('users')->count();
        $total_admins = DB::table('users')->where('role', 'Admin')->count();
        $total_Creators = DB::table('users')->where('role', 'Creators')->count();
        $total_viewer = DB::table('users')->where('role', 'Viewer')->count();

	    return view('dashboard',compact('total_users', 'total_admins', 'total_Creators', 'total_viewer'));
    }

    public function add_user(Request $request){
    	if($request->isMethod('get')){
    		return view('pages.add-user');
    	}else{
    		$request->validate([
	            'email' => 'required|email|unique:users',
	        ]);

	        $user = new User([
	            'email' => $request->input('email')
	        ]);
			$user->role = 'Creators';
	        $user->save();
	        $user_id = $user->id;
	        return redirect()->route('user.update',['user_id'=>$user_id])->with('success', 'User created successfully!');
    	}
    }

    public function update_user(Request $request,$user_id){

    	if($request->isMethod('get')){
    		$user_detail = User::where('id',$user_id)->first();
			if(\Auth::user()->role == 'Admin' && $user_detail->role == 'Admin' || \Auth::user()->role == 'Creators'){
				abort(404);
			}
    		return view('pages.update-user',compact('user_detail'));
    	}else{

    		// dd($request->all());
    		$request->validate([
	            'name' => 'required',
                'user_role' => 'required',
	            'email' => [
	                'required',
	                'email',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	            'phone' => [
	                'required',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	        ]);
	       	$update['name'] = $request->name;
	        $update['first_name'] = $request->first_name;
	        $update['last_name'] = $request->last_name;
	        $update['email'] = $request->email;
			$update['phone'] = $request->phone;
			$update['role'] = $request->user_role;
	        $update['dial_code'] = $request->dial_code;
	        $update['designation'] = $request->designation;

	        if ($request->filled('password')) {
	            $update['password'] = bcrypt($request->password);
	        }

	        if ($request->hasFile('img')) {
	            $image = $request->file('img');
	            $imageName = time() . '.' . $image->getClientOriginalExtension();
	            $image->move(public_path('user_image'), $imageName);
	            $update['img'] = $imageName;
	        }

	        if($request->is_remove == 1){
	        	$update['img'] = '';
	        }

	        User::where('id',$user_id)->update($update);
		    return redirect()->back()->with('success', 'User updated successfully!');

    	}
    }


    public function update_my_profile(Request $request){
    	$user_id = \Auth::id();
    	if($request->isMethod('get')){
   			$user_detail = User::where('id',$user_id)->first();
    		return view('pages.update-my-profile',compact('user_detail'));
    	}else{
    		 $request->validate([
	            'name' => 'required',
	            'email' => [
	                'required',
	                'email',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
	            'phone' => [
	                'required',
	                'regex:/^[0-9]{10,15}$/',
	                Rule::unique('users')->ignore($user_id,'id'),
	            ],
        ]);


       	$update['name'] = $request->name;
        $update['first_name'] = $request->first_name;
        $update['last_name'] = $request->last_name;
        $update['email'] = $request->email;
        $update['phone'] = $request->phone;

        if ($request->filled('password')) {
            $update['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user_image'), $imageName);
            $update['img'] = $imageName;
        }

        if($request->is_remove == 1){
        	$update['img'] = '';
        }

        User::where('id',$user_id)->update($update);
	    return redirect()->back()->with('success', 'User updated successfully!');

    	}
    }

    public function delete_user(Request $request,$user_id){
    	$user_detail = User::where('id',$user_id)->delete();
    	return redirect()->back()->with(['succ_msg'=>'User sucessfully deleted']);
    }

    /* Download Page function */
    // public function downloads()
    // {
	// 	$download = ManagePages::first();
	// 	$download->plateform_name = isset($download->plateform_name) ? json_decode($download->plateform_name, true) : [];
	// 	$download->plateform_file = isset($download->plateform_file) ? json_decode($download->plateform_file, true) : [];
	// 	$download->plateform_status = isset($download->plateform_status) ? json_decode($download->plateform_status, true) : [];
    //     return view('pages.downloads',compact('download'));
    // }

    /* Download Page function */
    // public function downloads_test()
    // {
	// 	$download_test = ManagePages::find(2);
	// 	$download_test->plateform_name = isset($download_test->plateform_name) ? json_decode($download_test->plateform_name, true) : [];
	// 	$download_test->plateform_file = isset($download_test->plateform_file) ? json_decode($download_test->plateform_file, true) : [];
	// 	$download_test->plateform_status = isset($download_test->plateform_status) ? json_decode($download_test->plateform_status, true) : [];
    //     return view('pages.downloads-test',compact('download_test'));
    // }

    /* Download Page function */
    public function interocitor()
    {
        return view('pages.interocitor');
    }

}
