<?php 
	
	use App\Http\Models\Country;
	use App\Http\Models\Cart;
	use App\Http\Models\Customer_address;
	use App\Http\Models\Orders;
	use App\Http\Models\Order_details;
	use App\Http\Models\Emailautoresponse;
	use App\Http\Models\Adminemail;
	use App\Http\Models\Emailsetting;
	use Vinkas\Laravel\Recaptcha\ServiceProvider;
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Custom;

	$orderID=Session::get('orderID')?Session::get('orderID'):0;
	$orderData = array('orderID'=>$orderID);
	$Orders=new Orders;
	$ordersResult=$Orders->getByAttributesQuery($orderData);
    $qGetOrdersData = $ordersResult['data'];
	$ordersRecordCount = $ordersResult['recordCount'];
	$email=$qGetOrdersData[0]->email;

	$Customer_address=new Customer_address;
	if($qGetOrdersData[0]->shippingID > 0){
		$addressData = array('customerAddressID'=>$qGetOrdersData[0]->shippingID);
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		$qGetShippingAddressData = $addressResult['data'];
		$shippingAddressRecordCount = $addressResult['recordCount'];
	}
	
	if($qGetOrdersData[0]->billingID > 0){
		$addressData = array('customerAddressID'=>$qGetOrdersData[0]->billingID);
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		$qGetBillingAddressData = $addressResult['data'];
		$billingAddressRecordCount = $addressResult['recordCount'];
	}

	$orderID=Session::get('orderID')?Session::get('orderID'):0;
	$paymentType=Session::get('paymentType')?Session::get('paymentType'):1;
	$cardType=Session::get('cardType')?Session::get('cardType'):'';
	$cardName=Session::get('cardName')?Session::get('cardName'):'';
	$cardNumber=Session::get('cardNumber')?Session::get('cardNumber'):'';
	$cvvNumber=Session::get('cvvNumber')?Session::get('cvvNumber'):'';
	$expYear=Session::get('expYear')?Session::get('expYear'):'';
	$expMonth=Session::get('expMonth')?Session::get('expMonth'):'';

	$currencyCode="USD";
	$amount = $qGetOrdersData[0]->grandTotal;

	// Order Mail Template[START]
		$conformOrder='';
		$conformOrder.='<html xmlns="http://www.w3.org/1999/xhtml">
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
						 </table>
						 <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
							<tbody>';
				$conformOrder.='<tr>
									<td colspan="4">
										<p style="font-size:16px; float:left; width:100%; text-transform:capitalize; color:#86bc42; text-align:left;font-family:arial; font-weight:600; padding:0 0 10px; border-bottom:3px solid #86bc42;">Thank You For Your Order!</p>
									</td>
								</tr>';
				$conformOrder.='<tr>
									<td colspan="4" style="padding:0 20px; border-bottom:3px solid #86bc42;">
										<p style="font-size:14px; text-transform:capitalize; color:#737373; text-align:left;font-family:arial; font-weight:600;">Dear '.$qGetBillingAddressData[0]->firstName.' '.$qGetBillingAddressData[0]->lastName.',</p>
										<p style="font-size:14px; color:#737373; text-align:left;font-family:arial; padding:0 0 10px;">Thank you for placing an order with '.Config::get("config.contactTitle", "Yatharth Conference").'. Below we have provided you with the order confirmation and shipping details. You will be notified via email once your order has been shipped.</p>
										<p style="font-size:14px; text-transform:capitalize; color:#737373; text-align:left;font-family:arial; font-weight:600;">ORDER CONFIRMATION</p>
										<p style="font-size:14px; color:#737373; text-align:left;font-family:arial; padding:0 0 10px; font-style:italic;">Your order has been successfully received.</p>
										<p style="font-size:14px; text-transform:capitalize; color:#737373; text-align:left;font-family:arial; font-weight:600;">ORDER STATUS</p>
										<p style="font-size:14px; color:#737373; text-align:left;font-family:arial; padding:0 0 10px; font-style:italic;">'.$qGetOrdersData[0]->orderName.'</p>
										<p style="font-size:14px; text-transform:capitalize; color:#737373; text-align:left;font-family:arial; font-weight:600;"># ORDER NUMBER</p>
										<p style="font-size:16px; color:#00b5f3; text-align:left;font-family:arial; padding:0 0 10px; font-weight:600; float:left; width:100%;">'.$qGetOrdersData[0]->orderNumber.'</p>
						
									</td>
								</tr>
								 <tr>';
					if($shippingAddressRecordCount>0){
						$conformOrder.='<td style="padding:10px 20px;">
											<p style="font-size:14px; text-transform:capitalize; color:#86bc42; text-align:left;font-family:arial; font-weight:600;">SHIPPING</p>
											<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetShippingAddressData[0]->firstName.' '.$qGetShippingAddressData[0]->lastName.'</p>
											<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetShippingAddressData[0]->address1.'</p>';
											if(strlen($qGetShippingAddressData[0]->address2)>0){
												$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetShippingAddressData[0]->address2.'</p>';
											}
											$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetShippingAddressData[0]->city.', '.$qGetShippingAddressData[0]->zipcode.'</p>
															<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetShippingAddressData[0]->stateName.', '.$qGetShippingAddressData[0]->countryName.'</p>';
											if(strlen($qGetShippingAddressData[0]->phone)>0){
												$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">Phone: '.$qGetShippingAddressData[0]->phone.'</p>';
											}
						$conformOrder.='</td>';
					}
					if($billingAddressRecordCount>0){
						$conformOrder.='<td style="padding:10px 20px 0 0;">
											<p style="font-size:14px; text-transform:capitalize; color:#86bc42; text-align:left;font-family:arial; font-weight:600;">BILLING</p>
											<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetBillingAddressData[0]->firstName.' '.$qGetBillingAddressData[0]->lastName.'</p>
											<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetBillingAddressData[0]->address1.'</p>';
											if(strlen($qGetBillingAddressData[0]->address2)>0){
												$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetBillingAddressData[0]->address2.'</p>';
											}
											$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetBillingAddressData[0]->city.', '.$qGetBillingAddressData[0]->zipcode.'</p>
															<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$qGetBillingAddressData[0]->stateName.', '.$qGetBillingAddressData[0]->countryName.'</p>';
											if(strlen($qGetBillingAddressData[0]->phone)>0){
												$conformOrder.='<p style="font-size:14px; color:#989898; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">Phone: '.$qGetBillingAddressData[0]->phone.'</p>';
											}
						$conformOrder.='</td>';
					}
				$conformOrder.='</tr>
							 </tbody>
						 </table>
						 <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td style="height:20px;" colspan="4"></td>
								</tr>
								<tr>
									<td style="height:10px;" colspan="4"></td>
								</tr>
								<tr bgcolor="#f9f9f9">
									<th style="padding:10px; width:5%;font-family:arial;font-size:14px; ">Item</th>
									<th style="padding:10px; width:60%;font-family:arial;font-size:14px; ">Product Detail</th>
									<th style="padding:10px; width:10%;font-family:arial;font-size:14px; ">Quntity</th>
									<th style="padding:10px; width:10%;font-family:arial;font-size:14px; ">Price</th>
								</tr>';
				$i=1;
				foreach($qGetOrdersData as $resultOrdersData){
				$conformOrder.='<tr>
									<td style="padding:0 0px;">'.$i.'</td>
									<td style="padding:10px 20px 0 0;">
										<p style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#616161; text-align:left;font-family:arial; font-weight:600;">'.$resultOrdersData->productName.'</p>
										<p style="font-size:14px; color:#616161; text-align:left;font-family:arial; padding:0 0 5px; margin:0px;">'.$resultOrdersData->sizeName.' </p>
									</td>
									<td style="padding:0 0px;">
										<p style="font-size:14px; text-transform:capitalize; color:#616161; float:right; width:100%;text-align:center;font-family:arial; font-weight:600;">'.$resultOrdersData->product_quantity.'</p>
									</td>
									<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#616161; text-align:left;font-family:arial; font-weight:600;">'.Config::get("config.priceSign", "$").' '.number_format(($resultOrdersData->product_quantity * $resultOrdersData->price),2).'</td>
								</tr>';
				$i++;
				}
				$conformOrder.='<tr>
									<td style="height:25px; border-bottom:3px solid #86bc42;" colspan="4"></td>
								</tr>
								<tr>
									<td colspan="4" style="padding-top:20px;">
										<table style="width:40%; background:#f6f6f6; float:right; padding:10px;">
											<tr>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#666666; padding:5px 0px; text-align:left;font-family:arial; font-weight:600;">SUB TOTAL</td>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#69b245; text-align:right;font-family:arial; font-weight:600;">'.Config::get("config.priceSign", "$").' '.number_format(($qGetOrdersData[0]->subTotal),2).'</td>
											</tr>
											<tr>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#666666; padding:5px 0px; text-align:left;font-family:arial; font-weight:600;">DISCOUNT</td>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#69b245; text-align:right;font-family:arial; font-weight:600;">'.Config::get("config.priceSign", "$").' '.number_format(($qGetOrdersData[0]->discount),2).'</td>
											</tr>
											<tr>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#666666; padding:5px 0px; text-align:left;font-family:arial; font-weight:600;">TAX</td>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#69b245; text-align:right;font-family:arial; font-weight:600;">'.Config::get("config.priceSign", "$").' '.number_format(($qGetOrdersData[0]->tax),2).'</td>
											</tr>
											<tr>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#666666; padding:5px 0px; text-align:left;font-family:arial; font-weight:600;">TOTAL</td>
												<td style="font-size:14px; margin:5px 0px; text-transform:capitalize; color:#69b245; text-align:right;font-family:arial; font-weight:600;">'.Config::get("config.priceSign", "$").' '.number_format(($qGetOrdersData[0]->grandTotal),2).'</td>
											</tr>
										</table>
									</td>
								</tr>
							 </tbody>
						   </table>
						 <table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
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
	//echo $conformOrder;exit;
	// Order Mail Template[END]

	
	  $formData=array('formID'=>\Config::get('config.orderFormID','5'));
	  
	  /*======================================*/
	  //  Email Sent To Customer  [START]
	  /*======================================*/
	  $emailautoresponse= new Emailautoresponse;
	  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
	  
	  if($autoResponceResult['recordCount'] > 0){
		  
		  $subject = $autoResponceResult['data'][0]->subject;
		  //$msg = $autoResponceResult['data'][0]->message1;
			$msg = $conformOrder;
		  
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
	  
	  /*======================================*/
	  //  Email Sent To Admin  [START]
	  /*======================================*/
	  $adminemail= new Adminemail;
	  $sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
	  
	  if($sqlAdminEmailResult['recordCount'] > 0){
		  $adminsubject = $sqlAdminEmailResult['data'][0]->adminsubject;
		  //$adminemailcontent = $sqlAdminEmailResult['data'][0]->adminemail;
		  $adminemailcontent = $conformOrder;
		  
	  
		  $emailsettingData=array('formID'=>\Config::get('config.orderFormID','5'),'emailType'=>1,'isActive'=>1);
		  
		  $emailsetting= new Emailsetting;
		  $sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
	  
		  foreach($sqlmail['data'] as $adminemail) {
				  $adminTo= $adminemail->email;
				  $from=\Config::get('config.fromEmail');
				  $name=\Config::get('config.fromEmailName');
				  
				  $to=$adminTo;
				  
				  if(\Config::get('config.sendEmail')==1){
					  
					  $emailData=array(
										'name'=>$name,
										'from'=>$from,
										'to'=>$to,
										'subject'=>$adminsubject,
										'message'=>$adminemailcontent
									  );
					  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
			  
				 }
		  }
	  }
	  /*======================================*/
	  //  Email Sent To Admin  [END]
	  /*======================================*/
	  
	  $_POST['formID']=\Config::get('config.orderFormID',5);
	
?>