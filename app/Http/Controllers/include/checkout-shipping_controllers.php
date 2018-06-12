<?php
	use App\Http\Models\Customer_address;
	use App\Http\Models\Cart;

	$firstName=$request->firstName?$request->firstName:'';
	$lastName=$request->lastName?$request->lastName:'';
	$address1=$request->address1?$request->address1:'';
	$address2=$request->address2?$request->address2:'';
	$city=$request->city?$request->city:'';
	$state=$request->state?$request->state:'';
	$country=$request->country?$request->country:'';
	$zipcode=$request->zipcode?$request->zipcode:'';
	$phone=$request->phone?$request->phone:'';

	$customerID = Session::get('customerID');
	$customerAddressData = array('customerID'=>$customerID,'typeID'=>\Config::get('config.shippingTypeID',1));
	$Customer_address=new Customer_address;	
	$resultCustomer = $Customer_address->getByAttributesQuery($customerAddressData);
	$data['qGetCustomerAddressData'] = $resultCustomer['data'];
	$data['customerAddressRecordCount'] = $resultCustomer['recordCount'];
	
	if($data['qGetCartData'][0]->shippingID > 0){
		$addressData = array('customerAddressID'=>$data['qGetCartData'][0]->shippingID);
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		$data['qGetAddressData'] = $addressResult['data'];
		$data['addressRecordCount'] = $addressResult['recordCount'];
	}
	
?>