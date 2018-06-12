<?php

use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;

if($request->newsletters_open==1)
{
	return Redirect::to(url('/').'/newsletter')->withInput()->with(array('flash_message' => ''));
	
}else{
	
	Redirect::checkReferrerUrl(); // checkReferrerUrl Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	
	// Server Side Validation
	$this->validate($request,array('email'=>'required|email'));
	$email=$request->email?$request->email:'';
	$recaptcha = Input::get('g-recaptcha-response');
	
	if(strlen($recaptcha)==0 && \Config::get('config.checkCaptcha', '1')==1)
	{
		return Redirect::back()->withInput()->with(array('flash_message' => 'Invalid Captcha'));
	}
	else
	{
		if(\Config::get('config.checkCaptcha', '1')==1){
			//Check Google Captcha
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
						"secret=".\Config::get('config.CaptchaSecretKey')."&response=".$recaptcha."&ipaddr=".$_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close ($ch);
			$obj = json_decode($server_output);
			$obj_success =$obj->{'success'};
		}else{
			$obj_success=1;
		}
		 if($obj_success==1)
		{
			
			// Get IP & MacID START
			$ip=$_SERVER['REMOTE_ADDR'];
			$MacID=$ip;
			// Get IP & MacID END
			
			$enewsletterData=array('mailingID'=>0,
								'email'=>$email,
								'isActive'=>1,
								'ip'=>$ip,
								'MacID'=>$MacID);
			$frm_mailing_list= new Frm_mailing_list($enewsletterData);
			$frm_mailing_list->save();

			$formData=array('formID'=>\Config::get('config.enewsletterFormID'));
			
			/*======================================*/
			//  Email Sent To Customer  [START]
			/*======================================*/
			$emailautoresponse= new Emailautoresponse;
			$autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
			
			if($autoResponceResult['recordCount'] > 0){
				
				$subject = $autoResponceResult['data'][0]->subject;
				$msg = $autoResponceResult['data'][0]->message1;
				
				$from=\Config::get('config.fromEmail');
				$name=\Config::get('config.fromEmailName');
				if(strlen(trim(\Config::get('config.developerEmail')))> 0){
					$to=\Config::get('config.developerEmail');
				}else{
					$to=$email;
				}
				
				if(\Config::get('config.sendEmail')==1){
					
					Mail::send($msg, array('name' => $name), function($message)
					{
						$message->from($from);
						$message->to($to)->subject($subject);
					});
					
					
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
				$adminemailcontent = str_replace('{var_email}',$request->email,$adminemailcontent);
				
				$emailsettingData=array('formID'=>\Config::get('config.enewsletterFormID'),'emailType'=>1,'isActive'=>1);
				
				$emailsetting= new Emailsetting;
				$sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);

				foreach($sqlmail['data'] as $adminemail) {
						$adminTo= $adminemail->email;
						$from=\Config::get('config.fromEmail');
						$name=\Config::get('config.fromEmailName');
						
						if(strlen(trim(\Config::get('config.developerEmail')))> 0){
							$to=\Config::get('config.developerEmail');
						}else{
							$to=$adminTo;
						}
						
						if(\Config::get('config.sendEmail')==1){
							
							$sent = Mail::send($adminemailcontent, array('name' => $name), function($message)
							{
								$message->from($from);
								$message->to($to)->subject($adminsubject);
							});
										
						}
				}
			}
			/*======================================*/
			//  Email Sent To Admin  [END]
			/*======================================*/
			
			$_POST['formID']=\Config::get('config.enewsletterFormID');
			return Redirect::fun_redirect(url('/').'/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
		}
		else
		{
		   return Redirect::back()->withInput()->with(array('flash_message' => ''));
		}
	}

}

?>