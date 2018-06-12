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
use Session;
use DB;
//Load Models
use App\Http\Models\User;
use App\Http\Models\Pages;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;

use Illuminate\Support\Facades\Custom;
use Vinkas\Laravel\Recaptcha\ServiceProvider;


class Forgotpassword_controllers extends Controller
{
	public function index(Request $request)
	{
		return view('adminarea.forgot-password');
		
	}

	public function forgotpassword_process(Request $request)
	{
		$errors = array();
		$check = true;
		$this->validate($request,array('email'=>'required|email'));

		//Check Captcha [START]
		  if(\Config::get('config.checkCaptcha', '1')==1){
			  $this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
			  $recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
			  //Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		  }
		//Check Captcha [END]	
	
	    $data = array('email'=>$request->email);
		$resultUser = User::where($data)->first();

		if( count($resultUser) > 0 )
		{
			$formData=array('formID'=>\Config::get('config.forgotpasswordFormID',9));
	  
			  /*======================================*/
			  //  Email Sent To Customer  [START]
			  /*======================================*/
			  $emailautoresponse= new Emailautoresponse;
			  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
			  
			  if($autoResponceResult['recordCount'] > 0){
				  
				  $subject = $autoResponceResult['data'][0]->subject;
				  $msg = $autoResponceResult['data'][0]->message1;
				  $msg = str_replace('{VAR_CUSTOEMERNAME}',$resultUser->firstName.' '.$resultUser->lastName,$msg);
				  $msg = str_replace('{VAR_RESETPASSWORDLINK}',url('/').'/adminarea/reset-password?userID='.md5($resultUser->userID).'&hashkey='.md5(date('Ymd',strtotime('now'))),$msg);
					
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
			array_push($errors, "Invalid username and password!");
		}
		if (!$check)
		{
			$data["errors"] = $errors;
			return view( 'adminarea.login', $data );
		}
		
	}
	public function reset_password(Request $request)
	{
		$userID=$request->userID?$request->userID:'';
		$hashkey=$request->hashkey?$request->hashkey:'';
	
		$userData=array('md5(userID)'=>$userID,'isActive'=>1);
		$User=new User;
		$resultUser=$User->getByAttributesQuery($userData);
		$data['hashkey']=$hashkey;
		$data['md5userID']=$userID;
		$data['custoemerRecordcount']=$resultUser['recordCount'];
		$data['qGetuserData']=$resultUser['data'];
		return view('adminarea.reset-password', $data );
		
	}

	public function resetpassword_process(Request $request)
	{
		// Server Side Validation
		$this->validate($request,array('new_password'=>'required|same:confirm_password',
									   'confirm_password'=>'required'
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
		$md5userID=$request->md5userID?$request->md5userID:'';
		$hashkey=$request->hashkey?$request->hashkey:'';

	    $userData=array('md5(userID)'=>$md5userID,'isActive'=>1);
		$User=new User;
		$resultUser=$User->getByAttributesQuery($userData);

		$userID=$resultUser['data'][0]->userID;
		$newpasswordData=array('password'=>md5($new_password),'userID'=>$userID);
		$userID=User::where('userID',$userID)->update($newpasswordData); 

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
			$msg = str_replace('{VAR_CUSTOEMERNAME}',$resultUser['data'][0]->firstName.' '.$resultUser['data'][0]->lastName,$msg);
			$msg = str_replace('{VAR_CONTENT}',$msg,$emailTemplate);
	 
			$from=\Config::get('config.fromEmail');
			$name=\Config::get('config.fromEmailName');
			$to=$resultUser['data'][0]->email;
			
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
		return Redirect::away(url('/').'/adminarea/login')->with(array('flash_message' => 'Your password has been Updated.'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}
}
