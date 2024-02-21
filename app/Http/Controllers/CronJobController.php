<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CronJobController extends Controller
{
		public function index(){
			return view('pages.cronjob');
		}
		
	 
	 
	 public function Get_regions()
    {
		$url="https://api.wheel-size.com/v2/regions/";
        $data=$this->get_data_curl($url);
		echo "<pre>";print_r($data);die;
    } 
	
	
	public function Get_by_rim_search_modifications()
    { 
	
		(isset($_GET['make'])) ? $make=$_GET['make'] : $make='19';
 		(isset($_GET['model'])) ? $model=$_GET['model'] : $model='7.5';
 		(isset($_GET['bolt_pattern'])) ? $bolt_pattern=$_GET['bolt_pattern'] : $bolt_pattern='38';
 		(isset($_GET['rim_diameter_min'])) ? $rim_diameter_min=$_GET['rim_diameter_min'] : $rim_diameter_min='225';
 		(isset($_GET['rim_diameter_max'])) ? $rim_diameter_max=$_GET['rim_diameter_max'] : $rim_diameter_max='50';
 		(isset($_GET['rim_width_min'])) ? $rim_width_min=$_GET['rim_width_min'] : $rim_width_min='2';
 		(isset($_GET['rim_width_max'])) ? $rim_width_max=$_GET['rim_width_max'] : $rim_width_max='10';
  		 
		$param['make']=$make;
		$param['model']=$model;
		$param['bolt_pattern']=$bolt_pattern;
		$param['rim_diameter_min']=$rim_diameter_min;
		$param['rim_diameter_max']=$rim_diameter_max;
		$param['rim_width_min']=$rim_width_min;
		$param['rim_width_max']=$rim_width_max;
 		$param['limit']='10';
 		$param['offset']='0';  
		$url="https://api.wheel-size.com/v2/by_rim/search/modifications/";
        $data=$this->get_data_curl($url,$param);
		echo "<pre>Parameters: <br>";
		print_r($param);
		echo "Response: <br>";
		print_r($data);die;
    }
	
}

	
