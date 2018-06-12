<?php  // \Config::get('config.productCategorytypeID','3') = Product Module
	   // \Config::get('config.packageCategorytypeID','12') = Package Module

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
use Illuminate\Support\Facades\Custom;

//Load Models
use App\Http\Models\Product;
use App\Http\Models\Product_category;
use App\Http\Models\Product_price;
use App\Http\Models\Product_size;
use App\Http\Models\Product_item;
use App\Http\Models\Category_model;
use App\Http\Models\Categorytype;
use App\Http\Models\Staff;
use App\Http\Models\Product_staff;
use App\Http\Models\Orders;
use App\Http\Models\Customer_address;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;

class Product_controllers extends Controller
{
	public function index(Request $request)
	{
		
		$product= new Product;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $productID)
				{
					$product=Product::find($productID);
					$isActive = $product->isActive;
					$productExpiredDate= $product->productExpiredDate;
					if($isActive == 1)
					{
						$productExpiredDate=date('Y-m-d H:i:s',strtotime($productExpiredDate));
					}
					else
					{
						$productExpiredDate=date('Y-m-d H:i:s');
					}
					
				        $data = array('isActive'=>$isActive,'productExpiredDate'=>$productExpiredDate);
					$query = Product::where('productID', $productID)
			                				->update($data);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $productID)
				{
					Product::destroy($productID);
				}
			}
		}
		$result=$product ->getAllProduct(\Config::get('config.productCategorytypeID','3'));
		$data['recordcount']=$result['rows'];
		$data['qGetAllProduct']=$result['data'];
		$data['CategorytypeID']=\Config::get('config.productCategorytypeID','3');
		return view('adminarea.product.product',$data);
		
		
	}
	
	public function package(Request $request)
	{
		
		$product= new Product;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $productID)
				{
					$query = Product::where('productID', $productID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $productID)
				{
					Product::destroy($productID);
				}
			}
		}
		$result=$product ->getAllProduct(\Config::get('config.packageCategorytypeID','12'));
		$data['recordcount']=$result['rows'];
		$data['qGetAllProduct']=$result['data'];
		$data['CategorytypeID']=\Config::get('config.packageCategorytypeID','12');
		//dd($data['qGetAllProduct']);
		return view('adminarea.product.product',$data);
		
		
	}

	public function addeditproduct(Request $request)
	{	
		
		$productID=$request->productID;
		$CategorytypeID=$request->CategorytypeID?$request->CategorytypeID:3;
		$data['CategorytypeID'] = $CategorytypeID;
		
		//Get Single Product
		$data['getsingleproduct'] = Product::find($productID);
		
		//Get All Product Caregory
		$CheckedCategory = Product_category::where('productID', $productID)->get(); //Get Checked Product Category->first()
		$data['qGetCheckedCategory']=$CheckedCategory;
		$data['checkedCategoryRecordCount'] = count($CheckedCategory);
		
		$Category= new Category_model;
		//$info = array('categorytypeID'=>\Config::get('config.productCategorytypeID','3'),'isActive'=>1);
		$info = array('categorytypeID'=>$CategorytypeID,'isActive'=>1);
		$result = Category_model::where($info)->get();
		$data['qGetAllCategory']=$result;

		//Get All Product Staff
		$CheckedStaff = Product_staff::where('productID', $productID)->get(); //Get Checked Product Category->first()
		$data['qGetCheckedStaff']=$CheckedStaff;
		$data['checkedStaffRecordCount'] = count($CheckedStaff);
		
		$Staff= new Staff;
		$result = Staff::where('isActive',1)->get();
		$data['qGetAllStaff']=$result;
		$data['staffRecordCount']=$result;

		// For Product Size.
		$qGetProductSizeData = Product_size::where('productID', $productID)->get();
		$data['qGetProductSizeData'] = $qGetProductSizeData;
		$data['prodcutSizeRecordCount'] = count($qGetProductSizeData);

		// For Product Iteam.
		$product_item= new Product_item;
		$prductItemData = array('productID'=>$productID);
		$qGetProductIteamData=$product_item->getByAttributesQuery($prductItemData);
		$data['qGetProductIteamData'] = $qGetProductIteamData['data'];
		$data['prodcutIteamRecordCount'] = $qGetProductIteamData['recordCount'];
		
		// For Product Order.
		$Orders= new Orders;
		$prductItemData = array('productID'=>$productID,'eventType'=>1);
		$qGetProductOrderData=$Orders->getByAttributesQuery($prductItemData);
		$data['qGetProductOrderData'] = $qGetProductOrderData['data'];
		$data['prodcutOrderRecordCount'] = $qGetProductOrderData['recordCount'];
		
		// For Product Order.
		$Orders= new Orders;
		$rewardData = array('productID'=>$productID,'eventType'=>2);
		$qGetProductRewardData=$Orders->getByAttributesQuery($rewardData);
		$data['qGetProductRewardData'] = $qGetProductRewardData['data'];
		$data['prodcutRewardRecordCount'] = $qGetProductRewardData['recordCount'];

		//For Price category
		$category= new Category_model;
		$categoryData = array('categorytypeID'=>\Config::get('config.productPriceCategorytypeID','9'),'isActive'=>1);
		//$qGetPriceCategory=$category->getByAttributesQuery($categoryData);
		$qGetPriceCategory['data']=$category->where($categoryData)->get();
		$qGetPriceCategory['recordCount']=count($qGetPriceCategory['data']);
		$data['qGetPriceCategory']=$qGetPriceCategory['data'];
		$data['priceCategoryRecordCount']=$qGetPriceCategory['recordCount'];

		// For Product Price.
		$product_price= new Product_price;
		//$prductPriceData = array('productID'=>$productID,'categorytypeID'=>\Config::get('config.productPriceCategorytypeID','9'),'orderBy'=>'product_price.priceID','order'=>'DESC');
		$prductPriceData = array('productID'=>$productID,'orderBy'=>'product_price.priceID','order'=>'DESC');
		$qGetProductPriceData= $product_price->getByAttributesQuery($prductPriceData);
		$data['qGetProductPriceData'] = $qGetProductPriceData['data'];
		$data['prodcutPriceRecordCount'] = $qGetProductPriceData['recordCount'];;

		return view('adminarea.product.product-addedit',$data);
	}

	public function saveproduct(Request $request)
	{	
		if ($request->productID!= NULL && $request->productID > 0) 
		{
			$this->validate($request,array('productName'=>'required',
											//'itemnumber'=>'required',
											//'availabilityStatus'=>'required',
											//'displayOrder'=>'required',
											'city'=>'required',
											'productDate'=>'required|date',
											//'productExpiredDate'=>'required|date',
											'prodcutImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048')
									);
		}else{
			$this->validate($request,array('productName'=>'required|unique:product,productName',
											//'itemnumber'=>'required',
											//'availabilityStatus'=>'required',
											//'displayOrder'=>'required',
											'city'=>'required',
											'productDate'=>'required|date',
											//'productExpiredDate'=>'required|date',
											'prodcutImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048')
									); 
			//|after:today
		}
		
		
		$image = $request->file('prodcutImage');
		if($image){
			//$this->validate($request,array('prodcutImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
			//$input['imagename'] = $request->productImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/product/mainimages');
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
			$prodcutImage=$input['imagename'];
			
		}else{
			$prodcutImage=$request->prodcutImage_old;
		}
			
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$isFeature=$request->isFeature?$request->isFeature:'0';
		if($request->isBack==1){
			$isDraft=1;
		}else{
			$isDraft=0;
		}
		
		if($isActive==1){$productExpiredDate=date('Y-m-d H:i:s');}else{$productExpiredDate='';}
		$record = array(
						'productName'=>ucwords(trim($request->productName)),
						//'availabilityStatus'=>$request->availabilityStatus,
						'prodcutImage'=>$prodcutImage,
						'city'=>$request->city,
						'price'=>$request->price,
						'altimage'=>trim($request->altimage),
						'shortDescription'=>trim($request->shortDescription),
						'longDescription'=>trim($request->longDescription),
						'producttype'=>$request->producttype,
						'keywordDescription'=>trim($request->keywordDescription),
						//'itemnumber'=>trim($request->itemnumber),
						'productDate'=>date('Y-m-d H:i:s',strtotime($request->productDate)),
						'productExpiredDate'=>$productExpiredDate,
						//'productStartTime'=>trim($request->productStartTime),
						//'productEndTime'=>trim($request->productEndTime),
						'isActive'=>$isActive,
						'isDraft'=>$isDraft,
						'isFeatured'=>$request->isFeatured,
						'displayOrder'=>$request->displayOrder,
						'pageTitle'=>trim($request->pageTitle),
						'metaKeyword'=>trim($request->metaKeyword),
						'metaDescription'=>trim($request->metaDescription),
						'createdby'=>Session::get('admin_user')
						);
		
		;

		if ($request->productID!= NULL && $request->productID > 0) 
		{
			$product= new Product;
			$productID=$request->productID;
			$query = $product->where('productID', $productID)
                				->update($record);
			
		}
		else
		{
			$url_title=preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($request->productName));
			$checkUrltitle=count(Product::where('url_title',$url_title)->get());

			//dd($record);

			$product= new Product($record);
			$product->save();
			$productID = $product->productID;
			
			if($checkUrltitle>0){$url_title=$url_title.'-'.$productID;}
			$recordUrltitle=array('url_title'=>$url_title);
			$query = $product->where('productID', $productID)
                				->update($recordUrltitle);
						
				
				
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

		}

			
		//Product Category Only This Project[Start]
		Product_category::where('productID', '=', $productID)->delete();
		$categoryID=$request->categoryID;
	
		$productCategoryData = array(
					"productID"=>$productID,
					"categoryID"=>$categoryID
				  );
		$product_category= new Product_category($productCategoryData);
		$product_category->save();
		//Product Category Only This Project[End]

		//if($request->isBack==1){
		//	$_POST['productID'] = $productID;
		//	$_POST['message'] = 'Information saved!';
		//	$_POST['messageClass'] = 'alert-success';
		//	$path = url('/')."/adminarea/product/addeditproduct";
		//}else{
			//$path = Input::get('redirects_to');
		//}

			$_POST['productID'] = $productID;
			$_POST['message'] = 'Information saved!';
			$_POST['messageClass'] = 'alert-success';
			$path = url('/')."/adminarea/product/addeditproduct#size_tab";
		
		return Redirect::fun_redirect($path)->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
	}

	public function saveproductcategory(Request $request)
	{	
	
		$this->validate($request,array('categoryname'=>'required'));
		$productcategoryID = $request->productcategoryID?$request->productcategoryID:0;
		$productID = $request->productID?$request->productID:0;

		Product_category::where('productID', '=', $productID)->delete();

		$categoryID=count($_POST['categoryname']);
		for($i=0;$i<$categoryID;$i++)
		{
			$productCategoryData = array(
						"productcategoryID"=>$productcategoryID,
						"productID"=>$productID,
						"categoryID"=>$_POST['categoryname'][$i]
					  );
			$product_category= new Product_category($productCategoryData);
			$product_category->save();
		}

		if($request->backtocategory==1){
			$_POST['productID'] = $productID;
			$_POST['message'] = 'Information saved!';
			$_POST['messageClass'] = 'alert-success';
			$path = url('/')."/adminarea/product/addeditproduct";
		}else{
			$path = Input::get('redirects_to');
		}

		return Redirect::fun_redirect($path)->withInput()->with(array('flash_message' => 'Product Category successfully added'));	
	}
	
	public function saveMetaKeyword(Request $request)
	{
		$this->validate($request,array('pageTitle'=>'required'));
		$record = array(
						'pageTitle'=>$request->pageTitle,
						'metaDescription'=>$request->metaDescription,
						'metaKeyword'=>$request->metaKeyword,
						'keywordDescription'=>$request->keywordDescription,
						);
		if ($request->productID!= NULL && $request->productID > 0) 
		{
			$product= new Product;
			$productID=$request->productID;
			$query = $product->where('productID', $productID)
                				->update($record);
			
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Product successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->productID;
		Product::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$productID =$request->productID;
		$product=Product::find($productID);
		$isActive = $product->isActive;
		$productExpiredDate= $product->productExpiredDate;
		if($isActive == 1)
		{
			$isActive=0;
			$productExpiredDate=date('Y-m-d H:i:s',strtotime($productExpiredDate));
		}
		else
		{
			$productExpiredDate=date('Y-m-d H:i:s');
			$isActive=1;
		}
		$data = array('isActive'=>$isActive,'productExpiredDate'=>$productExpiredDate);
		$query = Product::where('productID', $productID)
                				->update($data);
		echo $isActive;
	}
	
	public function productcategory(Request $request)
	{
		$data['categorytypeID']=\Config::get('config.productCategorytypeID','3');
		$data['categorytypePath']="adminarea/product/productcategory";
		$data['addcategorytypePath']="adminarea/product/addeditproductcategory";
		$category= new Category_model;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $categoryID)
				{
					$query = Category_model::where('categoryID', $categoryID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $categoryID)
				{
					Category_model::destroy($categoryID);
				}
			}
		}
		$data['categoryTypes'] = Categorytype::find($data['categorytypeID']);
		$result=$category ->getAllCategory($data['categorytypeID']);
		$data['recordcount']=$result['rows'];
		$data['qGetAllCategory']=$result['data'];
		return view('adminarea.category.category',$data);
		
	}
	
	public function addeditproductcategory(Request $request)
	{	
		$categoryID=$request->categoryID?$request->categoryID:0;
		$data['categoryID']=$categoryID;
		$data['categorytypeID']=\Config::get('config.productCategorytypeID','3');
		$data['categorytypePath']="adminarea/product/productcategory";
		$data['addcategorytypePath']="adminarea/product/addeditproductcategory";
		$data['getsingleCategory'] = Category_model::find($categoryID);
		
		$info = array('categorytypeID'=>$data['categorytypeID'],'parentCategoryID'=>0);
		$result['data'] = Category_model::where($info)->get();
		$result['rows']=count($result['data']);
		$data['getMainCategory']=$result;
		
		$data['getMainCategoryType'] = Categorytype::find($data['categorytypeID']);
		
		return view('adminarea.category.category-addedit',$data);
	}
	
	public function imagedelete(Request $request)
	{
		$productID =$request->productID;
		$imagename = $request->imagename;
		
		$productImage = array('imgFileName_product'=>'');
		$query = Product::where('productID', $productID)
									->update($productImage);
				
		@unlink(public_path('upload/product/'.$imagename));
		@unlink(public_path('upload/product/th_'.$imagename));
		@unlink(public_path('upload/product/mi_'.$imagename));
	}

	public function productorder(Request $request)
	{
		$result = Product::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllProduct']=$result;
		return view('adminarea.product.productorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Product::where('productID', $item[$i])
									->update($data);
		}
	}
}
