<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Image;
use Session;
use DB;
use Mail;

use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Frm_contactus;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;
use App\Http\Models\Product_price;
use App\Http\Models\Customer;

class Signup_controllers extends Controller
{
    public function index(Request $request)
	{
		
	}
	public function register(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/register_controllers.php');	
	}
	public function guestcheckout(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/guestcheckout_controllers.php');	
	}
	
	public function fblogin(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/fblogin_controllers.php');	
	}
	public function login(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/login_controllers.php');	
	}

	public function logout()
	{
		Session::flush();
		return Redirect::away(url('/login-registration'))->send();
	}

	public function ajaxCheckCustomerEmailExist(Request $request)    
	{
		//Checked By Ranjit
		$email=$request->email;
		$customerData=array('email'=>$email);
		$Customer=new Customer;

		$resultCustomer=$Customer->getByAttributesQuery($customerData);
		if($resultCustomer['recordCount']>0){
			echo "false";
		}else{
			echo "true";
		}
	}
	
	
	public function stripeConfirm(Request $request){
				
		$token_request_body = array(
		  'grant_type' => 'authorization_code',
		  'client_id' => 'ca_8wHMRtjP9cD3h5BOXfKgiNJCWkBqf6V3',
		  'code' => $request->code,
		  'client_secret' => 'sk_test_JHkeSk0TcHyltgBvCTfDD9f2'
		 );
 
		$req = curl_init("https://connect.stripe.com/oauth/token");
		 curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($req, CURLOPT_POST, true );
		 curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
		 $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
		 $resp = json_decode(curl_exec($req), true);
		 curl_close($req);
		
		$customerID = Session::get('customerID'); 
		
		$pub_key = $resp['stripe_publishable_key'];
		$sec_key = $resp['access_token'];
		$customerData=array('stripe_sk'=>$sec_key, 'stripe_pk'=>$pub_key);
		//dd($customerData);
		Customer::where('customerID','=', $customerID)->update($customerData);
		Session::put('stripeSK', $sec_key);
		Session::put('stripePK', $pub_key);		
		//Session::flush();
		//return Redirect::away(url('/login-registration'))->send();
		return back()->withInput();
	}
	
}
