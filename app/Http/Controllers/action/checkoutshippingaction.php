<?php 
//===================================  Code Complete ======================================//
//																						   //
//				Check By Ranjit. Don't Change.anythig without asking senior.			   //
//				Some Function In "Custom Helper" Pelase check it.						   //
//				like checkcaptcha(); sendCustomerEmail();,sendAdminEmail()				   //
//				path : system\helpers\ folder "custom_helper.php"						   //
//																						   //
//===================================  Code Complete ======================================//

	use App\Http\Models\Customer;
	use App\Http\Models\Customer_address;
	use App\Http\Models\Cart;

	use Vinkas\Laravel\Recaptcha\ServiceProvider;
	Redirect::checkReferrerUrl(); //Redirection happen when direct access by page

	// Server Side Validation
	$this->validate($request,array('firstName'=>'required',
								   'lastName'=>'required',
								   'phone'=>'required',
								   'address1'=>'required',
								   'city'=>'required',
								   'state'=>'required|numeric',
								   'country'=>'required',
								   'zipcode'=>'required|numeric',
								   //'g-recaptcha-response' => 'required|recaptcha'
								));

	$customerAddressID = $request->customerAddressID?$request->customerAddressID: '0';
	$typeID = $request->typeID?$request->typeID: '1';
	$firstName = $request->firstName?$request->firstName: '';
	$lastName = $request->lastName?$request->lastName: '';
	$address1 = $request->address1?$request->address1: '';
	$address2 = $request->address2?$request->address2: '';
	$city = $request->city?$request->city: '';
	$state = $request->state?$request->state: '';
	$country = $request->country?$request->country: '';
	$zipcode = $request->zipcode?$request->zipcode: '';
	$phone = $request->phone?$request->phone: '';

		$min_amount = $request->min_amount?$request->min_amount: '5';



	$customerID = Session::get('customerID');
	
	$addressData=array('customerID'=>intval($customerID),
						'typeID'=>intval($typeID),
						'firstName'=>trim($firstName),
						'lastName'=>trim($lastName),
						'address1'=>trim($address1),
						'address2'=>trim($address2),
						'city'=>trim($city),
						'phone'=>trim($phone),
						'state'=>intval($state),
						'country'=>intval($country),
						'zipcode'=>intval($zipcode)
					);
	//dd($contactsData);

	if ($customerAddressID!= NULL && $customerAddressID > 0) 
	{
		$Customer_address= new Customer_address;
		$query = $Customer_address->where('customerAddressID', $customerAddressID)
							->update($addressData);
		
	}
	else
	{
		$Customer_address= new Customer_address($addressData);
		$Customer_address->save();
		$customerAddressID = $Customer_address->customerAddressID;	
	}

	$cartData = array('uID'=>$_COOKIE['uID']);
	$Cart=new Cart;
	$cartResult = $Cart->where($cartData)->get();
	if(count($cartResult)> 0){
		$cartData = array('billingID'=>$customerAddressID,'shippingID'=>$customerAddressID);
		$query = $Cart->where('cartID',$cartResult[0]->cartID)->update($cartData);
	}
	
	return Redirect::away(url('/').'/donate?token=44544548451841526484105451214842224481158411841 &&mio='.$min_amount.'&& nkjkbkbk=45451232545657895995959792659')->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

?>