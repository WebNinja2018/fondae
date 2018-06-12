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
use App\Http\Models\Slideshow;

class Slideshow_controllers extends Controller
{
	public function index(Request $request)
	{
		if(session()->get('admin_role')!='1'){
			return Redirect::fun_redirect(url('/adminarea/home'))->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
		}
		$slideshow= new Slideshow;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $slideshowID)
				{
					$query = Slideshow::where('slideshowID', $slideshowID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $slideshowID)
				{
					Slideshow::destroy($slideshowID);
				}
			}
		}
		
		$result=$slideshow ->getAllSlideshow();
		$data['recordcount']=$result['rows'];
		$data['qGetAllSlideshow']=$result['data'];
		return view('adminarea.slideshow.slideshow',$data);
		
	}
	
	public function addeditslideshow(Request $request)
	{	
		//Get Single Slideshow
		$slideshowID =$request->slideshowID;
		$data['getsingleslideshow'] = Slideshow::find($slideshowID);
		return view('adminarea.slideshow.slideshow-addedit',$data);
	}

	public function saveslideshow(Request $request)
	{	
		if($request->slideshowID !='' && $request->slideshowID >0)
		{
			$this->validate($request,array('slideshowTitle'=>'required','caption1'=>'required','displayOrder'=>'required'));
		}else{
			$this->validate($request,array('slideshowTitle'=>'required','caption1'=>'required','displayOrder'=>'required','imagesName' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}
		
		$image = $request->file('imagesName');
		
		if($image){
			
			//$input['imagename'] = $request->imagesName;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/slideshow');
			$img = Image::make($image->getRealPath());
			
			//Start Resize image creat
			$img->resize(200, 200, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/th_'.$input['imagename']);
			
			$img->resize(479, 1001, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/mi_'.$input['imagename']);
			//End Resize image creat
			
			$image->move($destinationPath, $input['imagename']);
			$slide_img=$input['imagename'];
			
		}else{
			$slide_img=$request->imagesName_old;
		}
		
				
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$record = array(
						'slideshowTitle'=>trim($request->slideshowTitle),
						'caption1'=>trim($request->caption1),
						'caption2'=>trim($request->caption2),
						'imagesName'=>trim($slide_img),
						'weblink'=>trim($weblink),
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'createdby'=>Session::get('admin_user')
						);

		if ($request->slideshowID!= NULL && $request->slideshowID > 0) 
		{
			$slideshow= new Slideshow;
			$slideshowID=$request->slideshowID;
			$query = $slideshow->where('slideshowID', $slideshowID)
                				->update($record);
		}
		else
		{
			$slideshow= new Slideshow($record);
			$slideshow->save();
			$slideshowID = $slideshow->slideshowID;
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Slideshow successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$slideshowID =$request->slideshowID;
		Slideshow::destroy($slideshowID);
	}
	
	public function singlestatus(Request $request)
	{
		$slideshowID =$request->slideshowID;
		$slideshow=Slideshow::find($slideshowID);
		$isActive = $slideshow->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Slideshow::where('slideshowID', $slideshowID)
                				->update($data);
		echo $isActive;
	}
	
	public function imagedelete(Request $request)
	{
		$slideshowID =$request->slideshowID;
		$imagename = $request->imagename;
		
		$slideshowImage = array('imagesName'=>'');
		$query = Slideshow::where('slideshowID', $slideshowID)
									->update($slideshowImage);
				
		unlink(public_path('upload/slideshow/'.$imagename));
		unlink(public_path('upload/slideshow/th_'.$imagename));
		unlink(public_path('upload/slideshow/mi_'.$imagename));
	}
	public function slideshoworder(Request $request)
	{
		$result = Slideshow::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllSlideshow']=$result;
		return view('adminarea.slideshow.slideshoworder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Slideshow::where('slideshowID', $item[$i])
									->update($data);
		}
	}
}
