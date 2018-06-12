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
	
	if($request->paymentType==1){
		$this->validate($request,array('cardType'=>'required',
									   'cardName'=>'required',
									   'cardNumber'=>'required|numeric',
									   'expMonth'=>'required',
									   'expYear'=>'required',
									   'cvvNumber'=>'required|numeric'
									));
	}
	
	//Payment Varible store in session[START]	
	$paymentType = $request->paymentType? $request->paymentType: '';	
	$cardType = $request->cardType? $request->cardType: '';
	$cardName = $request->cardName? $request->cardName: '';
	$cardNumber = $request->cardNumber? $request->cardNumber: '';
	$expMonth = $request->expMonth? $request->expMonth: '';
	$expYear = $request->expYear? $request->expYear: '';
	$cvvNumber = $request->cvvNumber? $request->cvvNumber: '';
	if($paymentType==1){	
		$paymentData = array('paymentType'=>$paymentType,
							  'cardType'=>$cardType,
							  'cardName'=>$cardName,
							  'cardNumber'=>$cardNumber,
							  'expMonth'=>$expMonth,
							  'expYear'=>$expYear,
							  'cvvNumber'=>$cvvNumber,
						  	);
	}else{
		$paymentData = array('paymentType'=>$paymentType,
							  'cardType'=>'',
							  'cardName'=>'',
							  'cardNumber'=>'',
							  'expMonth'=>'',
							  'expYear'=>'',
							  'cvvNumber'=>'',
						  	);
	}
	Session::put($paymentData);
	//Payment Varible store in session[END].
	
	$customerAddressID = $request->customerAddressID?$request->customerAddressID: '0';
	$typeID = $request->typeID?$request->typeID: '2';
	$firstName = $request->firstName?$request->firstName: '';
	$lastName = $request->lastName?$request->lastName: '';
	$address1 = $request->address1?$request->address1: '';
	$address2 = $request->address2?$request->address2: '';
	$city = $request->city?$request->city: '';
	$state = $request->state?$request->state: '';
	$country = $request->country?$request->country: '';
	$zipcode = $request->zipcode?$request->zipcode: '';
	$phone = $request->phone?$request->phone: '';
	$customerID = Session::get('customerID');
	
	$cartData = array('uID'=>$_COOKIE['uID'],'groupBy'=>'cart.cartID');
	$Cart=new Cart;
	$cartResult = $Cart->getByAttributesQuery($cartData);
	
	if($cartResult['recordCount'] > 0){

		/* If Billing Address and Shiping Adress Are same then not  need to add or update customer or cart table*/ 
		if($cartResult['data'][0]->shippingID != $cartResult['data'][0]->billingID){

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

			$cartData = array('billingID'=>$customerAddressID,'paymentType'=>$paymentType);
		}else{
			/* Update payment Type in cart table*/
			$cartData = array('paymentType'=>$paymentType);
		}
		$query = $Cart->where('cartID',$cartResult['data'][0]->cartID)->update($cartData);

		return Redirect::away(url('/').'/checkout-review')->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}else{
		return Redirect::away(url('/').'/cart')->send(); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
	}	


?>