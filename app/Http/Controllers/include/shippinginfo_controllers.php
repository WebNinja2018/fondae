<?php
	use App\Http\Models\Customer_address;
	
	$customerID = Session::get('customerID');
	$customerAddressData = array('customerID'=>$customerID,'typeID'=>\Config::get('config.shippingTypeID',1));
	$Customer_address=new Customer_address;	
	$resultCustomer = $Customer_address->getByAttributesQuery($customerAddressData);
	$data['qGetCustomerAddressData'] = $resultCustomer['data'];
	$data['customerAddressRecordCount'] = $resultCustomer['recordCount'];
	
?>