<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public $pagination = 10;
	public function get_data_curl($url=NULL,$params=NULL){
		$params['user_key']='f49d23f5aa4dc6080f70d36c5a07a535';		
	}

	
}
