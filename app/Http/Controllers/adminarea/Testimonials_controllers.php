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
use App\Http\Models\Testimonials;

class Testimonials_controllers extends Controller
{
	public function index(Request $request)
	{
		$testimonials= new Testimonials;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $testimonialsID)
				{
					$query = Testimonials::where('testimonialsID', $testimonialsID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $testimonialsID)
				{
					Testimonials::destroy($testimonialsID);
				}
			}
		}
		
		$result=$testimonials ->getAllTestimonials();
		$data['recordcount']=$result['rows'];
		$data['qGetAllTestimonials']=$result['data'];
		return view('adminarea.testimonials.testimonials',$data);
		
	}
	
	public function addedittestimonials(Request $request)
	{	
		
		//Get Single Testimonials
		$testimonialsID=$request->testimonialsID;
		$data['getsingletestimonials'] = Testimonials::find($testimonialsID);
		return view('adminarea.testimonials.testimonials-addedit',$data);
	}

	public function savetestimonials(Request $request)
	{	
	
		if($request->testimonialsID !='' && $request->testimonialsID >0)
		{
			$this->validate($request,array('clientName'=>'required','displayOrder'=>'required|numeric','testimonial_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}
		else
		{
			$this->validate($request,array('clientName'=>'required|unique:testimonials,clientName','displayOrder'=>'required|numeric','testimonial_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'));

		}
		
		$image = $request->file('testimonial_img');
		
		if($image){
			
			//$input['imagename'] = $request->testimonialsImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/testimonials');
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
			$testimonial_img=$input['imagename'];
			
		}else{
			$testimonial_img=$request->testimonial_img_old;
		}
		
				
		$isActive=$request->isActive;
		$featured=$request->featured;
		
		$record = array(
						'clientName'=>ucwords(trim($request->clientName)),
						'designation'=>ucwords(trim($request->designation)),
						'details'=>$request->details,
						'testimonial_img'=>$testimonial_img,
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'featured'=>$featured,
						'createdby'=>Session::get('admin_user')
						);
		
		if ($request->testimonialsID!= NULL && $request->testimonialsID > 0) 
		{
			$testimonials= new Testimonials;
			$testimonialsID=$request->testimonialsID;
			$query = $testimonials->where('testimonialsID', $testimonialsID)
                				->update($record);
			
		}
		else
		{
			$testimonials= new Testimonials($record);
			$testimonials->save();
			$testimonialsID = $testimonials->testimonialsID;
			
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Testimonials successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->testimonialsID;
		Testimonials::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$testimonialsID =$request->testimonialsID;
		$testimonials=Testimonials::find($testimonialsID);
		$isActive = $testimonials->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Testimonials::where('testimonialsID', $testimonialsID)
                				->update($data);
		echo $isActive;
	}
	
	public function imagedelete(Request $request)
	{
		$testimonialsID =$request->testimonialsID;
		$imagename = $request->imagename;
		
		$testimonialsImage = array('testimonial_img'=>'');
		$query = Testimonials::where('testimonialsID', $testimonialsID)
									->update($testimonialsImage);
				
		unlink(public_path('upload/testimonials/'.$imagename));
		unlink(public_path('upload/testimonials/th_'.$imagename));
		unlink(public_path('upload/testimonials/mi_'.$imagename));
	}
	public function testimonialsorder(Request $request)
	{
		$result = Testimonials::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllTestimonials']=$result;
		return view('adminarea.testimonials.testimonialsorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Testimonials::where('testimonialsID', $item[$i])
									->update($data);
		}
	}
}
