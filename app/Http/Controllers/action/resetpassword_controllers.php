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
	use App\Http\Models\Pages;
	use Vinkas\Laravel\Recaptcha\ServiceProvider;
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Custom;
	Redirect::checkReferrerUrl(); //Redirection happen when direct access by page

	// Server Side Validation
	$this->validate($request,array('new_password'=>'required|same:confirm_password',
								   'confirm_password'=>'required',
								   //'g-recaptcha-response' => 'required|recaptcha'
								));

	//Check Captcha [START]
	if(\Config::get('config.checkCaptcha', '1')==1){
		$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
		$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
		//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
	}
	//Check Captcha [END]

	$confirm_password=$request->confirm_password?$request->confirm_password:'';
	$new_password=$request->new_password?$request->new_password:'';
	$md5customerID=$request->md5customerID?$request->md5customerID:'';
	$hashkey=$request->hashkey?$request->hashkey:'';

	$customerData=array('md5(customerID)'=>$md5customerID,'isActive'=>1);
	$Customer=new Customer;
	$resultCustomer=$Customer->getByAttributesQuery($customerData);
	
	$customerID=$resultCustomer['data'][0]->customerID;

	$newpasswordData=array('password'=>md5($new_password),'customerID'=>$customerID);
	$customerID=Customer::where('customerID',$customerID)->update($newpasswordData); 
	
	/*======================================*/
	//  for Email Templet  [START]	    //
	/*======================================*/
	$Pages=new Pages;
	$pageData = array('pageFileName'=>"email_templarte");
	$pageResult=$Pages->getByAttributesQuery($pageData);

	$emailTemplate = $pageResult['data'][0]->pageContent;
	/*======================================*/
	//  for Email Templet [END]	        //
	/*======================================*/


	/*======================================*/
	//  Email Sent To Customer  [START]
	/*======================================*/
	$formData=array('formID'=>\Config::get('config.resetpasswordFormID',10));

	$emailautoresponse= new Emailautoresponse;
	$autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
	
	if($autoResponceResult['recordCount'] > 0){
		
		$subject = $autoResponceResult['data'][0]->subject;
		$msg = $autoResponceResult['data'][0]->message1;
		$msg = str_replace('{VAR_CUSTOEMERNAME}',$resultCustomer['data'][0]->firstName.' '.$resultCustomer['data'][0]->lastName,$msg);
		$msg = str_replace('{VAR_CONTENT}',$msg,$emailTemplate);
 
		$from=\Config::get('config.fromEmail');
		$name=\Config::get('config.fromEmailName');
		$to=$resultCustomer['data'][0]->email;
		
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

	return Redirect::away(url('/').'/login-registration')->with(array('flash_message' => 'Your password has been Updated.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

	
?>