<?php

	use App\Http\Models\Cart;
	use App\Http\Models\Cart_detail;
	
	//Get Portfolio Result start 
	$cartData=array('uID'=>$_COOKIE['uID']);
	$Cart=new Cart;
	$resutlCartData=$Cart->getCardDataWithPrice($cartData);
	$data['cartID'] = $resutlCartData['cartID'];
	$data['couponCode'] = $resutlCartData['couponCode'];
	$data['qGetCartResult']=$resutlCartData['data'];	
	$data['CartRecordCount']=$resutlCartData['recordCount'];
	$data['cartPrice'] = $resutlCartData['price'];
	//dd($resutlCartData['price']);
?>