<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

date_default_timezone_set('Asia/Colombo');
//use App\Http\Resources\ConfigEnv;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
    function __construct()
    {
      //define('ADMIN_MAIL','hse.cict@cict.lk');        	  
    }	
	
	
}
