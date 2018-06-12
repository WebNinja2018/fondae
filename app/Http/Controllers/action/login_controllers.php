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
	use Illuminate\Support\Facades\Custom;
	
	Redirect::checkReferrerUrl(); //Redirection happen when direct access by page

	$check = true;



	// Server Side Validation
	$this->validate($request,array('email'=>'required',
								   'password'=>'required',
								));

	//Check Captcha [START]
	if(\Config::get('config.checkCaptcha', '1')==1){
		$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
		$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
		//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
	}

$email=$request->email?$request->email:'';
$password=$request->password?$request->password:'';
$redirects_to=$request->redirects_to?$request->redirects_to:'';
$customerData=array('email'=>$email,'password'=>md5($password),'customerType'=>1);
$costomerActive =Customer::where($customerData)->first();


if(!empty($costomerActive)) 
{

	if($costomerActive->isActive == '0'){


		$token = str_random(128);

		\App\Http\Models\ActivationToken::where('customerID', $costomerActive->customerID)->delete();

		\App\Http\Models\ActivationToken::create([
			'token' => $token,
			'customerID' => $costomerActive->customerID,


		]);

		Mail::send("emails.activation", [
			'token' => $token,

		], function ($m) use($costomerActive) {
			$m->to($costomerActive->email)->subject('Active your account');

		});

		return Redirect::away(url('/') . '/login-registration')->with(array('flash_message' => 'Please now activate your account .'))->send();


       }

    elseif($costomerActive->isActive == '1') 
    {
		//Check Captcha [START]
		if(\Config::get('config.checkCaptcha', '1')==1){
			$this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
			$recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
			//Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		}
		//Check Captcha [END]

		$email=$request->email?$request->email:'';
		$password=$request->password?$request->password:'';
		$redirects_to=$request->redirects_to?$request->redirects_to:'';

		$customerData=array('email'=>$email,'password'=>md5($password),'customerType'=>1);
		$resultCustomer = Customer::where($customerData)->first();

		if(count($resultCustomer) > 0){   /*record count is 0 then not login successfully*/

			if($resultCustomer->isApprove==1)      /*Here set to isApprove is 1 then login*/
			{
				$customerDate = array(
					'firstName'    => $resultCustomer->firstName,
					'lastName'     => $resultCustomer->lastName,
					'email'        => $resultCustomer->email,
					'customerID'   => $resultCustomer->customerID,
					'customerType' => $resultCustomer->customerType,
					'roleID' => $resultCustomer->roleID,
					'stripeSK' => $resultCustomer->stripe_sk,
					'stripePK' => $resultCustomer->stripe_pk,
				);
				$customerData=array('last_login'=>date('Y-m-d H:i:s'),
				);
				$customerID=Customer::where('customerID', $resultCustomer->customerID)->update($customerData);    /*Login Update*/

				Session::put($customerDate);

				//For Admin Login[Start]
				$admindata = array(
					'admin_user'  => $resultCustomer->customerID,
					'admin_role'  => $resultCustomer->roleID,
					'admin_email'  => $resultCustomer->email,
					'leftmenuhide'  => 0,
					'adminfontsize' => 'body_12px'
				);
				Session::put($admindata);
				//For Admin Login[End]
				if(strlen($redirects_to)>0)
				{
					return Redirect::away($redirects_to)->send();
				}else{
					if(Request::segment(3)=='dashboard'){
						return Redirect::away(url('/adminarea/home'))->send();
					}else{
						return Redirect::away(url('/login-registration'))->send();
					}
				}
			}
			else
			{
				$check = false;
				$flash_message="Sorry your account is not Approve.";
			}
		}
		else
		{
			$check = false;
			$flash_message="Please check your Username and Password.";
		}

	}   
}
else{

		$check = false;
		$flash_message="Please check your Username and Password.";

}



	if (!$check)
	{
		return Redirect::back()->withErrors(array('flash_message' => $flash_message))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}
	

?>