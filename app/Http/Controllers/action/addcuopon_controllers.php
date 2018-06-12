<?php 
	
	use App\Http\Models\Cart;
	use App\Http\Models\Cart_detail;
	use App\Http\Models\Coupon;

	$this->validate($request,array('cartID'=>'required'));

	$cartID = $request->cartID?$request->cartID:0;
	$couponCode = $request->couponCode;
	
	$Coupon=new Coupon;
	$couponData=array('isActive'=>0);
	$query = $Coupon->where('couponEndDate','<',date('Y-m-d',strtotime('now')))
					->update($couponData);
	
	
	$couponData=array('couponCode'=>$couponCode,'isActive'=>1);
	$couponResult=$Coupon->getByAttributesQuery($couponData);

	if($couponResult['recordCount']>0)
	{
		$discountRate=$couponResult['data'][0]->discountRate;
		//if(($discountRate=$couponResult['data'][0]->discountRate)<$subtotal)
		//{
			$Cart=new Cart;
			$cartData=array('couponCodeID'=>$couponResult['data'][0]->couponID);
			$cartResult = $Cart->where('cartID',$cartID)
								 ->update($cartData);	
			
			
			$couponID=$couponResult['data'][0]->couponID;
			$discountRate=$couponResult['data'][0]->discountRate;
			$couponName=$couponResult['data'][0]->couponName;
			$discountType=$couponResult['data'][0]->discountType;
			$cuponDiscountData=array('couponID'=>$couponID,'couponName'=>$couponName,'discountType'=>$discountType,'discountRate'=>$discountRate);
			Session::put($cuponDiscountData);

			return Redirect::away(url('/').'/cart')->with(array('flash_message' => 'Your coupon code successfully applied'))->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
		//}
		/*else
		{
			//return Redirect::fun_redirect(url('/').'/cart')->with(array('flash_message' => 'Invalid coupon code'));
			return Redirect::away(url('/').'/cart')->withErrors(array('flash_message' => 'Invalid coupon code'))->send(); 
		}*/
	}
	else
	{
		return Redirect::away(url('/').'/cart')->withErrors(array('flash_message' => 'Invalid coupon code'))->send(); 
	}
?>