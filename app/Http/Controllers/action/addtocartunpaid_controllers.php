<?php 
	
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Input;
	use Symfony\Component\HttpFoundation\File\UploadedFile;
	use Symfony\Component\HttpFoundation\Session\Session1;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Custom;
	use Session as session;
	use DB as db;
	use Mail as Mail;

	use App\Http\Models\Frm_mailing_list;
	use App\Http\Models\Frm_contactus;
	use App\Http\Models\Emailautoresponse;
	use App\Http\Models\Adminemail;
	use App\Http\Models\Emailsetting;
	use App\Http\Models\Product_price;
	
	use App\Http\Models\Country;
	use App\Http\Models\Cart;
	use App\Http\Models\Cart_detail;
	use App\Http\Models\Customer_address;
	use App\Http\Models\Orders;
	use App\Http\Models\Order_details;

	$productID = $request->productID?$request->productID:0;
	$sizeID = $request->sizeID?$request->sizeID:0;
	$sizeName = $request->sizeName?$request->sizeName:'';
	$quantity = $request->quantity?$request->quantity:1;
	$unpaidOption= $request->unpaidOption?$request->unpaidOption:1;
	$email = $request->email?$request->email:'';
	$productName = $request->productName?$request->productName:'';
	$eventshare_image='';

	$this->validate($request,array('image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048'),['max' => 'The :attribute may not be greater than :max kilobytes.',]);
	if($unpaidOption==1){
		//$this->validate($request,array('sizeID'=>'required','productID'=>'required','email'=>'required|email'));
	}else{
		//$this->validate($request,array('sizeID'=>'required','productID'=>'required','image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		
		$image = $request->file('image');
		
		if($image){
			
			//$input['imagename'] = $request->portfolioImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/eventshare');
			$img = Image::make($image->getRealPath());
			
			//Start Resize image creat
			$img->resize(200, 200, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/th_'.$input['imagename']);
			
			$img->resize(458, 1024, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/mi_'.$input['imagename']);
			//End Resize image creat
			
			$image->move($destinationPath, $input['imagename']);
			$eventshare_image=$input['imagename'];
			
		}
	}
	
	
	$orderData=array('customerID'=>session::get('customerID'),
					 'billingID'=>0,
					 'orderNumber'=>1,
					 'shippingID'=>0,
					 'grandTotal'=>0,
					 'subTotal'=>0,
					 'shippingTotal'=>0,
					 'discount'=>0,
					 'tax'=>0,
					 'orderStatus'=>1,		
					 'paymentMethod'=>0,	
					 'discountCouponID'=>0,
					 'orderTypeID'=>1,
					 'eventType'=>2
					);
	
	$Orders= new Orders($orderData);
	$Orders->save();
	$orderID = $Orders->orderID;	
	
	$orderID = $Orders->orderID;	
			
	$orderNumber=date('Ymd',strtotime('now')).$orderID;
	$orderInfo=array('orderNumber'=>$orderNumber);
	$Orders= new Orders;
	$query = $Orders->where('orderID', $orderID)
								->update($orderInfo);
								
	Order_details::where('orderID', $orderID)->delete(); //Delete Order Details

	//ADD Order Details[Start]
	
	$orderDetailData=array(
						   'customerID'=>session::get('customerID'),
						   'productID'=>$productID, 	
						   'sizeID'=>$sizeID,	
						   'itemID'=>0,	
						   'orderID'=>$orderID,
						   'cardID'=>0,	
						   'productName'=>$productName, 	
						   'price'=>0,	
						   'product_quantity'=> 1,	
						   'total'=>0,
						   'itemName'=>'',
						   'sizeName'=>$sizeName,
						   'email'=>$email,
						   'image'=>$eventshare_image,
						   );

	$Order_details= new Order_details($orderDetailData);
	$Order_details->save();
	$orderDetailsID = $Order_details->orderDetailsID;	

	$Product_price=new Product_price;
	$data=array('sizeID'=>$sizeID,'productID'=>$productID);
	$productDetaile=$Product_price->where($data)->decrement('remainingQuantity');
	
	$_POST['formID']=\Config::get('config.orderFormID',8);
	return Redirect::fun_redirect(url('/').'/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

?>