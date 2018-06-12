<?php

use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;
use Vinkas\Laravel\Recaptcha\ServiceProvider;

Redirect::checkReferrerUrl(); // checkReferrerUrl Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

// Server Side Validation
$this->validate($request,array('email'=>'required|email|exists:frm_mailing_list,email'));
$email=$request->email?$request->email:'';

//Check Captcha [START]
if(\Config::get('config.checkCaptcha', '1')==1){
	$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
	$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
	//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
}
//Check Captcha [END]

$enewsletterData=array('email'=>$email);
$frm_mailing_list= new Frm_mailing_list;
$frm_mailing_list->where($enewsletterData)->delete();
return Redirect::away(url('/un-subscribe'))->with(array('flash_message' => 'Your Email ID Un-Subscribe Successfully.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

?>