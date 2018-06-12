<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer;
use App\Http\Models\PasswordRest;

use Illuminate\Http\Request;
use Mailgun\Mailgun;


class ForgotPasswordController extends Controller
{

    public function emailtesting(){
               $data=['from'    => 'girish.code@gmail.com', 
                                'to'      => 'Girish.sharma@nrt.co.in', 
                                'subject' => 'You Request send successfully to siwahz Team',
                                'html'    => 'hello'
                                ];         
      

\Mailgun::send('errors.503', $data, function ($message) {
	$message->to('foo@example.com', 'John Smith')->subject('Welcome!');
});



                \Session::flash('message', 'Action Success !!!');
    }







    public function passwordForm($token)
    {
        return  view('forgotpassword.reset-password',compact('token'));
    }



    public function passwordFormPost(Request $request ,$token)
    {
       $passwordRest = PasswordRest::where('token',$token)->first();

        if(count($passwordRest) > 0)
        {
            $this->validate($request,array('email'=>'required|email|exists:customer,email',
                'password'=>'required|min:6|confirmed',
            ));

   
            if($passwordRest->email == $request->email)
            {
                $customer = Customer::where('email',$passwordRest->email)->update([
                    'password' => md5($request->password),
                ]);

                PasswordRest::where('token',$token)->delete();
                return redirect()->to('/login-registration')->withMessage('Password has been changed successfully.');
            }
            else
            {
                return redirect()->back()->withMessage('Your email is invalid.');

            }


        }
        else{
            return redirect()->back()->withMessage('Oops something went wrong, try again.');
        }
    }
   
}



