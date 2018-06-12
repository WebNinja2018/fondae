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
use App\Http\Models\Links;
use App\Http\Models\Linkscategory;
use App\Http\Models\Category_model;
use App\Http\Models\Categorytype;

class Links_controllers extends Controller
{
	public function index(Request $request)
	{
		$links= new Links;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $linksID)
				{
					$query = Links::where('linksID', $linksID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $linksID)
				{
					Links::destroy($linksID);
				}
			}
		}
		
		$result=$links ->getAllLinks();
		$data['recordcount']=$result['rows'];
		$data['qGetAllLinks']=$result['data'];
		return view('adminarea.links.links',$data);
		
	}
	
	public function addeditlinks(Request $request)
	{	
		//Get Checked Link Category
		$linksID=$request->linksID;
		$CheckedCategory = Linkscategory::where('linksID', $linksID)->get();
		$data['qGetCheckedCategory']=$CheckedCategory;
		
		//Get Single Links
		$data['getsinglelinks'] = Links::find($linksID);
		
		//Get All Links Caregory
		$Category= new Category_model;
		$info = array('categorytypeID'=>4,'isActive'=>1);
		$result = Category_model::where($info)->get();
		$data['qGetAllCategory']=$result;
		
		return view('adminarea.links.links-addedit',$data);
	}

	public function savelinks(Request $request)
	{	
	
		if ($request->linksID!= NULL && $request->linksID > 0) 
		{
			$this->validate($request,array('categoryID'=>'required','name'=>'required','displayOrder'=>'required','linksImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}else{
			$this->validate($request,array('categoryID'=>'required','name'=>'required|unique:links,name','displayOrder'=>'required','linksImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}
		
		
		$image = $request->file('linksImage');
		
		if($image){
			
			//$input['imagename'] = $request->linksImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/links');
			$img = Image::make($image->getRealPath());
			
			//Start Resize image creat
			$img->resize(192, 192, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/th_'.$input['imagename']);
			
			$img->resize(384, 386, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/mi_'.$input['imagename']);
			//End Resize image creat
			
			$image->move($destinationPath, $input['imagename']);
			$link_img=$input['imagename'];
			
		}else{
			$link_img=$request->linksImage_old;
		}
		
				
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$isFeature=$request->isFeature?$request->isFeature:'0';
		$record = array(
						'name'=>ucwords(trim($request->name)),
						'description'=>$request->description,
						'altTag'=>trim($request->altTag),
						'weblink'=>$weblink,
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'isFeature'=>$isFeature,
						'linksImage'=>$link_img,
						'createdby'=>Session::get('admin_user')
						);

		if ($request->linksID!= NULL && $request->linksID > 0) 
		{
			$links= new Links;
			$linksID=$request->linksID;
			$query = $links->where('linksID', $linksID)
                				->update($record);
			
			Linkscategory::where('linksID', '=', $linksID)->delete();
				
			$categoryID=$request->categoryID;
			
			for($i=0;$i<count($categoryID);$i++)
			{
				$info = array('linksID'=>$linksID,'categoryID'=>$categoryID[$i]);
				$linkscategory= new Linkscategory($info);
				$linkscategory->save();
			}
		}
		else
		{
			$links= new Links($record);
			$links->save();
			$linksID = $links->linksID;
			
			$categoryID=$request->categoryID;
			for($i=0;$i<count($categoryID);$i++)
			{
				$info1 = array("linksID"=>$linksID,	
							   "categoryID"=>$categoryID[$i]);
				$linkscategory= new Linkscategory($info1);
				$linkscategory->save();
			}
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Links successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->linksID;
		Links::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$linksID =$request->linksID;
		$links=Links::find($linksID);
		$isActive = $links->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Links::where('linksID', $linksID)
                				->update($data);
		echo $isActive;
	}
	
	public function linkscategory(Request $request)
	{
		$data['categorytypeID']=4;
		$data['categorytypePath']="adminarea/links/linkscategory";
		$data['addcategorytypePath']="adminarea/links/addeditlinkscategory";

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
	
	public function addeditlinkscategory(Request $request)
	{	
		$categoryID=$request->categoryID;
		$data['categorytypeID']=4;
		$data['categorytypePath']="adminarea/links/linkscategory";
		$data['addcategorytypePath']="adminarea/links/addeditlinkscategory";
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
		$linksID =$request->linksID;
		$imagename = $request->imagename;
		
		$linksImage = array('linksImage'=>'');
		$query = Links::where('linksID', $linksID)
									->update($linksImage);
				
		unlink(public_path('upload/links/'.$imagename));
		unlink(public_path('upload/links/th_'.$imagename));
		unlink(public_path('upload/links/mi_'.$imagename));
	}

	public function linksorder(Request $request)
	{
		$result = Links::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllLinks']=$result;
		return view('adminarea.links.linksorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Links::where('linksID', $item[$i])
									->update($data);
		}
	}
}
