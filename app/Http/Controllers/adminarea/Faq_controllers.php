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
use Session;
use DB;

//Load Models
use App\Http\Models\Faq;
//use App\Http\Models\Faqcategory;
//use App\Http\Models\Category_model;
//use App\Http\Models\Categorytype;

class Faq_controllers extends Controller
{
	public function index(Request $request)
	{
		$faq= new Faq;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $faqID)
				{
					$query = Faq::where('faqID', $faqID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $faqID)
				{
					Faq::destroy($faqID);
				}
			}
		}
		
		
		$result=$faq ->getAllFaq();
		
		$data['recordcount']=$result['rows'];
		$data['qGetAllFaq']=$result['data'];
		return view('adminarea.faq.faq',$data);
		
	}
	
	public function addeditfaq(Request $request)
	{	
		$faqID=$request->faqID;
		//$CheckedCategory = Faqcategory::where('faqID', $faqID)->get();
		//$data['qGetCheckedCategory']=$CheckedCategory;
		
		$data['getsinglefaq'] = Faq::find($faqID);
		
		//$Category= new Category_model;
		//$info = array('categorytypeID'=>2,'isActive'=>1);
		//$result = Category_model::where($info)->get();
		//$data['qGetAllCategory']=$result;
		
		return view('adminarea.faq.faq-addedit',$data);
	}

	public function savefaq(Request $request)
	{	
	
		if ($request->faqID!= NULL && $request->faqID > 0) 
		{
			$this->validate($request,array('question'=>'required','displayOrder'=>'required'));
		}else{
			$this->validate($request,array('question'=>'required|unique:faq,question','displayOrder'=>'required'));
		}
		
		$record = array(
						'question'=>trim($request->question),
						'answer'=>trim($request->answer),
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$request->isActive,
						'createdby'=>Session::get('admin_user')
						);

		if ($request->faqID!= NULL && $request->faqID > 0) 
		{
			$faq= new Faq;
			$faqID=$request->faqID;
			$query = $faq->where('faqID', $faqID)
                				->update($record);
			
			//Faqcategory::where('faqID', '=', $faqID)->delete();
				
			//$categoryID=$request->categoryID;
//			
//			for($i=0;$i<count($categoryID);$i++)
//			{
//				$info = array('faqID'=>$faqID,'categoryID'=>$categoryID[$i]);
//				$faqcategory= new Faqcategory($info);
//				$faqcategory->save();
//			}
		}
		else
		{
			$site_url=preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower(trim($request->question)));
			$checkUrltitle=count(Faq::where('site_url', $site_url)->get());

			$faq= new Faq($record);
			$faq->save();
			$faqID = $faq->faqID;
			
			if($checkUrltitle>0){$site_url=$site_url.'-'.$faqID;}
			$recordUrltitle=array('site_url'=>$site_url);
			$query = $faq->where('faqID', $faqID)
                				->update($recordUrltitle);

			//$categoryID=$request->categoryID;
//			for($i=0;$i<count($categoryID);$i++)
//			{
//				$info1 = array("faqID"=>$faqID,	
//							   "categoryID"=>$categoryID[$i]);
//				$faqcategory= new Faqcategory($info1);
//				$faqcategory->save();
//			}
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Faq successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->faqID;
		Faq::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$faqID =$request->faqID;
		$faq=Faq::find($faqID);
		$isActive = $faq->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Faq::where('faqID', $faqID)
                				->update($data);
		echo $isActive;
	}
	
	//public function faqcategory(Request $request)
//	{
//		$data['categorytypeID']=2;
//		$data['categorytypePath']="adminarea/faq/faqcategory";
//		$data['addcategorytypePath']="adminarea/faq/addeditfaqcategory";
//		$category= new Category_model;
//		
//		if($request->method== "multiplestatus")
//		{
//			$isActive = array('isActive'=>$request->status);
//			if($request->checkUncheck)
//			{
//				foreach($request->checkUncheck as $categoryID)
//				{
//					$query = Category_model::where('categoryID', $categoryID)
//									->update($isActive);
//				}
//			}
//		}
//		
//		if($request->method== "multipleDelete")
//		{
//			if($request->checkUncheck)
//			{
//				foreach($request->checkUncheck as $categoryID)
//				{
//					Category_model::destroy($categoryID);
//				}
//			}
//		}
//		$data['categoryTypes'] = Categorytype::find($data['categorytypeID']);
//		$result=$category ->getAllCategory($data['categorytypeID']);
//		$data['recordcount']=$result['rows'];
//		$data['qGetAllCategory']=$result['data'];
//		return view('adminarea.category.category',$data);
//		
//	}
//	
//	public function addeditfaqcategory(Request $request)
//	{	
//		$categoryID=$request->categoryID;
//		$data['categorytypeID']=2;
//		$data['categorytypePath']="adminarea/faq/faqcategory";
//		$data['addcategorytypePath']="adminarea/faq/addeditfaqcategory";
//		$data['getsingleCategory'] = Category_model::find($categoryID);
//		
//		$info = array('categorytypeID'=>$data['categorytypeID'],'parentCategoryID'=>0);
//		$result['data'] = Category_model::where($info)->get();
//		$result['rows']=count($result['data']);
//		$data['getMainCategory']=$result;
//		
//		$data['getMainCategoryType'] = Categorytype::find($data['categorytypeID']);
//		
//		return view('adminarea.category.category-addedit',$data);
//	}
	public function faqorder(Request $request)
	{
		$result = Faq::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllFaq']=$result;
		return view('adminarea.faq.faqorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Faq::where('faqID', $item[$i])
									->update($data);
		}
	}
}
