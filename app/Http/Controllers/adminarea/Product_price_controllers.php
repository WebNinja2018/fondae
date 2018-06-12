<?php

namespace App\Http\Controllers\Adminarea;

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

//Load Models
use App\Http\Models\Product;
use App\Http\Models\Product_category;
use App\Http\Models\Product_price;
use App\Http\Models\Product_size;
use App\Http\Models\Product_item;
use App\Http\Models\Category_model;
use App\Http\Models\Categorytype;
use App\Http\Models\Adminmenu;
use Illuminate\Support\Facades\Custom;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;


class Product_price_controllers extends Controller
{
	function addeditproductprice(Request $request)
	{
		$priceID = $request->priceID?$request->priceID:'';
		$productID = $request->productID?$request->productID:0;	
		$priceData =array('priceID'=>$priceID);
		$data['priceID'] = $priceID;
		$Product_price= new Product_price;
		$qGetPriceData = $Product_price->getByAttributesQuery($priceData);
		$data['qGetPriceData'] = $qGetPriceData['data'];
		$data['priceRecordCount'] = $qGetPriceData['recordCount'];
		
		// For Product Size.
		$prductSizeData = array('productID'=>$productID);
		$Product_size= new Product_size;
		$qGetProductSizeData=$Product_size->getByAttributesQuery($prductSizeData);
		$data['qGetProductSizeData'] = $qGetProductSizeData['data'];
		$data['prodcutSizeRecordCount'] = $qGetProductSizeData['recordCount'];
		
		// For Product Iteam.
		$prductItemData = array('productID'=>$productID);
		$Product_item= new Product_item;
		$qGetProductIteamData=$Product_item->getByAttributesQuery($prductItemData);
		$data['qGetProductIteamData'] = $qGetProductIteamData['data'];
		$data['prodcutIteamRecordCount'] = $qGetProductIteamData['recordCount'];
		
		//For Price category
		$categoryData = array('categorytypeID'=>\Config::get('config.productPriceCategorytypeID','9'),'isActive'=>1);
		$Category_model= new Category_model;
		$qGetPriceCategory=$Category_model->getByAttributesQuery($categoryData);
		$data['qGetPriceCategory']=$qGetPriceCategory['data'];
		$data['priceCategoryRecordCount']=$qGetPriceCategory['recordCount'];
		
		return view('adminarea.product.product_size.product_price_addedit',$data);
	}
	

