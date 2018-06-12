


<?php

namespace App\Http\Controllers;

use App\Http\Models\ActivationToken;
use App\Http\Models\Customer;
use App\Events\UserRegisteredActivationEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ActivationController extends Controller
{
    //
    public function activate(ActivationToken $token)
    {
        $Customer = Customer::where('customerID',$token->customerID)->first();

        $value=array('isActive' => '1');
        
        Customer::where('customerID',$token->customerID)->update($value);

      /*  $token->delete()*/;

        //After Registration Directe Login [START]
        $customerDate = array(
            'firstName'    => $Customer->firstName,
            'lastName'     => $Customer->lastName,
            'email'        => $Customer->email,
            'customerID'   => $Customer->customerID,
            'customerType' => $Customer->customerType,
            'roleID'=>$Customer->roleID,
            'stripeSK' => '',
            'stripePK' => '',
        );
        $customerData=array('last_login'=>date('Y-m-d H:i:s'),
        );
        $customerID=Customer::where('customerID', $Customer->customerID)->update($customerData);    /*Login Update*/

       $fff = Session::put($customerDate);


        //For Admin Login[Start]
        $admindata = array(
            'admin_user'  => $Customer->customerID,
            'admin_role'  => $Customer->roleID,
            'leftmenuhide'  => 0,
            'adminfontsize' => 'body_12px'
        );

      $dd = Session::put($admindata);
        //For Admin Login[End]

        return Redirect::away(url('/checkout-shipping'))->with(array('flash_message' => 'Activation  Successfully.'))->send();





    }

   
}
