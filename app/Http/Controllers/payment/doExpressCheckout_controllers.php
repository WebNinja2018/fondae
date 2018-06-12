<?php 
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Custom;
	
	use App\Http\Models\Country;
	use App\Http\Models\Cart;
	use App\Http\Models\Customer_address;
	use App\Http\Models\Orders;
	use App\Http\Models\Order_details;
	

	$orderID=Session::get('orderID')?Session::get('orderID'):0;
	$cartID=Session::get('cartID')?Session::get('cartID'):0;

	$orderData = array('orderID'=>$orderID);
	$Orders=new Orders;
	$ordersResult=$Orders->getByAttributesQuery($orderData);
    
	$qGetOrdersData = $ordersResult['data'];
	$ordersRecordCount = $ordersResult['recordCount'];
		
	if($ordersRecordCount>0){
		if($qGetOrdersData[0]->billingID > 0){
			  $Customer_address=new Customer_address;
			  $addressData = array('customerAddressID'=>$qGetOrdersData[0]->billingID);
			  $addressResult = $Customer_address->getByAttributesQuery($addressData);
			  $data['qGetBillingAddressData'] = $addressResult['data'];
			  $data['billingAddressRecordCount'] = $addressResult['recordCount'];
		}
	
		$firstName = $data['qGetBillingAddressData'][0]->firstName;
		$lastName = $data['qGetBillingAddressData'][0]->lastName;
		$address1 = $data['qGetBillingAddressData'][0]->address1;
		$address2 = $data['qGetBillingAddressData'][0]->address2;
		$city = $data['qGetBillingAddressData'][0]->city;
		$state =$data['qGetBillingAddressData'][0]->state;
		$zip = $data['qGetBillingAddressData'][0]->zipcode;

		$subTotal = $qGetOrdersData[0]->subTotal;
		$amount = $qGetOrdersData[0]->grandTotal;
		$tax= $qGetOrdersData[0]->tax;
		$discount= $qGetOrdersData[0]->discount;
	}

	$paymentType=Session::get('paymentType')?Session::get('paymentType'):1;
	$cardType=Session::get('cardType')?Session::get('cardType'):'';
	$cardName=Session::get('cardName')?Session::get('cardName'):'';
	$cardNumber=Session::get('cardNumber')?Session::get('cardNumber'):'';
	$cvvNumber=Session::get('cvvNumber')?Session::get('cvvNumber'):'';
	$expYear=Session::get('expYear')?Session::get('expYear'):'';
	$expMonth=Session::get('expMonth')?Session::get('expMonth'):'';

	$currencyCode="USD";
	

	// payment cut when return from paypal[START]

	require_once 'paypal/CallerService.php';
	session_start();

	$productName = "Yatharth Conference";
	$token = @$_REQUEST['token'];
	
	if(!isset($token)) {

		$serverName = $_SERVER['SERVER_NAME'];
		$serverPort = $_SERVER['SERVER_PORT'];
		$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
		$currencyCodeType="USD";
		$paymentType="Sale";
		$personName        = $firstName.' '.$lastName;
		$SHIPTOSTREET      = $address1.' '.$address2;
		$SHIPTOCITY        = $city;
		$SHIPTOSTATE	      = $state;
		$SHIPTOCOUNTRYCODE = "";
		$SHIPTOZIP         = $zip;
		$L_NAME0           = str_replace("&", "",$productName);
		$L_AMT0            = $subTotal - $discount;
		$L_QTY0            = "1";
		$L_SHIPPINGOPTIONAMOUNT0 = "0.00";
		$L_SHIPPINGOPTIONLABEL0 = "";
		$L_SHIPPINGOPTIONNAME0 = "";
		$L_SHIPPINGOPTIONISDEFAULT0=true;
		$INSURANCEAMT = "0.00";
		$INSURANCEOPTIONOFFERED=false;
		$L_NUMBER0 = "0.00";
		$L_DESC0 = "0.00";
		$SHIPPINGAMT = "0.00";
		$SHIPDISCAMT = "0.00";
		$TAXAMT = $tax;
		$itemamt = $subTotal - $discount;
		$amt = $amount;
		$maxamt= $amount;

		$returnURL =urlencode($url.'/doExpressCheckout?currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&orderID='.$orderID.'&cartID='.$cartID);
		$cancelURL =urlencode('http://'.$serverName.':'.$serverPort.'/checkout-review?paymentType=$paymentType' );

		$nvpstr="";
		$shiptoAddress = "&SHIPTONAME=$personName&SHIPTOSTREET=$SHIPTOSTREET&SHIPTOCITY=$SHIPTOCITY&SHIPTOSTATE=$SHIPTOSTATE&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE&SHIPTOZIP=$SHIPTOZIP";
		$nvpstr="&ADDRESSOVERRIDE=1$shiptoAddress&L_NAME0=$L_NAME0&L_AMT0=$L_AMT0&L_QTY0=$L_QTY0&MAXAMT=".(string)$maxamt."&AMT=".(string)$amt."&ITEMAMT=".(string)$itemamt."
		&CALLBACKTIMEOUT=4&L_SHIPPINGOPTIONAMOUNT0=$L_SHIPPINGOPTIONAMOUNT0&L_SHIPPINGOPTIONLABEL0=$L_SHIPPINGOPTIONLABEL0&L_SHIPPINGOPTIONNAME0=$L_SHIPPINGOPTIONNAME0
		&L_SHIPPINGOPTIONISDEFAULT0=$L_SHIPPINGOPTIONISDEFAULT0&INSURANCEAMT=$INSURANCEAMT&INSURANCEOPTIONOFFERED=$INSURANCEOPTIONOFFERED&
		CALLBACK=https://www.ppcallback.com/callback.pl&SHIPPINGAMT=$SHIPPINGAMT&SHIPDISCAMT=$SHIPDISCAMT&TAXAMT=$TAXAMT&L_NUMBER0=$L_NUMBER0&L_DESC0=$L_DESC0
		&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
		
		$resArray=hash_call("SetExpressCheckout",$nvpstr);
		
		$_SESSION['reshash']=$resArray;
		

		$ack = strtoupper($resArray["ACK"]);

		if($ack=="SUCCESS"){
		// Redirect to paypal.com here
			$token = urldecode($resArray["TOKEN"]);
			$payPalURL = PAYPAL_URL.$token;
			header("Location: ".$payPalURL);
		} else  {
			$location = url('/')."/apierror";
			header("Location: $location");
		}
	} 
	else 
	{
		$orderID=$_REQUEST['orderID'];
		$cartID=$_REQUEST['cartID'];
		Session::set('orderID',$orderID); //Session set orderID
		Session::set('cartID',$cartID); //Session set orderID

		$token =urlencode( $_REQUEST['token']);
		$nvpstr="&TOKEN=".$token;
		$resArray=hash_call("GetExpressCheckoutDetails",$nvpstr);
		$_SESSION['reshash']=$resArray;
		$ack = strtoupper($resArray["ACK"]);

		if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING')
		{
			$_SESSION['token']=$_REQUEST['token'];
			$_SESSION['payer_id'] = $_REQUEST['PayerID'];
			$_SESSION['paymentAmount']=@$_REQUEST['paymentAmount'];
			$_SESSION['currCodeType']=$_REQUEST['currencyCodeType'];
			$_SESSION['paymentType']=$_REQUEST['paymentType'];
			$resArray=$_SESSION['reshash'];
			$_SESSION['TotalAmount']= $resArray['AMT'] + $resArray['SHIPDISCAMT'];
			echo "Please do not close browser or  press back button";
			
			$this->completeExpressCheckout();  // completeExpressCheckout Function Create In \app\Http\Controllers\Payment_controllers.php

		}else{
			$location = url('/')."/apierror";
			header("Location: $location");
		}
	}
	// payment cut when return from paypal[END]
	
?>