	function updateprice(Request $request){
		
		$priceCategoryCount = sizeof($_POST['categoryID']);
		$priceID = $request->priceID?$request->priceID:'';
		$productID = $request->productID?$request->productID:0;
		$sizeID = $request->sizeID?$request->sizeID:0;
		$sizeName = $request->sizeName?$request->sizeName:'';
		$itemID = $request->itemID?$request->itemID:0;
		$quantity = $request->quantity?$request->quantity:0;
		$isActive = $request->isActive?$request->isActive:0;
		$price = $request->price?$request->price:0;
		$categoryID = $request->categoryID?$request->categoryID:0;
		$description = $request->description?$request->description:0;
		$eventType = $request->eventType?$request->eventType:0;
		$unpaidOption = $request->unpaidOption?$request->unpaidOption:0;
		
		$this->validate($request,array('sizeID'=>'required','sizeName'=>'required','itemID'=>'required','quantity'=>'required'));

		
		//for($j=0;$j<$priceCategoryCount;$j++){
//			$categoryID = $_POST['categoryID'][$j];
//			$this->validate($request,array('categoryID_'.$categoryID=>'required'));
//			$price = $this->input->post('categoryID_'.$_POST['categoryID'][$j])?$this->input->post('categoryID_'.$_POST['categoryID'][$j]):'';
//		}
//
//		for($j=0;$j<$priceCategoryCount;$j++){
//			$categoryID = $_POST['categoryID'][$j];
//			$price = $request->categoryID_.$categoryID?$request->categoryID_.$categoryID:'';
//			$prodcutPriceData = array('productID'=>$productID,
//									  'sizeID'=>$sizeID,
//									  'itemID'=>$itemID,
//									  'categoryID'=>$categoryID,
//									  'price'=>$price,
//									  'quantity'=>$quantity,
//									  'isActive'=>$isActive
//			);
//			
//			if ($request->priceID!= NULL && $request->priceID > 0) 
//			{
//				$Product_price= new Product_price;
//				$query = $Product_price->where('priceID', $priceID)
//									->update($prodcutPriceData);
//				$UpdatepriceID =$priceID;
//				
//			}
//			else
//			{
//				$Product_price= new Product_price($prodcutPriceData);
//				$Product_price->save();
//				$UpdatepriceID = $Product_price->priceID;
//	
//			}
//		}

		$prodcutPriceData = array('productID'=>$productID,
									  'sizeID'=>$sizeID,
									  'itemID'=>$itemID,
									  'categoryID'=>$categoryID,
									  'price'=>$price,
									  'quantity'=>$quantity,
									  'remainingQuantity'=>$quantity,
									  'isActive'=>$isActive
									  
			);
			
			if ($request->priceID!= NULL && $request->priceID > 0) 
			{
				$Product_price= new Product_price;
				$query = $Product_price->where('priceID', $priceID)
									->update($prodcutPriceData);
				$UpdatepriceID =$priceID;
				
			}
			else
			{
				$Product_price= new Product_price($prodcutPriceData);
				$Product_price->save();
				$UpdatepriceID = $Product_price->priceID;
	
			}
			
			$record = array('sizeName'=>$sizeName, 
							'description'=>$description,
							 'eventType'=>$eventType,
							 'unpaidOption'=>$unpaidOption,
							);
			$product_size= new Product_size;
			$query = $product_size->where('sizeID', $sizeID)
								->update($record);
									
		$_POST['message'] = 'Information saved!';
		$_POST['messageClass'] = 'alert-success';
		echo '<script>window.parent.tb_remove();window.parent.location.reload();</script>';
		exit;
	}
	function saveproductprice(Request $request)
	{	
		$priceCategoryCount = sizeof($_POST['categoryID']);
		//$priceCount = sizeof($_POST['sizeID']) - 1;
		$priceCount = 1;
		$productID = $request->productID?$request->productID:0;
		$product= new Product;
		$productDetail=$product->find($productID);
		$tab = $request->tab;
		$url_title=$productDetail->url_title;
		//for($i=0; $i<$priceCount; $i++){
//			$this->validate($request,array('sizeID['.$i.']'=>'required','itemID['.$i.']'=>'required','quantity['.$i.']'=>'required'));
//			for($j=0;$j<$priceCategoryCount;$j++){
//				$categoryID = $_POST['categoryID'][$j];
//				$this->validate($request,array('categoryID_'.$categoryID.'['.$i.']'=>'required'));
//			}
//		}
		//$this->validate($request,array('sizeID'=>'required','itemID'=>'required','quantity'=>'required'));

		for($i=0; $i<$priceCount; $i++){
			$priceID = $request->priceID[$i]?$request->priceID[$i]:'';
			//$sizeID = $request->sizeID[$i]?$request->sizeID[$i]:0;
			$sizeName = $request->sizeName[$i]?$request->sizeName[$i]:'';
			$itemID = $request->itemID[$i]?$request->itemID[$i]:0;
			$quantity = $request->quantity[$i]?$request->quantity[$i]:0;
			$description = $request->description[$i]?$request->description[$i]:0;
			$eventType = $request->eventType[$i]?$request->eventType[$i]:0;

			$socialid = $request->socialid[$i]?$request->socialid[$i]:0;

			$unpaidOption = $request->unpaidOption[$i]?$request->unpaidOption[$i]:0;
			$isActive = $request->isActive[$i]?$request->isActive[$i]:1;
				
				$record = array( 'productID'=>$productID,
								 'sizeName'=>$sizeName,
								 'sizeNumber'=>'',
								 'description'=>$description,
								 'eventType'=>$eventType,
								 'social_id'=>$socialid,
							     'unpaidOption'=>$unpaidOption,
							   );
				
				$product_size= new Product_size($record);
				$product_size->save();
				$sizeID = $product_size->sizeID;
				
				for($j=0;$j<$priceCategoryCount;$j++){
					$categoryID = $_POST['categoryID'][$j];
					$price = $request->input('categoryID_'.$categoryID, '');
					$price = $price[$i];
					$prodcutPriceData = array('productID'=>$productID,
											  'sizeID'=>$sizeID,
											  'itemID'=>$itemID,
											  'categoryID'=>$categoryID,
											  'price'=>$price,
											  'quantity'=>$quantity,
											  'remainingQuantity'=>$quantity,
											  'isActive'=>$isActive,
					);
					if ($priceID!= NULL && $priceID > 0) 
					{
						$product_price= new Product_price;
						$query = $product_price->where('priceID', $priceID)
											->update($prodcutPriceData);
						$UpdatepriceID =$priceID;
						
					}
					else
					{
						$product_price= new Product_price($prodcutPriceData);
						$product_price->save();
						$UpdatepriceID = $product_price->priceID;
						
					}
				}
				
		}
		//if($request->isBack==1){
//			$_POST['productID'] = $productID;
//			$_POST['message'] = 'Information saved!';
//			$_POST['messageClass'] = 'alert-success';
//			$path = url('/')."/adminarea/product/addeditproduct#meta_tab";
//		}else{
//			$path = Input::get('redirects_to');
//		}

		$isDraft=$request->isDraft;
		if($request->isBack!=1){
				//$isDraft=1;
									
				//if($tab==3)
				//{
					  /*======================================*/
					  //  Email Sent To Customer  [START]
					  /*======================================*/
					  $formData=array('formID'=>\Config::get('config.eventFormID',3));
					  $emailautoresponse= new Emailautoresponse;
					  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
					  
					  if($autoResponceResult['recordCount'] > 0){
						  
						  $subject = $autoResponceResult['data'][0]->subject;
						  $description = $autoResponceResult['data'][0]->message1;
						  
						  $mailDescription='';
						  $mailDescription.='<html xmlns="http://www.w3.org/1999/xhtml">
										  <head>
										  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										  <title>Fondae</title>
										  </head>
										  <body style="margin:0px; padding:0px;">
										   <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style=" background:#FFF;">
													  <td style="text-align:left;padding-bottom: 30px;">
														  <a href="'.url('/').'"><img src="'.url('/').'/frontend/images/Charity-logo_03.png" alt="Fondae" title="Fondae" width="50%"></a>
													  </td>
													  <td style=" padding:12px 0px 30px;text-align:right;margin:5px 0px;">
														  <a href="'.url('/').'/" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Home</a>
														  <a href="'.url('/').'/explore" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">Explore</a>
														  <a href="'.url('/').'/about"  target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">How It Works</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style="font-family:arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Login</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style=" font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Signup</a>
													  </td>
												  </tr>
												 </tbody>
										   </table>';
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0"><tbody><tr style=" background:#FFF;"><td style="text-align:left;padding-bottom: 30px;">'.$description.'</td></tr></tbody></table>'; 
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style="background:#2F374C; width:100%;">
													  <td style="padding:15px 0px 15px; text-align:center;" colspan="3">
														  <p style=" color:#e8ae00; font-family:arial;font-size:14px;font-weight:600;">Copyright By :<a href="##" target="_blank" title="HR Infocare" style="color:#e8ae00; font-weight:600; text-decoration:none; font-size:12px;">  Fondae.com</a></p>
													  </td>
												  </tr>
											  </tbody>
										  </table>
										  </body>
										  </html>';
							$msg = $mailDescription;
						  
						  $from=\Config::get('config.fromEmail');
						  $name=\Config::get('config.fromEmailName');
						  $to=Session::get('admin_email');
						  
						  if(\Config::get('config.sendEmail')==1){
							  
							  $emailData=array(
												'name'=>$name,
												'from'=>$from,
												'to'=>$to,
												'subject'=>$subject,
												'message'=>$msg
											  );
											  
							  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
						  }
					  }
					  
					  /*======================================*/
					  //  Email Sent To Customer  [END]
					  /*======================================*/
					  
					  /*======================================*/
					  //  Email Sent To Admin  [START]
					  /*======================================*/
					  $adminemail= new Adminemail;
					  $sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
					  
					  if($sqlAdminEmailResult['recordCount'] > 0){
						  $adminsubject = $sqlAdminEmailResult['data'][0]->adminsubject;
						  $adminemailcontent = $sqlAdminEmailResult['data'][0]->adminemail;
						  $adminemailcontent = str_replace('{var_email}',Session::get('admin_email'),$adminemailcontent);
						  $projectLink='<a href="'.url("/").'/event/'.$url_title.'"  target="_blank">Click Here!</a>';
						  $adminemailcontent = str_replace('{var_projectLink}',$projectLink,$adminemailcontent);
						  
						  $mailDescription='';
						  $mailDescription.='<html xmlns="http://www.w3.org/1999/xhtml">
										  <head>
										  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										  <title>Fondae</title>
										  </head>
										  <body style="margin:0px; padding:0px;">
										   <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style=" background:#FFF;">
													  <td style="text-align:left;padding-bottom: 30px;">
														  <a href="'.url('/').'"><img src="'.url('/').'/frontend/images/Charity-logo_03.png" alt="Fondae" title="Fondae" width="50%"></a>
													  </td>
													  <td style=" padding:12px 0px 30px;text-align:right;margin:5px 0px;">
														  <a href="'.url('/').'/" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Home</a>
														  <a href="'.url('/').'/explore" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">Explore</a>
														  <a href="'.url('/').'/about"  target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">How It Works</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style="font-family:arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Login</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style=" font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Signup</a>
													  </td>
												  </tr>
												 </tbody>
										   </table>';
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0"><tbody><tr style=" background:#FFF;"><td style="text-align:left;padding-bottom: 30px;">'.$adminemailcontent.'</td></tr></tbody></table>'; 
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style="background:#2F374C; width:100%;">
													  <td style="padding:15px 0px 15px; text-align:center;" colspan="3">
														  <p style=" color:#e8ae00; font-family:arial;font-size:14px;font-weight:600;">Copyright By :<a href="##" target="_blank" title="HR Infocare" style="color:#e8ae00; font-weight:600; text-decoration:none; font-size:12px;">  Fondae.com</a></p>
													  </td>
												  </tr>
											  </tbody>
										  </table>
										  </body>
										  </html>';
							 $adminemailcontent = $mailDescription;
							
						  $emailsettingData=array('formID'=>\Config::get('config.eventFormID',3),'emailType'=>1,'isActive'=>1);
						  
						  $emailsetting= new Emailsetting;
						  $sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
					  
						  foreach($sqlmail['data'] as $adminemail) {
								  $adminTo= $adminemail->email;
								  $from=\Config::get('config.fromEmail');
								  $name=\Config::get('config.fromEmailName');
								  
								  $to=$adminTo;
								  
								  if(\Config::get('config.sendEmail')==1){
									  
									  $emailData=array(
														'name'=>$name,
														'from'=>$from,
														'to'=>$to,
														'subject'=>$adminsubject,
														'message'=>$adminemailcontent
													  );
									  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
							  
								 }
						  }
					  }
					
					
					  /*======================================*/
					  //  Email Sent To Admin  [END]
					  /*======================================*/	
					
				//}	
		}
		$productTab=array('tab'=>4,'isDraft'=>'1');// tab =4 : all stap completed
		$query = $product->where('productID', $productID)
							->update($productTab);
							
		$_POST['productID'] = $productID;
		$_POST['message'] = 'Information saved!';
		$_POST['messageClass'] = 'alert-success';
		$path = url('/')."/adminarea/product/addeditproduct#meta_tab";
		
		return Redirect::fun_redirect($path)->withInput()->with(array('flash_message' => 'Product Price successfully added'));
	}
	
