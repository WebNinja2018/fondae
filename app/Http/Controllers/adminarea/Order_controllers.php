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
use Vinkas\Laravel\Recaptcha\ServiceProvider;
use Illuminate\Support\Facades\Custom;

//Load Models
use App\Http\Models\Orders;
use App\Http\Models\Orderstatus;
use App\Http\Models\Ordertype;
use App\Http\Models\Customer_address;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;

class Order_controllers extends Controller
{
	// contact us start
	public function index(Request $request)
	{
		
		if(session()->get('admin_role')=='2'){
			return Redirect::fun_redirect(url('/adminarea/home'))->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
		}
		$Orders= new Orders;
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $orderID)
				{
					Orders::destroy($orderID);
				}
			}
		}
		$getorderStatus = Orderstatus::all();
		$data['orderStauscount']=count($getorderStatus);
		$data['orderStausName']=$getorderStatus;

		$result=$Orders ->getAllorder();
		$data['recordcount']=$result['rows'];
		$data['qGetAllorder']=$result['data'];
		return view('adminarea.order.order',$data);
	}

	public function ordersingledelete(Request $request)
	{
		$orderID =$request->orderID;
		Orders::destroy($orderID);
	}

	public function orderDetail(Request $request)
	{
		$orderID =$request->orderID;

		$Orders= new Orders;
		$orderData=array('orderID'=>$orderID); 
	
		$getAllOrderResult=$Orders->getByAttributesQuery($orderData);
		$data['orderRecordCount']=$getAllOrderResult['recordCount'];
		$data['qGetOrderlist']=$getAllOrderResult['data'];
	
		$Customer_address=new Customer_address;	
		if($data['qGetOrderlist'][0]->shippingID > 0){
			$addressData = array('customerAddressID'=>$data['qGetOrderlist'][0]->shippingID);
			$addressResult = $Customer_address->getByAttributesQuery($addressData);
			$data['qGetShippingAddressData'] = $addressResult['data'];
			$data['shippingAddressRecordCount'] = $addressResult['recordCount'];
		}
		
		if($data['qGetOrderlist'][0]->billingID > 0){
			$addressData = array('customerAddressID'=>$data['qGetOrderlist'][0]->billingID);
			$addressResult = $Customer_address->getByAttributesQuery($addressData);
			$data['qGetBillingAddressData'] = $addressResult['data'];
			$data['billingAddressRecordCount'] = $addressResult['recordCount'];
		}

		return view('adminarea.order.order-detail',$data);
		
	}
	
	public function rewardDetail(Request $request)
	{
		$orderID =$request->orderID;

		$Orders= new Orders;
		$orderData=array('orderID'=>$orderID); 
	
		$getAllOrderResult=$Orders->getByAttributesQuery($orderData);
		$data['orderRecordCount']=$getAllOrderResult['recordCount'];
		$data['qGetOrderlist']=$getAllOrderResult['data'];
	
		return view('adminarea.order.reward-detail',$data);
		
	}
	function changeOrderStatus(Request $request)
	{
		$orderID = $request->orderID;
		Session::set('orderID',$orderID); //Session set orderID

		$orderstatusID = $request->orderstatusID;
		$orderdata=array('orderStatus'=>$orderstatusID);
		$Orders= new Orders;
		$query = $Orders->where('orderID', $orderID)
									->update($orderdata);

		// Order Mail Admin/Coustomer [START]
			app('App\Http\Controllers\Payment_controllers')->orderMail();
		// Order Mail Admin/Coustomer [END]
	}
	
	function reward(Request $request)
	{
		$adminemail=session()->get('admin_email');
		$customerEmail = $request->customerEmail;
		$subject = $request->subject;
		$description = $request->description;
		
		// Server Side Validation
		$this->validate($request,array('customerEmail'=>'required|email',
									   'subject'=>'required',
									   'description'=>'required',
									));
									
		$mailDescription='';
		$mailDescription.='<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Fondae</title>
						</head>
						<body style="margin:0px; padding:0px;">
						 <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style=" background:#FFF;">
									<td style="text-align:left;padding-bottom: 30px;">
										<a href="'.url('/').'"><img src="'.url('/').'/frontend/images/Charity-logo_03.png" alt="Fondae" title="Fondae" width="50%"></a>
									</td>
									<td style=" padding:12px 0px 30px;text-align:right;margin:5px 0px;">
										<a href="'.url('/').'/" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Home</a>
										<a href="'.url('/').'/explore" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">Explore</a>
										<a href="'.url('/').'/about"  target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">How It Works</a>
										<a href="'.url('/').'/login-registration" target="_blank" style="font-family:arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Login</a>
										<a href="'.url('/').'login-registration" target="_blank" style=" font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Signup</a>
									</td>
								</tr>
							   </tbody>
						 </table>';
			$mailDescription.=	'<table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0"><tbody><tr style=" background:#FFF;"><td style="text-align:left;padding-bottom: 30px;">'.$description.'</td></tr></tbody></table>'; 
			$mailDescription.=	'<table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="background:#2F374C; width:100%;">
									<td style="padding:15px 0px 15px; text-align:center;" colspan="3">
										<p style=" color:#e8ae00; font-family:arial;font-size:14px;font-weight:600;">Copyright By :<a href="##" target="_blank" title="HR Infocare" style="color:#e8ae00; font-weight:600; text-decoration:none; font-size:12px;">  Fondae.com</a></p>
									</td>
								</tr>
							</tbody>
						</table>
						</body>
						</html>';
					
						
			$formData=array('formID'=>\Config::get('config.orderFormID','5'));
	  
			  /*======================================*/
			  //  Email Sent To Customer  [START]
			  /*======================================*/
			  $emailautoresponse= new Emailautoresponse;
			  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
			  
			  if($autoResponceResult['recordCount'] > 0){
				  
				 
				  $msg = $mailDescription;
				  
				  $from=$adminemail;
				  $name=\Config::get('config.fromEmailName');
				  $to=$customerEmail;
				  
				  if(\Config::get('config.sendEmail')==1){
					  
					  $emailData=array(
										'name'=>$name,
										'from'=>$from,
										'to'=>$to,
										'subject'=>$subject,
										'message'=>$mailDescription
									  );
					  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
				  }
			  }
			  /*======================================*/
			  //  Email Sent To Customer  [END]
			  /*======================================*/
			  
			  /*======================================*/
			  //  Email Sent To Admin  [START]
			  /*======================================*/
			  $adminemail= new Adminemail;
			  $sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
			  
			  if($sqlAdminEmailResult['recordCount'] > 0){
				 
				  $adminemailcontent = $mailDescription;
				  $emailsettingData=array('formID'=>\Config::get('config.orderFormID','5'),'emailType'=>1,'isActive'=>1);
				  
				  $emailsetting= new Emailsetting;
				  $sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
			  
				  foreach($sqlmail['data'] as $adminemail) {
						  $adminTo= $adminemail->email;
						  $from=$adminemail;
						  $name=\Config::get('config.fromEmailName');
						  
						  $to=$adminTo;
						  
						  if(\Config::get('config.sendEmail')==1){
							  
							  $emailData=array(
												'name'=>$name,
												'from'=>$from,
												'to'=>$to,
												'subject'=>$subject,
												'message'=>$adminemailcontent
											  );
							  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
					  
						 }
				  }
			  }
			  /*======================================*/
			  //  Email Sent To Admin  [END]
			  /*======================================*/
			
	}
	
}
