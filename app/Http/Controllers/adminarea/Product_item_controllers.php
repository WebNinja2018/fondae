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

class Product_item_controllers extends Controller
{
	
	public function addeditproductitem(Request $request)
	{
		$itemID = $request->itemID?$request->itemID:0;
		$productID = $request->productID?$request->productID:0;

		$itemData = array('itemID'=>$itemID,'productID'=>$productID);
		$product_item= new Product_item;
		$qGetItemData = $product_item->getByAttributesQuery($itemData);

		$sizeData = array('productID'=>$productID);
		$product_size= new Product_size;
		$qGetSizeData = $product_size->getByAttributesQuery($sizeData);
		$data['itemID'] = $itemID;
		$data['productID'] = $productID;
		$data['qGetItemData'] = $qGetItemData['data'];
		$data['itemRecordCount'] = $qGetItemData['recordCount'];
		$data['qGetSizeData'] = $qGetSizeData['data'];
		$data['sizeRecordCount'] = $qGetSizeData['recordCount'];
		return view('adminarea.product.product_item.addedit_product_item',$data);
	}
	
	public function saveitem(Request $request)
	{	
		$itemID = $request->itemID?$request->itemID:0;
		$productID = $request->productID?$request->productID:0;
		$itemName = $request->itemName?$request->itemName:'';
		$sizeID = $request->sizeID?$request->sizeID:0;
	
		$this->validate($request,array('itemName'=>'required','sizeID'=>'required'));
		
		$record = array(
						'itemName'=>$itemName,
						'sizeID'=>$sizeID,
						'productID'=>$productID
						);

		if ($request->itemID!= NULL && $request->itemID > 0) 
		{
			$product_item= new Product_item;
			$query = $product_item->where('itemID', $itemID)
                				->update($record);
			
		}
		else
		{
			$product_item= new Product_item($record);
			$product_item->save();
			$itemID = $product_item->itemID;

		}
		echo '<script type="text/javascript">window.parent.load_dropdown(2,'.$itemID.',"'.$itemName.'");</script>';
		exit;
	
		//return Redirect::fun_redirect($path)->withInput()->with(array('flash_message' => 'Product successfully added'));
	}

	function getsizeitem(Request $request)
	{
		$productID = $request->productID?$request->productID:0;
		$sizeID = $request->sizeID?$request->sizeID:0;
	
		$itemData = array('sizeID'=>$sizeID,'productID'=>$productID);
		$product_item= new Product_item;
		$qGetItemData = $product_item->getByAttributesQuery($itemData);
		$itemRow = "";
		if($qGetItemData['recordCount'] > 0){
			foreach($qGetItemData['data'] as $resultGetItemData)
			{
				$itemRow.="<option value=".$resultGetItemData->itemID.">".$resultGetItemData->itemName."</option>";
			}
		}else{
			$itemRow.="<option value=''>Please add Item</option>";
		}
		echo $itemRow;
	}	
}
