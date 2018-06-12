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
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Custom;
	
	Redirect::checkReferrerUrl(); //Redirection happen when direct access by page

	$check = true;


	// Server Side Validation
	$this->validate($request,array('email'=>'required|exists:customer,email'));

$Customer = Customer::where('email',$request->email)->first();
if($Customer)
{
	$token = str_random(128);
	\App\Http\Models\PasswordRest::create([
		'email' => $request->email,
		'token' => $token,
	]);

	Mail::send("emails.forgot-password", [
		'token' => $token,

	], function ($m) use($Customer) {
		$m->to($Customer->email)->subject('Reset Password');

	});

	return Redirect::away(url('/').'/login-registration')->with(array('flash_message' => 'Check your email and change your password .'))->send();
}

	//Check Captcha [START]
	if(\Config::get('config.checkCaptcha', '1')==1){
		$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
		$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
		//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
	}
	//Check Captcha [END]

	$email=$request->email?$request->email:'';
	$redirects_to=$request->redirects_to?$request->redirects_to:'';
	
	$customerData=array('email'=>$email);
	$resultCustomer = Customer::where($customerData)->first();

	if(count($resultCustomer) > 0){   /*record count is 0 then not send reset password mail*/
		
		 $formData=array('formID'=>\Config::get('config.forgotpasswordFormID',9));
	  
		  /*======================================*/
		  //  Email Sent To Customer  [START]
		  /*======================================*/
		  $emailautoresponse= new Emailautoresponse;
		  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
		  
		  if($autoResponceResult['recordCount'] > 0){
			  
			  $subject = $autoResponceResult['data'][0]->subject;
			  $msg = $autoResponceResult['data'][0]->message1;
			  $msg = str_replace('{VAR_CUSTOEMERNAME}',$resultCustomer->firstName.' '.$resultCustomer->lastName,$msg);
			  $msg = str_replace('{VAR_RESETPASSWORDLINK}',url('/').'/reset-password?customerID='.md5($resultCustomer->customerID).'&hashkey='.md5(date('Ymd',strtotime('now'))),$msg);
			 	
			  $from=\Config::get('config.fromEmail');
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
	}
	else
	{
		$check = false;
		$flash_message="Please check your Username and Password.";
	}

	if (!$check)
	{
		return Redirect::away(url('/').'/login-registration')->withErrors(array('flash_message' => $flash_message))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}		
	

?>