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
	$this->validate($request,array('firstName'=>'required',
								   'lastName'=>'required',
								   'email'=>'required|email',
								   //'g-recaptcha-response' => 'required|recaptcha'
								));
	
	//Check Captcha [START]
	if(\Config::get('config.checkCaptcha', '1')==1){
		$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
		$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
		//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
	}
	//Check Captcha [END]
	
	$firstName=$request->firstName?$request->firstName:'';
	$lastName=$request->lastName?$request->lastName:'';
	$email=$request->email?$request->email:'';
	$password=$request->password?$request->password:'';
	$redirects_to=$request->redirects_to?$request->redirects_to:'';
	
	/* Get IP & MacID [START]*/ 
	$ip=$_SERVER['REMOTE_ADDR'];
	$MacID=$ip;
	/* Get IP & MacID [END]*/

	$contactsData=array(
					'firstName'=>$firstName,
					'lastName'=>$lastName,
					'email'=>$email,
					'password'=>md5($password),
					'customerType'=>2,
					'isActive'=>1,
					'isApprove'=>1,
					'ip'=>$ip,
					'MacID'=>$MacID,
					'roleID'=>39
					);
	//dd($contactsData);
	$Customer= new Customer($contactsData);
	$Customer->save();
	
	//$formData=array('formID'=>\Config::get('config.customerFormID'));
//	
//	/*======================================*/
//	//  Email Sent To Customer  [START]
//	/*======================================*/
//	$emailautoresponse= new Emailautoresponse;
//	$autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
//	
//	if($autoResponceResult['recordCount'] > 0){
//		
//		$subject = $autoResponceResult['data'][0]->subject;
//		$msg = $autoResponceResult['data'][0]->message1;
//		
//		$from=\Config::get('config.fromEmail');
//		$name=\Config::get('config.fromEmailName');
//		if(strlen(trim(\Config::get('config.developerEmail')))> 0){
//			$to=\Config::get('config.developerEmail');
//		}else{
//			$to=$email;
//		}
//		
//		if(\Config::get('config.sendEmail')==1){
//			
//			Mail::send($msg, array('name' => $name), function($message)
//			{
//				$message->from($from);
//				$message->to($to)->subject($subject);
//			});
//			
//			
//		}
//	}
//	/*======================================*/
//	//  Email Sent To Customer  [END]
//	/*======================================*/
//	
//	/*======================================*/
//	//  Email Sent To Admin  [START]
//	/*======================================*/
//	$adminemail= new Adminemail;
//	$sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
//	
//	if($sqlAdminEmailResult['recordCount'] > 0){
//		$adminsubject = $sqlAdminEmailResult['data'][0]->adminsubject;
//		$adminemailcontent = $sqlAdminEmailResult['data'][0]->adminemail;
//		$adminemailcontent = str_replace('{var_firstName}',$request->firstName,$adminemailcontent);
//		$adminemailcontent = str_replace('{var_lastName}',$request->lastName,$adminemailcontent);
//		$adminemailcontent = str_replace('{var_email}',$request->email,$adminemailcontent);
//		
//	
//		$emailsettingData=array('formID'=>\Config::get('config.customerFormID'),'emailType'=>1,'isActive'=>1);
//		
//		$emailsetting= new Emailsetting;
//		$sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
//	
//		foreach($sqlmail['data'] as $adminemail) {
//				$adminTo= $adminemail->email;
//				$from=\Config::get('config.fromEmail');
//				$name=\Config::get('config.fromEmailName');
//				
//				if(strlen(trim(\Config::get('config.developerEmail')))> 0){
//					$to=\Config::get('config.developerEmail');
//				}else{
//					$to=$adminTo;
//				}
//				
//				if(\Config::get('config.sendEmail')==1){
//					
//					$sent = Mail::send($adminemailcontent, array('name' => $name), function($message)
//					{
//						$message->from($from);
//						$message->to($to)->subject($adminsubject);
//					});
//								
//				}
//		}
//	}
//	/*======================================*/
//	//  Email Sent To Admin  [END]
//	/*======================================*/
//	
//	$_POST['formID']=\Config::get('config.customerFormID');

	//After Registration Directe Login [START]
	$customerDate = array(
						   'firstName'    => $Customer->firstName,
						   'lastName'     => $Customer->lastName,
						   'email'        => $Customer->email,
						   'customerID'   => $Customer->customerID,
						   'customerType' => $Customer->customerType,
						);
	$customerData=array('last_login'=>date('Y-m-d H:i:s'),
						);
	$customerID=Customer::where('customerID', $Customer->customerID)->update($customerData);    /*Login Update*/
	
	Session::put($customerDate);
	//After Registration Directe Login [END]

	////For Admin Login[Start]
//	$admindata = array(
//					   'admin_user'  => $Customer->customerID,
//					   'admin_role'  => $Customer->roleID,
//					   'leftmenuhide'  => 0,
//					   'adminfontsize' => 'body_12px'
//				   );
//	Session::put($admindata);
//	//For Admin Login[End]
	
	//return Redirect::away(url('/').'/guest-checkout')->with(array('flash_message' => 'Guest Login Successfully.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	return Redirect::back()->with(array('flash_message' => 'Guest Login Successfully.'))->send();
?>