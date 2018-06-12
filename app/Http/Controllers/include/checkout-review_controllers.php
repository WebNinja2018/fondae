<?php
	use App\Http\Models\Customer_address;
	use App\Http\Models\Cart;

	$customerID = Session::get('customerID');
	$customerAddressData = array('customerID'=>$customerID,'typeID'=>\Config::get('config.billingTypeID',2));
	$Customer_address=new Customer_address;	
	$resultCustomer = $Customer_address->getByAttributesQuery($customerAddressData);
	$data['qGetCustomerAddressData'] = $resultCustomer['data'];
	$data['customerAddressRecordCount'] = $resultCustomer['recordCount'];
	
	if($data['qGetCartData'][0]->shippingID > 0){
		$addressData = array('customerAddressID'=>$data['qGetCartData'][0]->shippingID);
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		$data['qGetShippingAddressData'] = $addressResult['data'];
		$data['shippingAddressRecordCount'] = $addressResult['recordCount'];
	}
	
	if($data['qGetCartData'][0]->billingID > 0){
		$addressData = array('customerAddressID'=>$data['qGetCartData'][0]->billingID);
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		$data['qGetBillingAddressData'] = $addressResult['data'];
		$data['billingAddressRecordCount'] = $addressResult['recordCount'];
	}
	
?>