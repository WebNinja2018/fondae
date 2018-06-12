<?php 
//===================================  Code Complete ======================================//
//																						   //
//				Check By Ranjit. Don't Change.anythig without asking senior.			   //
//				Some Function In "Custom Helper" Pelase check it.						   //
//				like checkcaptcha(); sendCustomerEmail();,sendAdminEmail()				   //
//				path : system\helpers\ folder "custom_helper.php"						   //
//																						   //
//===================================  Code Complete ======================================//

	use App\Http\Models\Customer;
	use App\Http\Models\Emailautoresponse;
	use App\Http\Models\Adminemail;
	use App\Http\Models\Emailsetting;
	use Vinkas\Laravel\Recaptcha\ServiceProvider;
	Redirect::checkReferrerUrl(); //Redirection happen when direct access by page

	// Server Side Validation
	$this->validate($request,array('password'=>'required',
								   'new_password'=>'required|same:confirm_password',
								   'confirm_password'=>'required',
								   //'g-recaptcha-response' => 'required|recaptcha'
								));

	$password=$request->password?$request->password:'';
	$confirm_password=$request->confirm_password?$request->confirm_password:'';
	$new_password=$request->new_password?$request->new_password:'';
	$customerID=Session::get('customerID');

	$getpassword=array('password'=>md5($password),'customerID'=>$customerID);
	$resultCustomer = Customer::where($getpassword)->first();
	
	if(count($resultCustomer) > 0){
		$newpasswordData=array('password'=>md5($new_password),'customerID'=>$customerID);
		$customerID=Customer::where('customerID',$customerID)->update($newpasswordData); 
		return Redirect::away(url('/').'/change-password')->with(array('flash_message' => 'Your password has been Updated.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

	}else{
		return Redirect::away(url('/').'/change-password')->withErrors(array('flash_message' => 'Current password not match.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}

	
?>