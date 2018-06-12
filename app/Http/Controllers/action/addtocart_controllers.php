<?php 
	
	use App\Http\Models\Cart;
	use App\Http\Models\Cart_detail;
	$productID = $request->productID?$request->productID:0;
	$sizeID = $request->sizeID?$request->sizeID:0;
	$quantity = $request->quantity?$request->quantity:1;
	$this->validate($request,array('sizeID'=>'required','productID'=>'required','quantity'=>'required|numeric'));
	$cartData=array('uID'=>$_COOKIE['uID']);
	
	$Cart=new Cart;
	$Cart_detail= new Cart_detail;
	$resutlCartData=$Cart->where($cartData)->get();
	
	if(count($resutlCartData)>0){
		$cartID = $resutlCartData[0]->cartID;	
		$Cart->where('uID', '=', $_COOKIE['uID'])->delete();
		foreach($resutlCartData as $resutlCartData)
		{
			$Cart_detail->where('cartID', '=', $resutlCartData->cartID)->delete();
		}
	}
	
	$cartAddData = array('uID'=>$_COOKIE['uID'],
						 'billingID'=>0,
						 'shippingID'=>0,
						 'couponCodeID'=>0,
						 'cardID'=>0,
                                                  'priceID'=>$request->priceID,
						 'paymentType'=>0,
						 'shippingTotal'=>0,
						 'shippingMethod'=>'',
						);
	
	$Cart= new Cart($cartAddData);
	$Cart->save();
	$cartID = $Cart->cartID;
	foreach($sizeID as $sizeID)
	{
		$cartDetailData = array('cartID'=>$cartID,
								'productID'=>$productID,
								'itemID'=>0,
								'sizeID'=>$sizeID,
								'quantity'=>$quantity);

		$Cart_detail= new Cart_detail($cartDetailData);
		$Cart_detail->save();
		$cartDetailID = $Cart_detail->cartDetailID;
	}
	
	return Redirect::fun_redirect(url('/').'/donate')->with(array('flash_message' => ''));
	
?>