<?php
//===================================  Code Complete ======================================//
//																						   //
//				Some Function In "Custom Funcation" Pelase check it.					   //
//				like checkcaptcha(); checkReferrerUrl();				   				   //
//				path :vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php //
//																						   //
//===================================  Code Complete ======================================//

	  use App\Http\Models\Frm_contactus;
	  use App\Http\Models\Emailautoresponse;
	  use App\Http\Models\Adminemail;
	  use App\Http\Models\Emailsetting;
	  use Vinkas\Laravel\Recaptcha\ServiceProvider;
	  use Illuminate\Support\Facades\Redirect;
	  use Illuminate\Support\Facades\Custom;
	  Redirect::checkReferrerUrl(); //Redirection happen when direct access by page
	  
	  // Server Side Validation
	  $this->validate($request,array('firstName'=>'required','lastName'=>'required','phone'=>'required','comment'=>'required','email'=>'required|email'));
	  
	  $firstName=$request->firstName?$request->firstName:'';
	  $lastName=$request->lastName?$request->lastName:'';
	  $email=$request->email?$request->email:'';
	  $phone=$request->phone?$request->phone:'';
	  $comment=$request->comment?$request->comment:'';
	  

	 //Check Captcha [START]
	  if(\Config::get('config.checkCaptcha', '1')==1){
		  $this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
		  $recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
		  //Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
	  }
	 //Check Captcha [END]
	  
	  /* Get IP & MacID [START]*/ 
	  $ip=$_SERVER['REMOTE_ADDR'];
	  $MacID=$ip;
	  /* Get IP & MacID [END]*/
	  
	  $contactsData=array(
					'firstName'=>$firstName,
					'lastName'=>$lastName,
					'email'=>$email,
					'phone'=>$phone,
					'comment'=>$comment,
					'ip'=>$ip,
					'isActive'=>1
					);
	  $frm_contactus= new Frm_contactus($contactsData);
	  $frm_contactus->save();
	  
	  $formData=array('formID'=>\Config::get('config.contactusFormID'));
	  
	  /*======================================*/
	  //  Email Sent To Customer  [START]
	  /*======================================*/
	  $emailautoresponse= new Emailautoresponse;
	  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
	  
	  if($autoResponceResult['recordCount'] > 0){
		  
		  $subject = $autoResponceResult['data'][0]->subject;
		  $msg = $autoResponceResult['data'][0]->message1;
		  
			//$from="parth.hrinfocare@gmail.com";
		  $from=\Config::get('config.fromEmail','parth.hrinfocare@gmail.com');
		  $name=\Config::get('config.fromEmailName');
		  $to=$email;
		 
		if(\Config::get('config.sendEmail')==1){
			  
			$emailData=array(
								'name'=>$name,
								'from'=>$from,
								'to'=>$to,
								'subject'=>$subject,
								'message'=>$msg
							);
			Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php

		}
	  }
	  /*======================================*/
	  //  Email Sent To Customer  [END]
	  /*======================================*/
	  
	  /*======================================*/
	  //  Email Sent To Admin  [START]
	  /*======================================*/
	  $adminemail= new Adminemail;
	  $sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
	  
	  if($sqlAdminEmailResult['recordCount'] > 0){
		  $adminsubject = $sqlAdminEmailResult['data'][0]->adminsubject;
		  $adminemailcontent = $sqlAdminEmailResult['data'][0]->adminemail;
		  $adminemailcontent = str_replace('{var_firstName}',$request->firstName,$adminemailcontent);
		  $adminemailcontent = str_replace('{var_lastName}',$request->lastName,$adminemailcontent);
		  $adminemailcontent = str_replace('{var_email}',$request->email,$adminemailcontent);
		  $adminemailcontent = str_replace('{var_phone}',$request->phone,$adminemailcontent);
		  $adminemailcontent = str_replace('{var_comment}',$request->comment,$adminemailcontent);
		  
	  
		  $emailsettingData=array('formID'=>\Config::get('config.contactusFormID'),'emailType'=>1,'isActive'=>1);
		  
		  $emailsetting= new Emailsetting;
		  $sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
	  
		  foreach($sqlmail['data'] as $adminemail) {
				  $adminTo= $adminemail->email;
				  $from=\Config::get('config.fromEmail');
				  $name=\Config::get('config.fromEmailName');
				  $to=$adminTo;
				  
				  if(\Config::get('config.sendEmail')==1){
					  
					  $emailData=array(
								'name'=>$name,
								'from'=>$from,
								'to'=>$to,
								'subject'=>$adminsubject,
								'message'=>$adminemailcontent
							);
					 Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
								  
				  }
		  }
	  }
	  /*======================================*/
	  //  Email Sent To Admin  [END]
	  /*======================================*/
	  
	  $_POST['formID']=\Config::get('config.contactusFormID');
	  return Redirect::fun_redirect(url('/').'/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	  
?>