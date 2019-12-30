<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Mail;
 

use PDF; 
 
use File;

use App\Page;
use App\UserPrivilege;
use App\User;
 
use App\Employee;
 

use App\Products;

use Hash;
use Auth;
use DB;
use Session;
use Carbon\Carbon;
date_default_timezone_set('Asia/Colombo');
//use App\Http\Resources\ConfigEnv;

class MainController extends Controller {

    public function __construct(){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
        $this->middleware(['auth:api','cors'])->except('index','login','register','users','read_pages','fetch_privileges','runtime_privileges','profile','appointment','patient_register','invoice');
		//new ConfigEnv(); 
    }
 
     
public function search_product(Request $request){
    $request_data=array();
    foreach($request->all() as $property => $value){
      $request_data[$property]=json_decode($value);	
    }			
	$data =  Products::orderBy('product_id','ASC')->where([['title','like','%'.$request_data['keyword'].'%'],['status_id','=','1']])->get();	  
	foreach($data as $row){
	   	  
	}
    echo json_encode($data);			  
}	
 
 
    public function index()
    {
		if(Auth::check()){			
          $pack = $this->fetch_privileges();             
          return view('dashboard')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
		}else{			 
		  return $this->login();	
		} 
    } 
	
    public function invoice()
    {
		if(Auth::check()){			
          $pack = $this->fetch_privileges();             
          return view('invoice')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
		}else{			 
		  return $this->login();	
		} 
    } 	
	
    public function login()
    {
		if(Auth::check()){
		  return $this->index();	
		}else{
          return view('in');		 			
		}           
    }

    public function register()
    {
		
       if(Auth::check()){
          $pack = $this->fetch_privileges();   
		  return view('register')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
	   }else{
		  return $this->login();	
	   }
    }	
	
    public function profile()
    {
       if(Auth::check()){
          $pack = $this->fetch_privileges();   
		  return view('profile')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
	   }else{
		  return $this->login();	
	   }
    }	
	
  	 
 
	
    public function users()
    {
		 
		if(Auth::check()){			 
          $pack = $this->fetch_privileges();		   
          return view('users')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
		}else{
		  return $this->login();	
		}
    }
	
    public function appointment()
    {
		 
		if(Auth::check()){			 
          $pack = $this->fetch_privileges();		   
          return view('appointment')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
		}else{
		  return $this->login();	
		}
    }

    public function patient_register()
    {
		 
		if(Auth::check()){			 
          $pack = $this->fetch_privileges();		   
          return view('patient-register')->with('privileges', $pack['privileges'])->with('privileges_subs', $pack['privileges_subs']);
		}else{
		  return $this->login();	
		}
    }	
	
	
	 

    public function read_pages(Request $request)
    {
        $request_data=array();
        foreach($request->all() as $property => $value){
          $request_data[$property]=json_decode($value);	
        }

		$privileges_row = array();
        $privileges_defined = UserPrivilege::where('user_id',$request_data['user_id'])->get();	 
		foreach($privileges_defined as $row){
			$privileges_row[] = $row->page_id;
		}		
		
		
		$privileges = Page::where('visibility','public')->orderBy('page_id','ASC')->get();	
		 
		
		
		foreach($privileges as $privilege){
			   
			  
			  
			  
			  if(in_array($privilege->page_id,$privileges_row)){
			    $privilege->status = "checked";				  
			  }else{
			    $privilege->status = "";				  
			  }

		}
		
		
		
		
		echo json_encode($privileges);

		
	}



    public function runtime_privileges($function,$user_id){
      $status = false;
	  $page = Page::where('function',$function)->first(); 
	  $privilege = UserPrivilege::where('user_id',$user_id)->get();
	  if(count($privilege) > 0 ){  
	    foreach($privilege as $row){
		  if($row->page_id == $page->page_id){
			$status = true;  
		  }
	    }
	  }
	  return $status;
    } 


    public function fetch_privileges(){
	    $pack = array();	
	  	
        $privileges_subs = array();	
        $privileges_subs['page_id'] = array();
        $privileges_subs['parent'] = array();              		  
        $privileges_subs['title'] = array(); 
        $privileges_subs['icon'] = array();
        $privileges_subs['url'] = array();

		$privileges = UserPrivilege::where('user_id',Auth::user()->id)->orderBy('page_id','ASC')->get();
         
        $ids = array();		 
		foreach($privileges as $privilegex){
	      $ids[] = $privilegex->page_id;
		}
		
		  foreach($privileges as $privilege){
		    $page = Page::where('page_id',$privilege->page_id)->first();
			if(count($page)>0){
			  $privilege->title = $page->title; 
			  $privilege->icon = $page->icon; 
			  $privilege->url = $page->url; 
			  $privilege->function = $page->function;

              $childs = Page::where('parent',$privilege->page_id)->get();
              if($childs->count() > 0){
                $privilege->parent = 'Y';
			    foreach($childs as $child){					
				  if(in_array($child->page_id,$ids)){	
                  $privileges_subs['page_id'][] = $child->page_id;
                  $privileges_subs['parent'][] = $child->parent;              		  
                  $privileges_subs['title'][] = $child->title; 
                  $privileges_subs['icon'][] = $child->icon;
                  $privileges_subs['url'][] = $child->url;				  
				  }
			    }			  
			  }else{
			      $privilege->parent = 'N';
			  } 
			}
		  }		
		$privileges = $privileges->toArray();		
		$pack['privileges'] =  $privileges;
		$pack['privileges_subs'] =  $privileges_subs;		
				
	  return $pack;	
	}    


    public function carbon_diff($created_at){
      $created_at = new Carbon($created_at);
      $date_now = Carbon::now();

      if($created_at->diff($date_now)->days < 7){
	    return $timestamps = $created_at->diffForHumans($date_now);
      } 
      if($created_at->diff($date_now)->days > 7){
        $date=new \DateTime($created_at);
        return $date->format('Y').' '.$date->format('M').' '.$date->format('d').' '.$date->format('h').':'.$date->format('i').' '.$date->format('A');
      } 
    }	
	
 	
	
	 



}