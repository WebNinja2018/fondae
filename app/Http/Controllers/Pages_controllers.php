<?php
//===================================  Code Complete ======================================//
//																						   //
//				Some Function In "Custom Funcation" Pelase check it.					   //
//				like Custom::checkLogin()				   				                   //
//				path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php   //
//																						   //
//===================================  Code Complete ======================================//

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Custom;
use Image;
use Session;
use DB;
use Mail;
use Cookie;

use App\Http\Models\Pages;
use App\Http\Models\Category_model;
use App\Http\Models\News;
use App\Http\Models\Slideshow;
use App\Http\Models\Portfolio;
use App\Http\Models\Testimonials;
use App\Http\Models\Staff;
use App\Http\Models\Product;

use App\Http\Models\Country;
use App\Http\Models\Cart;
use App\Http\Models\Customer_address;

class Pages_controllers extends Controller
{
        public function admin(){

		return view('dynamic.adminlogin');

	}
	public function contactsubmit(){
		$data=Input::all();

		Mail::send("emails.contactus_form",[
			 'name' => $data['name'],
			 'email' => $data['email'],
			 'bodyMessage' => $data['message'],

		 ], function($m)use($data){
			 $m->to('contact@fondae.com')->subject('Contact us form data');
		 });
                  $_POST['formID']=\Config::get('config.orderFormID',1);
		 return Redirect::fun_redirect(url('/').'/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php

	}
    public function index(Request $request, $filename='home' , $urlName='')
	{

		//print_r(Session::all());
		$Pages= new Pages;
		$PagesData = array('pageFileName'=>$filename,'isActive'=>1);
		$pagesResult=$Pages->getByAttributesQuery($PagesData);
	
		if($pagesResult['recordCount'] > 0){
			$data['qGetPagesResult'] = $pagesResult['data'];
			$data['pagesRecordCount'] = $pagesResult['recordCount'];
			$frameName = $data['qGetPagesResult'][0]->frameName;
			if($frameName=='frameWithLeftSide'){
				
				/*======================================*/
				//  for Product Category  [START]	    //
				/*======================================*/
				$Category= new Category_model;
				$productCategoryData=array(
									'categorytypeID'=>\Config::get('config.productCategorytypeID','3'),
									//'isFeatured'=>1,
									'explore_page'=>'1',
									'orderBy'=>'displayOrder'
									);
			
				$productCategoryResult=$Category->getByAttributesQuery($productCategoryData);
				//dd($productCategoryResult);
				$data['qGetProductCategoryResult'] = $productCategoryResult['data'];
				$data['ProductCategoryRecordCount'] = $productCategoryResult['recordCount'];
				/*======================================*/
				//  for Product Category  [END]	    //
				/*======================================*/
				
			}
			elseif($frameName=='frameWithCheckout')
			{
				Custom::checkLoginAndWithGuest();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php

				$Country=new Country;
				$resultCountry = $Country->getByAttributesQuery('');
				$data['qGetCountryData'] = $resultCountry['data'];
				$data['countryRecordCount'] = $resultCountry['data'];
				
				$cartData = array('uID'=>$_COOKIE['uID'],'groupBy'=>'product_size.sizeID');
				$Cart=new Cart;
				$cartResult=$Cart->getCardDataWithPrice($cartData);
				$data['qGetCartData'] = $cartResult['data'];
				$data['cartRecordCount'] = $cartResult['recordCount'];
				$data['cartPrice'] = $cartResult['price'];

				if($filename!='order-history'){
					//if($data['cartRecordCount']==0){return Redirect::fun_redirect(url('/').'/explore');}
					if($data['cartRecordCount']==0){return Redirect::fun_redirect(url('/'));}
				}
			}
			elseif($frameName=='frameWithMyAccount')
			{
				Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
				$customerType = Session::get('customerType');
				$customerID = Session::get('customerID');
			}

			if(file_exists(public_path().'/app/Http/Controllers/include/'.$filename.'_controllers.php'))
			{
				@include(public_path().'/app/Http/Controllers/include/'.$filename.'_controllers.php');	
			} 

			/*======================================*/
			//  for Staff  [START]	    //
			/*======================================*/
			$Staff= new Staff;
			$staffData=array( 'isFeatured'=>1,
								'isActive'=>1,
								'orderBy'=>'displayOrder'
								);
		
			$staffResult=$Staff->getByAttributesQuery($staffData);
			$data['qGetStaffResult'] = $staffResult['data'];
			$data['StaffRecordCount'] = $staffResult['recordCount'];
			/*======================================*/
			//  for Staff [END]	    //
			/*======================================*/

			/*======================================*/
			//  for USEFUL-LINKS Footer  [START]	    //
			/*======================================*/
			$LinksData = array('pageType'=>2,'isActive'=>1);
			$linksResult=$Pages->getByAttributesQuery($LinksData);
		
			$data['qGetLinksResult'] = $linksResult['data'];
			$data['LinksRecordCount'] = $linksResult['recordCount'];
			/*======================================*/
			//  for USEFUL-LINKS Footer [END]	    //
			/*======================================*/

			/*======================================*/
			//  for About us Footer  [START]	    //
			/*======================================*/
			$AboutData = array('pageFileName'=>"about",'isActive'=>1);
			$aboutResult=$Pages->getByAttributesQuery($AboutData);
		
			$data['qGetAboutResult'] = $aboutResult['data'];
			$data['AboutRecordCount'] = $aboutResult['recordCount'];
			/*======================================*/
			//  for About us Footer [END]	        //
			/*======================================*/

			$data['filename']= $filename;
			$data['frameName']= $frameName;
			$data['urlName']= $urlName;
			//dd($data);
			return view($frameName,$data);
			
		}else{
			return Redirect::to('page-not-found');
		}
	}

	public function customeraddressaddedit(Request $request, $urlName='')
	{
		Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
		$customerID = Session::get('customerID');

		$Country=new Country;
		$resultCountry = $Country->getByAttributesQuery('');
		$data['qGetCountryData'] = $resultCountry['data'];
		$data['countryRecordCount'] = $resultCountry['data'];
	
		$data['customerAddressID']=$request->customerAddressID;
		$data['typeID']=$request->typeID;
		if($data['customerAddressID'] > 0){
			$addressData = array('customerAddressID'=>$data['customerAddressID'],'typeID'=>$data['typeID']);
			$Customer_address=new Customer_address;
			$addressResult = $Customer_address->getByAttributesQuery($addressData);
			$data['qGetAddressData'] = $addressResult['data'];
			$data['addressRecordCount'] = $addressResult['recordCount'];
		}
		
		return view('dynamic.customeraddressaddedit',$data);	
	}
	

	
}
