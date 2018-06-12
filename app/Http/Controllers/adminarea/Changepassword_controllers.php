<?php

namespace App\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Custom;
use Image;
use Session;
use DB;
use Mail;

use App\Http\Models\User;
use App\Http\Models\Adminmenu;
use App\Http\Models\Frm_contactus;

class Changepassword_controllers extends Controller
{
	public function index(Request $request)
	{
		return view('adminarea.change_password');
	}
	
	public function change_password(Request $request)
	{

		// Server Side Validation
		$this->validate($request,array('oldpassword'=>'required',
									   'newpassword'=>'required|same:confirmpassword',
									   'confirmpassword'=>'required'
									  ));

		$oldpassword=$request->oldpassword;
		$newpassword=$request->newpassword;
		$confirmpassword=$request->confirmpassword;
		$userID=Session::get('admin_user');

		$getpassword=array('password'=>md5($oldpassword),'userID'=>$userID);
		$resultUser = User::where($getpassword)->first();
	
		if(count($resultUser) > 0){
			$newpasswordData=array('password'=>md5($newpassword));
			$userID=User::where('userID',$userID)->update($newpasswordData); 
			return Redirect::away(url('/').'/adminarea/changepassword')->with(array('flash_message' => 'Your password has been Updated.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	
		}else{
			return Redirect::away(url('/').'/adminarea/changepassword')->withErrors(array('flash_message' => 'Current password not match.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
		}
		
	}

	function checkpassword(Request $request)
	{
		$oldpassword=$request->oldpassword?$request->oldpassword:'';
		$userID=Session::get('admin_user');
		$getpassword=array('password'=>md5($oldpassword),'userID'=>$userID);
		$resultUser = User::where($getpassword)->first();

		if(count($resultUser) > 0){
			$valid=true;
		}else{
			$valid=false;
		}
		
		echo json_encode(array(
			'valid' => $valid,
		));
	}
}
