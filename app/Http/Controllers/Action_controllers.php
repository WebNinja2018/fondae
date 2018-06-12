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
use Illuminate\Support\Facades\Custom;
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
use App\Http\Models\Cart;
use App\Http\Models\Orders;
use App\Http\Models\Comment;
use App\Http\Models\Order_details;
class Action_controllers extends Controller
{
    public function index(Request $request)
	{
		
	}
        public function SaveComment(Request $request)
	{
	   $cid = Session::get('customerID');
	   	$order_data	=Order_details::select('orderDetailsID')->where('customerID',$cid)->orderby('orderDetailsID','desc')->first();
	     //Session set orderID 

		$data = \Input::all();
        $rules = array(
            'comment'             => 'required',
            
            );
        $validator = \Validator::make($data, $rules);
        if ($validator->fails()){
          return \Redirect()->back();
          
        }
        else {

        	if(!empty($data['display_name']))
        	{
        		$display_status='1';
        	}
        	else{
        		$display_status='0';
        	}

                if(!empty($data['display_amount']))
        	{
        		$display_amount='1';
        	}
        	else{
        		$display_amount='0';
        	}

             Comment::create([
	            'comment'               => \Input::get('comment'),
	            'order_id'               => $order_data['orderDetailsID'],
	            'display_name'          => $display_status,
                    'display_amount'          => $display_amount
	             ]);
        }
     
        Session::flash('message', 'Action Successfully Completed...'); 
        return Redirect('/');
	}



	public function contactus(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/contactus_controllers.php');	
	}
	public function enewsletter(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/enewsletter_controllers.php');	
	}
	public function unsubscribe(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/unsubscribe_controllers.php');	
	}
	public function chackenewsletter(Request $request)
	{
		$email=$request->email?$request->email:'';
		$getemail=array('email'=>$email);
		$resultEmail = Frm_mailing_list::where($getemail)->first();

		if(count($resultEmail) > 0){
			echo $valid='false';
		}else{
			echo $valid='true';
		}
		//echo json_encode(array(
//			'valid' => $valid,
//		));	
	}
	public function addtocart(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/addtocart_controllers.php');		
	}
	
	public function addtocartunpaid(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/addtocartunpaid_controllers.php');		
	}

	public function addcuopon(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/addcuopon_controllers.php');		
	}
	
	public function removecoupon(Request $request)
	{
		$Cart=new Cart;
		$cartID = $request->cartID?$request->cartID:0;
		$cartData=array('couponCodeID'=>0);
		$cartResult = $Cart->where('cartID',$cartID)
								 ->update($cartData);	
		/*Unset coupon session variable*/
		$removeCuponDiscountData=array('couponID'=>'','couponName'=>'','discountType'=>'','discountRate'=>'');
		Session::put($removeCuponDiscountData);
		return Redirect::fun_redirect(url('/').'/cart')->with(array('flash_message' => ''));
	}
	
	public function checkoutshippingaction(Request $request)
	{
		Custom::checkLoginAndWithGuest();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		include(public_path().'/app/Http/Controllers/action/checkoutshippingaction.php');		
	}
	public function checkoutbillingaction(Request $request)
	{
		Custom::checkLoginAndWithGuest();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		include(public_path().'/app/Http/Controllers/action/checkoutbillingaction.php');		
	}

	public function myprofile(Request $request)
	{
		Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		include(public_path().'/app/Http/Controllers/action/myprofile_controllers.php');		
	}
	
	public function customeraddressaddedit(Request $request)
	{
		Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		include(public_path().'/app/Http/Controllers/action/customeraddressaddedit_controllers.php');
	}

	public function changepassword(Request $request)
	{
		Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		include(public_path().'/app/Http/Controllers/action/changepassword_controllers.php');
	}

	public function forgotpassword(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/forgotpassword_controllers.php');
	}
	
	public function resetpassword(Request $request)
	{
		include(public_path().'/app/Http/Controllers/action/resetpassword_controllers.php');
	}

	public function getPriceTotal(Request $request)
	{
		$sizeID=implode(",",$request->sizeID);
		$Product_price=new Product_price;
		$priceTotal=$Product_price->whereIn('sizeID',explode(',',$sizeID))->sum('price');
		echo $priceTotal;
	}
	
	public static function getProductorderTotalCount($productID)
	{
		$Orders= new Orders;
		$prductItemData = array('productID'=>$productID);
		$qGetProductOrderData=$Orders->getByAttributesQuery($prductItemData);
		$data['goal']=0;
		$data['raised']=0;
		if($qGetProductOrderData['recordCount']>0)
		{
			foreach($qGetProductOrderData['data'] as $ProductOrderData)
			{
				$data['raised']=$data['raised']+$ProductOrderData->grandTotal;
			}
			$data['goal']=$qGetProductOrderData['data'][0]->price;
		}
		
		if($data['goal']>0 && $data['raised']>0)
		{
			$data['goalper']=($data['raised']*100)/$data['goal'];
		}else{
			$data['goalper']=0;
		}
		return $data;
	}
}