	function saveproductgolive(Request $request)
	{	
		$priceCount = 1;
		$productID = $request->productID?$request->productID:0;
		$product= new Product;
		$productDetail=$product->find($productID);
		$tab = $request->tab;
		$url_title=$productDetail->url_title;
		
		$isDraft=$request->isDraft;
		$productTab=array('tab'=>4,'isDraft'=>$isDraft);// tab =4 : all stap completed
		$query = $product->where('productID', $productID)
							->update($productTab);
												
				//if($tab==3)
				//{
					  /*======================================*/
					  //  Email Sent To Customer  [START]
					  /*======================================*/
					  $formData=array('formID'=>\Config::get('config.eventFormID',3));
					  $emailautoresponse= new Emailautoresponse;
					  $autoResponceResult=$emailautoresponse->getByAttributesQuery($formData);
					  
					  if($autoResponceResult['recordCount'] > 0){
						  
						  $subject = $autoResponceResult['data'][0]->subject;
						  $description = $autoResponceResult['data'][0]->message1;
						  
						  $mailDescription='';
						  $mailDescription.='<html xmlns="http://www.w3.org/1999/xhtml">
										  <head>
										  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										  <title>Fondae</title>
										  </head>
										  <body style="margin:0px; padding:0px;">
										   <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style=" background:#FFF;">
													  <td style="text-align:left;padding-bottom: 30px;">
														  <a href="'.url('/').'"><img src="'.url('/').'/frontend/images/Charity-logo_03.png" alt="Fondae" title="Fondae" width="50%"></a>
													  </td>
										  <td style=" padding:12px 0px 30px;text-align:right;margin:5px 0px;">
														  <a href="'.url('/').'/" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Home</a>
														  <a href="'.url('/').'/explore" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">Explore</a>
														  <a href="'.url('/').'/about"  target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">How It Works</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style="font-family:arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Login</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style=" font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Signup</a>
													  </td>
												  </tr>
												 </tbody>
										   </table>';
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0"><tbody><tr style=" background:#FFF;"><td style="text-align:left;padding-bottom: 30px;">'.$description.'</td></tr></tbody></table>'; 
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style="background:#2F374C; width:100%;">
													  <td style="padding:15px 0px 15px; text-align:center;" colspan="3">
														  <p style=" color:#e8ae00; font-family:arial;font-size:14px;font-weight:600;">Copyright By :<a href="##" target="_blank" title="HR Infocare" style="color:#e8ae00; font-weight:600; text-decoration:none; font-size:12px;">  Fondae.com</a></p>
													  </td>
												  </tr>
											  </tbody>
										  </table>
										  </body>
										  </html>';
							$msg = $mailDescription;
						  
						  $from=\Config::get('config.fromEmail');
						  $name=\Config::get('config.fromEmailName');
						  $to=Session::get('admin_email');
						  
						  if(\Config::get('config.sendEmail')==1){
							  
							  $emailData=array(
												'name'=>$name,
												'from'=>$from,
												'to'=>$to,
												'subject'=>$subject,
												'message'=>$msg
											  );
											  
							  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
						  }
					  }
					  
					  /*======================================*/
					  //  Email Sent To Customer  [END]
					  /*======================================*/
					  
					  /*======================================*/
					  //  Email Sent To Admin  [START]
					  /*======================================*/
					  $adminemail= new Adminemail;
					  $sqlAdminEmailResult=$adminemail->getByAttributesQuery($formData);
					  
					  if($sqlAdminEmailResult['recordCount'] > 0){
						  $adminsubject = $sqlAdminEmailResult['data'][0]->adminsubject;
						  $adminemailcontent = $sqlAdminEmailResult['data'][0]->adminemail;
						  $adminemailcontent = str_replace('{var_email}',Session::get('admin_email'),$adminemailcontent);
						  $projectLink='<a href="'.url("/").'/event/'.$url_title.'"  target="_blank">Click Here!</a>';
						  $adminemailcontent = str_replace('{var_projectLink}',$projectLink,$adminemailcontent);
						  
						  $mailDescription='';
						  $mailDescription.='<html xmlns="http://www.w3.org/1999/xhtml">
										  <head>
										  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										  <title>Fondae</title>
										  </head>
										  <body style="margin:0px; padding:0px;">
										   <table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style=" background:#FFF;">
													  <td style="text-align:left;padding-bottom: 30px;">
														  <a href="'.url('/').'"><img src="'.url('/').'/frontend/images/Charity-logo_03.png" alt="Fondae" title="Fondae" width="50%"></a>
													  </td>
													  <td style=" padding:12px 0px 30px;text-align:right;margin:5px 0px;">
														  <a href="'.url('/').'/" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Home</a>
														  <a href="'.url('/').'/explore" target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">Explore</a>
														  <a href="'.url('/').'/about"  target="_blank" style="font-family: arial;text-decoration:none;font-size:14px; padding:15px 0px 15px 15px;font-weight: 500;color:#242c42;">How It Works</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style="font-family:arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Login</a>
														  <a href="'.url('/').'/login-registration" target="_blank" style=" font-family: arial;text-decoration:none;font-size:14px; padding:15px;font-weight: 500;color:#242c42;">Signup</a>
													  </td>
												  </tr>
												 </tbody>
										   </table>';
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto;" cellpadding="0" cellspacing="0"><tbody><tr style=" background:#FFF;"><td style="text-align:left;padding-bottom: 30px;">'.$adminemailcontent.'</td></tr></tbody></table>'; 
							  $mailDescription.=	'<table style="width:800px; text-align:center; margin:auto; padding-top:20px;" cellpadding="0" cellspacing="0">
											  <tbody>
												  <tr style="background:#2F374C; width:100%;">
													  <td style="padding:15px 0px 15px; text-align:center;" colspan="3">
														  <p style=" color:#e8ae00; font-family:arial;font-size:14px;font-weight:600;">Copyright By :<a href="##" target="_blank" title="HR Infocare" style="color:#e8ae00; font-weight:600; text-decoration:none; font-size:12px;">  Fondae.com</a></p>
													  </td>
												  </tr>
											  </tbody>
										  </table>
										  </body>
										  </html>';
							 $adminemailcontent = $mailDescription;
							
						  $emailsettingData=array('formID'=>\Config::get('config.eventFormID',3),'emailType'=>1,'isActive'=>1);
						  
						  $emailsetting= new Emailsetting;
						  $sqlmail=$emailsetting->getByAttributesQuery($emailsettingData);
					  
						  foreach($sqlmail['data'] as $adminemail) {
								  $adminTo= $adminemail->email;
								  $from=\Config::get('config.fromEmail');
								  $name=\Config::get('config.fromEmailName');
								  
								  $to=$adminTo;
								  
								  if(\Config::get('config.sendEmail')==1){
									  
									  $emailData=array(
														'name'=>$name,
														'from'=>$from,
														'to'=>$to,
														'subject'=>$adminsubject,
														'message'=>$adminemailcontent
													  );
									  Custom::sendEmail($emailData);  // sendEmail Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
							  
								 }
						  }
					  }
					
					
					  /*======================================*/
					  //  Email Sent To Admin  [END]
					  /*======================================*/	
					
				//}	
		
		
							
		$_POST['productID'] = $productID;
		$_POST['message'] = 'Information saved!';
		$_POST['messageClass'] = 'alert-success';
		$path = url('/')."/adminarea/product/addeditproduct#meta_tab";
		
		return Redirect::fun_redirect($path)->withInput()->with(array('flash_message' => 'Product Price successfully added'));
	}
	function singledelete(Request $request)
	{
		$priceID =$request->priceID;
		Product_price::destroy($priceID);
	}
	function singlestatus(Request $request)
	{

		$priceID =$request->priceID;
		$product_price=Product_price::find($priceID);
		$isActive = $product_price->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Product_price::where('priceID', $priceID)
                				->update($data);
		echo $isActive;
	}
}
