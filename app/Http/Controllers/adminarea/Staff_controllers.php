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
use App\Http\Models\Staff;
//use App\Http\Models\Staffcategory;
//use App\Http\Models\Category_model;
//use App\Http\Models\Categorytype;


class Staff_controllers extends Controller
{
	public function index(Request $request)
	{
		$staff= new Staff;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $staffID)
				{
					$query = Staff::where('staffID', $staffID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $staffID)
				{
					Staff::destroy($staffID);
				}
			}
		}
		
		$result=$staff ->getAllStaff();
		$data['recordcount']=$result['rows'];
		$data['qGetAllStaff']=$result['data'];
		return view('adminarea.staff.staff',$data);
		
	}
	
	public function addeditstaff(Request $request)
	{	
		//Get Single Staff
		$staffID =$request->staffID;
		$data['getsinglestaff'] = Staff::find($staffID);

		//$CheckedCategory = Staffcategory::where('staffID', $staffID)->get();
		//$data['qGetCheckedCategory']=$CheckedCategory;
		
		//$Category= new Category_model;
//		$info = array('categorytypeID'=>10,'isActive'=>1);
//		$result = Category_model::where($info)->get();
//		$data['qGetAllCategory']=$result;

		return view('adminarea.staff.staff-addedit',$data);
	}

	public function savestaff(Request $request)
	{	
	
		$this->validate($request,array(
										   //'categoryID'=>'required',
										   'firstname'=>'required',
										   'lastname'=>'required',
										   'position'=>'required',
										   'email'=>'required|email',
										   'telephone'=>'required|numeric',
										   'alt_telephone'=>'numeric',
										   'bio'=>'required'));
		if ($request->staffID== NULL || $request->staffID == 0) 
		{
			if (empty($_FILES['imgFileName_staff']['name']))
			{
				$this->validate($request,array('imgFileName_staff'=>'required'));
			}
		}
		//$cat_id=$request->categoryID;
		//$categoryID=implode(",",$cat_id);

		$image = $request->file('imgFileName_staff');
		
		if($image){
			
			//$input['imagename'] = $request->imagesName;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/staff');
			$img = Image::make($image->getRealPath());
			
			//Start Resize image creat
			$img->resize(170, 170, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/th_'.$input['imagename']);
			
			$img->resize(180, 180, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/mi_'.$input['imagename']);
			//End Resize image creat
			
			$image->move($destinationPath, $input['imagename']);
			$staff_img=$input['imagename'];
			
		}else{
			$staff_img=$request->imgFileName_staff_old;
		}
		
		$isActive=$request->isActive?$request->isActive:'0';
		if ($request->facebook!="" && strpos($request->facebook,'http://') === false && strpos($request->facebook,'https://') === false){$request->facebook = 'http://'.$request->facebook;}
		if ($request->google!="" && strpos($request->google,'http://') === false && strpos($request->facebook,'https://') === false){$request->google = 'http://'.$request->google;}
		if ($request->twitter!="" && strpos($request->twitter,'http://') === false && strpos($request->facebook,'https://') === false){$request->twitter = 'http://'.$request->twitter;}

		$record = array(
						'firstname'=>ucwords(trim($request->firstname)),
						'lastname'=>ucwords(trim($request->lastname)),
						'position'=>$request->position,
						'email'=>trim($request->email),
						'telephone'=>$request->telephone,
						'telephone_type'=>intval($request->telephone_type),
						'alt_telephone_type'=>$request->alt_telephone_type,
						'alt_telephone'=>$request->alt_telephone,
						'bio'=>$request->bio,
						'facebook'=>$request->facebook,
						'google'=>$request->google,
						'twitter'=>$request->twitter,
						'displayOrder'=>intval($request->displayOrder),
						'imgFileName_staff'=>$staff_img,
						'isActive'=>$request->isActive,
						'firstname_public'=>$request->firstname_public,
						'lastname_public'=>$request->lastname_public,
						'position_public'=>$request->position_public,
						'email_public'=>$request->email_public,
						'telephone_public'=>$request->telephone_public,
						'alt_telephone_public'=>$request->alt_telephone_public,
						'bio_public'=>$request->bio_public,
						'image_public'=>$request->image_public,
						'alttag'=>$request->alttag,
						'createdby'=>Session::get('admin_user'),
						'isActive'=>$isActive
						);


		if ($request->staffID!= NULL && $request->staffID > 0) 
		{
			$staff= new Staff;
			$staffID=$request->staffID;
			$query = $staff->where('staffID', $staffID)
                				->update($record);
			
			////Category Code Start
//			Staffcategory::where('staffID', '=', $staffID)->delete();
//
//			$categoryID=$request->categoryID;
//			
//			for($i=0;$i<count($categoryID);$i++)
//			{
//				$info = array('staffID'=>$staffID,'categoryID'=>$categoryID[$i]);
//				$staffcategory= new Staffcategory($info);
//				$staffcategory->save();
//				
//			}
//			//Category Code End
		}
		else
		{
			$url_title=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $request->firstname.'-'.$request->lastname));
			$checkUrltitle=count(Staff::where('url_title', $url_title)->get());

			$staff= new Staff($record);
			$staff->save();
			$staffID = $staff->staffID;

			if($checkUrltitle>0){$url_title=$url_title.'-'.$staffID;}
			$recordUrltitle=array('url_title'=>$url_title);
			$query = $staff->where('staffID', $staffID)
                				->update($recordUrltitle);

			////Category Code Start
//			$categoryID=$request->categoryID;
//			for($i=0;$i<count($categoryID);$i++)
//			{
//				$info1 = array("staffID"=>$staffID,	
//							   "categoryID"=>$categoryID[$i]);
//				$faqcategory= new Staffcategory($info1);
//				$faqcategory->save();
//			}
//			//Category Code End
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Staff successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$staffID =$request->staffID;
		Staff::destroy($staffID);
	}
	
	public function singlestatus(Request $request)
	{
		$staffID =$request->staffID;
		$staff=Staff::find($staffID);
		$isActive = $staff->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Staff::where('staffID', $staffID)
                				->update($data);
		echo $isActive;
	}
	
	public function imagedelete(Request $request)
	{
		$staffID =$request->staffID;
		$imagename = $request->imagename;
		
		$staffImage = array('imgFileName_staff'=>'');
		$query = Staff::where('staffID', $staffID)
									->update($staffImage);
				
		unlink(public_path('upload/staff/'.$imagename));
		unlink(public_path('upload/staff/th_'.$imagename));
		unlink(public_path('upload/staff/mi_'.$imagename));
	}
	
	public function stafforder(Request $request)
	{
		$result = Staff::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllStaff']=$result;
		return view('adminarea.staff.stafforder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Staff::where('staffID', $item[$i])
									->update($data);
		}
	}

	//public function staffcategory(Request $request)
//	{
//		$data['categorytypeID']=10;
//		$data['categorytypePath']="adminarea/staff/staffcategory";
//		$data['addcategorytypePath']="adminarea/staff/addeditstaffcategory";
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
//	public function addeditstaffcategory(Request $request)
//	{	
//		$categoryID=$request->categoryID;
//		$data['categorytypeID']=10;
//		$data['categorytypePath']="adminarea/staff/staffcategory";
//		$data['addcategorytypePath']="adminarea/staff/addeditstaffcategory";
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
}
