<?php
	
	use App\Http\Models\Orders;
	use App\Http\Models\Customer_address;

	//Get Order Result Start 
	$Orders= new Orders;
	$orderNumber=$request->searchOrder?$request->searchOrder:'';
	$orderDate = $request->orderDate? date('Y-m-d',strtotime($request->orderDate)):'';
	$orderData=array(	
						'customerID'=>$customerID,
						'orderNumber'=>$urlName,
					  ); 

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

	//Get Order Result End 
?>