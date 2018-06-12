<?php 
	
	use App\Http\Models\Country;
	use App\Http\Models\Cart;
	use App\Http\Models\Cart_detail;
	use App\Http\Models\Customer_address;
	use App\Http\Models\Orders;
	use App\Http\Models\Order_details;

	

	$orderID=Session::get('orderID')?Session::get('orderID'):0;

	$orderData = array('orderID'=>$orderID);
	$Orders=new Orders;
	$ordersResult=$Orders->getCardDataWithPrice($orderData);
    
	$qGetOrdersData = $ordersResult['data'];
	$ordersRecordCount = $ordersResult['recordCount'];

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

	$orderID=Session::get('orderID')?Session::get('orderID'):0;
	$cartID=Session::get('cartID')?Session::get('cartID'):0;
	$paymentType=Session::get('paymentType')?Session::get('paymentType'):1;
	$cardType=Session::get('cardType')?Session::get('cardType'):'';
	$cardName=Session::get('cardName')?Session::get('cardName'):'';
	$cardNumber=Session::get('cardNumber')?Session::get('cardNumber'):'';
	$cvvNumber=Session::get('cvvNumber')?Session::get('cvvNumber'):'';
	$expYear=Session::get('expYear')?Session::get('expYear'):'';
	$expMonth=Session::get('expMonth')?Session::get('expMonth'):'';

	$currencyCode="USD";
	$amount = $qGetOrdersData[0]->grandTotal;

	// payment cut when return from paypal[START]
		require_once 'paypal/CallerService.php';
		session_start();
		$paymentType ="Sale";
		$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$cardType&ACCT=$cardNumber&EXPDATE=".$expMonth.$expYear."&CVV2=$cvvNumber&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
				"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";

		$resArray=hash_call("doDirectPayment",$nvpstr);
	
		$ack = strtoupper(@$resArray["ACK"]);
	
		if($ack!="SUCCESS")  {
			$_SESSION['reshash']=@$resArray;
			$location = url('/')."/apierror";
			header("Location: $location");
		}else{
			$sucessdata=serialize(@$resArray);
			$orderdata=array('orderStatus'=>2,'transactionID'=>$resArray['TRANSACTIONID'],'correlationID'=>$resArray['CORRELATIONID'],'paymentResponse'=>$sucessdata);
			$Orders= new Orders;
			$query = $Orders->where('orderID', $orderID)
										->update($orderdata);

			
			//Delete Cart Record[Start]
				$cartID=Session::get('cartID')?Session::get('cartID'):0;
				$cartResult=Cart::find($cartID);
				Cart::destroy($cartID);
				Cart_detail::destroy($cartResult->cartDetailID);
			//Delete Cart Record[End]
	
			$this->orderMail();

			$_POST['formID']=\Config::get('config.orderFormID',8);
			return Redirect::fun_redirect(url('/').'/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

		}
	
	// payment cut when return from paypal[END]
	
?>