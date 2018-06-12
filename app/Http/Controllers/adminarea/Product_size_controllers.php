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

class Product_size_controllers extends Controller
{
	
	public function addeditproductsize(Request $request)
	{
		$sizeID = $request->sizeID?$request->sizeID:0;
		$productID = $request->productID?$request->productID:0;
		$sizeData = array('sizeID'=>$sizeID,'productID'=>$productID);
		$product_size= new Product_size;
		$qGetSizeData = $product_size->getByAttributesQuery($sizeData);
		$data['sizeID'] = $sizeID;
		$data['productID'] = $productID;
		$data['qGetSizeData'] = $qGetSizeData['data'];
		$data['sizeRecordCount'] = $qGetSizeData['recordCount'];
		return view('adminarea.product.product_size.product_size_addedit',$data);
	}
	
	public function savesize(Request $request)
	{	
		$sizeID = $request->sizeID?$request->sizeID:0;
		$productID = $request->productID?$request->productID:0;
		$sizeName = $request->sizeName?$request->sizeName:'';
		$sizeNumber = $request->sizeNumber?$request->sizeNumber:'';
	
		$this->validate($request,array('sizeName'=>'required',
									   //'sizeNumber'=>'required'
									   ));
		
		$record = array(
						'sizeName'=>$sizeName,
						'sizeNumber'=>$sizeNumber,
						'productID'=>$productID,
						'isActive'=>1,
						'createdBy'=>Session::get('admin_user')
						);

		if ($request->sizeID!= NULL && $request->sizeID > 0) 
		{
			$product_size= new Product_size;
			$query = $product_size->where('sizeID', $sizeID)
                				->update($record);
			
		}
		else
		{
			$product_size= new Product_size($record);
			$product_size->save();
			$sizeID = $product_size->sizeID;

		}
		echo '<script type="text/javascript">window.parent.load_dropdown(1,'.$sizeID.',"'.$sizeName.'");</script>';
		exit;
	
		//return Redirect::fun_redirect($path)->withInput()->with(array('flash_message' => 'Product successfully added'));
	}

	function generalprodcutsize()
	{
//	
//		$productID = $this->input->post('productID')?$this->input->post('productID'):0;
//		$recordsPerPage = $this->input->post('recordsPerPage')?$this->input->post('recordsPerPage'):10;
//		$currentPage = $this->input->post('currentPage')?$this->input->post('currentPage'):1;
//		$productSizeData = array('productID'=>$productID,'recordsPerPage'=>$recordsPerPage,'currentPage'=>$currentPage);
//		$qGetGeneralProductSizeData =$this->product_size_model->getAllData($productSizeData);
//		$config["base_url"] = base_url() . "product_size/generalprodcutsize";
//		$config["total_rows"] = $qGetGeneralProductSizeData['totalRecordCount'];
//		$config["per_page"] = $recordsPerPage;
//		$config["uri_segment"] = 3;
//		$data['qGetGeneralProductSizeData']=$qGetGeneralProductSizeData['data'];
//		$data['generalProductSizeRecordCount']=$qGetGeneralProductSizeData['recordCount'];
//		$this->pagination->initialize($config);
//		$data["links"] = $this->pagination->create_links();
//		$this->load->view('products/product_size/product_genaral_size',$data);
//	
	}
}
