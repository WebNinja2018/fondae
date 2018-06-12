<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Image;
use Session;
use DB;
use Mail;

use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Frm_contactus;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;
use App\Http\Models\Product_price;
use App\Http\Models\Cart_detail;
use App\Http\Models\Cart;
use App\Http\Models\States;
use App\Http\Models\Customer_address;

class Ajax_controllers extends Controller
{
	
	public function getPriceTotal(Request $request)
	{
		$sizeID=implode(",",$request->sizeID);
		$Product_price=new Product_price;
		$priceTotal=$Product_price->whereIn('sizeID',explode(',',$sizeID))->sum('price');
		echo $priceTotal;
	}

    public function updateCartQuantity(Request $request){
		$cartDetailID=$request->cartDetailID?$request->cartDetailID:'';
		$quantity=$request->quantity?$request->quantity:0;
		$this->validate($request,array('quantity'=>'required|numeric','cartDetailID'=>'required|numeric'));
		
		$cartData = array('uID'=>$_COOKIE['uID'],'cartDetailID'=>$cartDetailID);
		$Cart= new Cart;
		$cartResult = $Cart->getCardDataWithPrice($cartData);
		if($cartResult['sizeQuantity'] >= $quantity){
	
			$cartDetailData = array('quantity'=>$quantity);
			$cartDetailID = intval($cartDetailID);
			$Cart_detail= new Cart_detail;
			$query = $Cart_detail->where('cartDetailID', $cartDetailID)
								->update($cartDetailData);	
			
			$cartData = array('uID'=>$_COOKIE['uID'],'cartDetailID'=>$cartDetailID);
			$Cart= new Cart;
			$cartResult = $Cart->getCardDataWithPrice($cartData);
	
			$cartData="";
			if($cartResult['recordCount'] > 0){
				$cartData.= $cartResult['price']['cartproductTotal'].'~'.$cartResult['price']['cartDiscount'].'~'.$cartResult['price']['cartGrandTotal'];
			}
			echo '1~'.$cartData;
		}else{
			echo '2~'.$cartResult['sizeQuantity'];
		}
	}
	
	public function deleteCartProduct(Request $request){
		$cartDetailID=$request->cartDetailID?$request->cartDetailID:'';
		if(intval($cartDetailID) > 0){
			Cart_detail::destroy($cartDetailID);
			
			$cartData = array('uID'=>$_COOKIE['uID']);
			$Cart= new Cart;
			$cartResult = $Cart->getCardDataWithPrice($cartData);
			$cartData="";
			if($cartResult['recordCount'] > 0){
				$cartData.= $cartResult['price']['cartproductTotal'].'~'.$cartResult['price']['cartDiscount'].'~'.$cartResult['price']['cartGrandTotal'];
			}
			echo '1~'.$cartData;
		}else{
			echo 0;
		}	
	}

	public function deleteCart(Request $request){
		$cartID=$request->cartID?$request->cartID:'';
		if(intval($cartID) > 0){
			Cart::destroy($cartID);
		}
	}

	public function getallstate(Request $request){
		
		$country_id=$request->country_id?$request->country_id:0;
		
		$stateID=$request->stateID?$request->stateID:0;
		$stateData = array('country_id'=>$country_id);
		
		$States = new States;
		$qGetAllState= $States->getByAttributesQuery($stateData);
		$state="";
		if($qGetAllState['recordCount'] > 0){
				$state.="<option value=''>Please select state</option>";
				foreach($qGetAllState['data'] as $resulttAllState){
					if($resulttAllState->stateID==$stateID){
						$state.="<option value='".$resulttAllState->stateID."' selected='selected'>".$resulttAllState->stateName."</option>";
					}else{
						$state.="<option value='".$resulttAllState->stateID."'>".$resulttAllState->stateName."</option>";
					}
					
				}
		}else{
			$state="<option value=''>State not found</option>";
		}
		echo $state;
	}
	
	public function getAddressData(Request $request)
	{
		$customerAddressID=$request->customerAddressID?$request->customerAddressID:0;
		$typeID=$request->typeID?$request->typeID:0;
		
		$cartData = array('uID'=>$_COOKIE['uID'],'groupBy'=>'cart.cartID');
		$Cart= new Cart;
		$resultCart = $Cart->getByAttributesQuery($cartData);
		if($resultCart['recordCount'] > 0){
			$cartID = $resultCart['data'][0]->cartID;
		}else{
			$cartID = 0;
		}
		
		if(!$customerAddressID>0){
			//cart update shiping iD and billing id when address not selected.
			if($typeID==\Config::get('config.shippingTypeID',1)){
				$cartUpdatedata=array('shippingID'=>$customerAddressID);
			}else{
				$cartUpdatedata=array('billingID'=>$customerAddressID);
			}
			
			$query = $Cart->where('cartID',$cartID)
									->update($cartUpdatedata);	

			echo "0~Please select address!";
			exit;	
		}
		$addressData = array('customerAddressID'=>$customerAddressID);
		
		$Customer_address= new Customer_address;
		$addressResult = $Customer_address->getByAttributesQuery($addressData);
		if($addressResult['recordCount'] > 0){
			$firstName=$addressResult['data'][0]->firstName;
			$lastName=$addressResult['data'][0]->lastName;
			$address1=$addressResult['data'][0]->address1;
			$address2=$addressResult['data'][0]->address2;
			$country=$addressResult['data'][0]->country;
			$city=$addressResult['data'][0]->city;
			$state=$addressResult['data'][0]->state;
			$zipcode=$addressResult['data'][0]->zipcode;
			$phone=$addressResult['data'][0]->phone;
			if($cartID > 0){
				//cart update shiping iD and billing id when address selected.
				if($typeID==\Config::get('config.shippingTypeID',1)){
					$cartUpdatedata=array('shippingID'=>$customerAddressID);
				}else{
					$cartUpdatedata=array('billingID'=>$customerAddressID);
				}
				$query = $Cart->where('cartID',$cartID)
									->update($cartUpdatedata);
				echo "1~".$firstName."~".$lastName."~".$address1."~".$address2."~".$country."~".$city."~".$state."~".$zipcode."~".$phone;
				exit;
			}else{echo "0";exit;}
		}else{echo "0";exit;}
	}

}


