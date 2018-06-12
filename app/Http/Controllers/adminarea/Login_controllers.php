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
use Illuminate\Support\Facades\Custom;
use Vinkas\Laravel\Recaptcha\ServiceProvider;

class Login_controllers extends Controller
{
	public function index(Request $request)
	{
		return view('adminarea.login');
		
	}

	public function login_process(Request $request)
	{
		$errors = array();
		$check = true;
		$this->validate($request,array('email'=>'required|email','password'=>'required'));

		//Check Captcha [START]
		  if(\Config::get('config.checkCaptcha', '1')==1){
			  $this->validate($request,array('g-recaptcha-response' => 'required|recaptcha'),array('g-recaptcha-response.required'=>'Invalid Captcha!')); //Server Side Validation[Start]
			  $recaptcha = Input::get('g-recaptcha-response')?Input::get('g-recaptcha-response'):'';
			  //Custom::checkCaptcha($recaptcha);  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		  }
		//Check Captcha [END]	
	
	    $key=md5($request->password);
		$data = array('email'=>$request->email,'password'=>$key,'isActive'=>1);
		$result = User::where($data)->first();
		if( count($result) > 0 )
		{
			$admindata = array(
							   'admin_user'  => $result->userID,
							   'admin_role'  => $result->roleID,
							   'leftmenuhide'  => 0,
							   'adminfontsize' => 'body_12px'
						   );
			Session::put($admindata);
			return Redirect::away(url('/adminarea/home'))->send();
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

	public function logout()
	{
		Session::flush();
		return view('adminarea.login');
	}

}
