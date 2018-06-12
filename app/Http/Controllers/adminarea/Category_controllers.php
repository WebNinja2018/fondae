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
use App\Http\Models\Category_model;
use App\Http\Models\User;
use App\Http\Models\Role;

class Category_controllers extends Controller
{
	public function index(Request $request)
	{
		if(session()->get('admin_role')!='1'){
			return Redirect::fun_redirect(url('/adminarea/home'))->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
		}
		
		$category= new Category;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $categoryID)
				{
					$query = Category_model::where('categoryID', $CategoryID)
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
		
		$result=$category ->getAllCategory();
		$data['recordcount']=$result['rows'];
		$data['qGetAllCategory']=$result['data'];
		return view('adminarea.category.category',$data);
		
	}
	public function addedituser(Request $request)
	{	
		$categoryID=$request->categoryID;
		$data['pageno'] = $request->pageno ? $request->pageno:0;
		$data['getsingleCategory'] = Category_model::find($categoryID);
		
		return view('adminarea.category.category-addedit',$data);
	}

	public function savecategory(Request $request)
	{
		$data['categorytypeID']=$request->categorytypeID;
		$data['categorytypePath']=$request->categorytypePath;
		$data['addcategorytypePath']=$request->addcategorytypePath;
		
		$this->validate($request,array('categoryname'=>'required','imagename' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		
		
		$categorytypeID=$request->categorytypeID?$request->categorytypeID:'';
		$categoryname=$request->categoryname?$request->categoryname:'';
		//$categorytypeID=$request->categorytypeID?$request->categorytypeID:'';
		$displayOrder=$request->displayOrder?$request->displayOrder:'';
		$isActive=$request->isActive;
		$explore_page=$request->explore_page;
		$isFeatured=$request->isFeatured?$request->isFeatured:'0';
		$pageTitle=$request->pageTitle?$request->pageTitle:'';
		$pageMetaKeyword=$request->pageMetaKeyword?$request->pageMetaKeyword:'';
		$pageDescription=$request->pageDescription?$request->pageDescription:'';
		$content=$request->content?$request->content:'';
		$parentCategoryID = $request->parentCategoryID ? $request->parentCategoryID:0;
		$classname = $request->classname ? $request->classname:0;
		
		$image = $request->file('imagename');
		if($image){
			//$this->validate($request,array('prodcutImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
			//$input['imagename'] = $request->productImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/category');
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
			$imagename=$input['imagename'];
			
		}else{
			$imagename=$request->imageName_old;
		}

		$record = array(
						'categoryname'=>ucwords(trim($categoryname)),
						'parentCategoryID'=>$parentCategoryID,
						'categorytypeID'=>$categorytypeID,
						'displayOrder'=>$displayOrder,
						'isActive'=>$isActive,
						'isFeatured'=>$isFeatured,
						'explore_page'=>$explore_page,
						'pageTitle'=>trim($pageTitle),
						'pageMetaKeyword'=>trim($pageMetaKeyword),
						'pageDescription'=>trim($pageDescription),
						'content'=>$content,
						'imagename'=>trim($imagename),
						'classname'=>trim($classname),
						'createdBy'=>Session::get('admin_user')
						);
		if ($request->categoryID!= NULL && $request->categoryID > 0) 
		{
			$category= new Category_model;
			$categoryID=$request->categoryID;
			$query = $category->where('categoryID', $categoryID)
                				->update($record);
		}
		else
		{
			$urlName=preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower(trim($request->categoryname)));
	    	$checkUrltitle=count(Category_model::where('urlName', $urlName)->get());

			$category= new Category_model($record);
			$category->save();
			$categoryID = $category->categoryID;
			
			if($checkUrltitle>0){$urlName=$urlName.'-'.$categoryID;}
			$recordUrltitle=array('urlName'=>$urlName);
			$query = $category->where('categoryID', $categoryID)
                				->update($recordUrltitle);
		}
		
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Category successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$categoryID =$request->categoryID;
		Category_model::destroy($categoryID);
	}
	
	public function singlestatus(Request $request)
	{
		$categoryID =$request->categoryID;
		$category=Category_model::find($categoryID);
		$isActive = $category->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Category_model::where('categoryID', $categoryID)
                				->update($data);
		echo $isActive;
	}

	public function categoryorder(Request $request)
	{
		$data['categorytypeID']=$request->categorytypeID;
		$data['categorytypePath']=$request->categorytypePath;
		$data['addcategorytypePath']=$request->addcategorytypePath;

		$result = Category_model::orderBy('displayOrder', 'asc')->where('categorytypeID', $request->categorytypeID)->get();
		$data['recordcount']=count($result);
		$data['qGetAllCategory']=$result;
		return view('adminarea.category.categoryorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Category_model::where('categoryID', $item[$i])
									->update($data);
		}
	}

	
}
