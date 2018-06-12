<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Models\Coupon;

class Cart extends Model
{
	protected $table = "cart";
	protected $primaryKey = "cartID";
	protected $fillable = array('uID','billingID','shippingID','couponCodeID','cardID','paymentType','priceID');
	
	function getByAttributesQuery($data)
    {
		$query = DB::table('cart');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('cart.*','product.productName','product.prodcutImage','product.itemnumber','product.url_title','product_size.sizeName','cart_detail.cartDetailID','cart_detail.quantity','product_price.price');
		}
		if(isset($data['uID']) && strlen(trim($data['uID'])) > 0)
		{
			$query->where('cart.uID',$data['uID']);
		}
                if(isset($data['priceID']) && strlen(trim($data['priceID'])) > 0)
		{
			$query->where('cart.priceID',$data['priceID']);
		}
		if(isset($data['billingID']) && strlen(trim($data['billingID'])) > 0)
		{
			$query->where('cart.billingID',$data['billingID']);
		}
		if(isset($data['shippingID']) && strlen(trim($data['shippingID'])) > 0)
		{
			$query->where('cart.shippingID',$data['shippingID']);
		}
		if(isset($data['couponCodeID']) && strlen(trim($data['couponCodeID'])) > 0)
		{
			$query->where('cart.couponCodeID',$data['couponCodeID']);
		}
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('cart.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('cart.updated_at',$data['updated_at']);
        }
		if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
        {
			if(isset($data['order']) && strlen(trim($data['order'])) > 0)
			{
           		$query->orderBy($data['orderBy'],$data['order']);
        	}else{
				$query->orderBy($data['orderBy']);
			}
		}
        if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
        {
            $query->groupBy($data['groupBy']);
        }

		$query->Leftjoin('cart_detail','cart_detail.cartID','=','cart.cartID');
		$query->Leftjoin('product','product.productID','=','cart_detail.productID');	
		$query->Leftjoin('product_size','product_size.sizeID','=','cart_detail.sizeID');
		$query->Leftjoin('product_price','product_price.sizeID','=','product_size.sizeID');

		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }

		$result['recordCount'] = count($result['data']);
        return $result;
    }

	function getCardDataWithPrice($data)
    {
        
		$query = DB::table('cart');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('cart.*','product.*','product_size.sizeID','product_size.sizeName','product_price.quantity as sizeQuantity','cart_detail.cartDetailID','cart_detail.quantity','product_price.price');
		}
		if(isset($data['uID']) && strlen(trim($data['uID'])) > 0)
		{
			$query->where('cart.uID',$data['uID']);
		}
		if(isset($data['billingID']) && strlen(trim($data['billingID'])) > 0)
		{
			$query->where('cart.billingID',$data['billingID']);
		}
		if(isset($data['shippingID']) && strlen(trim($data['shippingID'])) > 0)
		{
			$query->where('cart.shippingID',$data['shippingID']);
		}
		if(isset($data['couponCodeID']) && strlen(trim($data['couponCodeID'])) > 0)
		{
			$query->where('cart.couponCodeID',$data['couponCodeID']);
		}
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('cart.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('cart.updated_at',$data['updated_at']);
        }
		if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
        {
			if(isset($data['order']) && strlen(trim($data['order'])) > 0)
			{
           		$query->orderBy($data['orderBy'],$data['order']);
        	}else{
				$query->orderBy($data['orderBy']);
			}
		}
        if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
        {
            $query->groupBy($data['groupBy']);
        }

		$query->Leftjoin('cart_detail','cart_detail.cartID','=','cart.cartID');
		$query->Leftjoin('product','product.productID','=','cart_detail.productID');	
		$query->Leftjoin('product_size','product_size.sizeID','=','cart_detail.sizeID');
		$query->Leftjoin('product_price','product_price.sizeID','=','product_size.sizeID');

	
		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }
		
		$result['recordCount'] = count($result['data']);
		

		if($result['recordCount'] > 0){
			$result['cartID']= $result['data'][0]->cartID;
			$shippingTotal = $result['data'][0]->shippingTotal;
			$result['sizeQuantity']=$result['data'][0]->sizeQuantity;
			$couponCodeID=$result['data'][0]->couponCodeID;		
		}else{
			$result['cartID']= 0;
			$shippingTotal = 0;
			$couponCodeID=0;		
		}
		$cartDiscount = 0;
		$cartproductTotal = 0;
		$cartGrandTotal = 0;
		foreach($result['data'] as $GetCartData){ 
					$total = $GetCartData->price*$GetCartData->quantity;
					$cartproductTotal = $cartproductTotal+$total;
					$cartGrandTotal = $cartGrandTotal+$total;
				}
		
		if($couponCodeID>0){
		  $Coupon=new Coupon;
		  $CouponData=$Coupon->find($couponCodeID);
		  $result['couponCode']=$CouponData->couponCode;
		  $discountType=$CouponData->discountType;
		  $discountRate=$CouponData->discountRate;

		  if($discountType==1) /*Percentage Calculattion Discount*/
		  {
			  $cartDiscount = ($cartproductTotal*$discountRate)/100;
		  }
		  else if($discountType==2) /*Flat Rate Calculation*/
		  {
			  $cartDiscount=$discountRate;
		  }
		}

		$price['cartDiscount'] = number_format($cartDiscount,2);	
		$price['cartproductTotal'] = number_format($cartproductTotal,2);	
		$price['cartGrandTotal'] = number_format($cartGrandTotal,2);
		$price['shippingTotal'] = number_format($shippingTotal,2);	
		$taxTotal = ($cartGrandTotal * (\Config::get('config.Tax','15'))/ 100);
		$price['taxTotal'] = number_format($taxTotal,2);
		$price['cartGrandTotal'] = number_format(($cartGrandTotal - $cartDiscount),2);
		$price['grandTotal'] = number_format(($cartGrandTotal + $shippingTotal + $taxTotal - $cartDiscount),2);
		$result['price'] = $price;	

        return $result;
    }
}
