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
use App\Http\Models\Gallery;

class Gallery_controllers extends Controller
{
	public function index(Request $request)
	{
		$gallery= new Gallery;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $galleryID)
				{
					$query = Gallery::where('galleryID', $galleryID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $galleryID)
				{
					Gallery::destroy($galleryID);
				}
			}
		}
		
		$result=$gallery ->getAllGallery();
		$data['recordcount']=$result['rows'];
		$data['qGetAllGallery']=$result['data'];
		return view('adminarea.gallery.gallery',$data);
		
	}
	
	public function addeditgallery(Request $request)
	{	
		//Get Single Gallery
		$galleryID =$request->galleryID;
		$data['getsinglegallery'] = Gallery::find($galleryID);
		return view('adminarea.gallery.gallery-addedit',$data);
	}

	public function savegallery(Request $request)
	{	
	
		$this->validate($request,array('galleryTitle'=>'required','displayOrder'=>'required','galleryMainImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		
		
		$image = $request->file('galleryMainImage');
		
		if($image){
			
			//$input['imagename'] = $request->imagesName;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/gallery');
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
			$gallery_img=$input['imagename'];
			
		}else{
			$gallery_img=$request->galleryImage_old;
		}
		
				
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$featured=$request->featured?$request->featured:'0';

		

		$record = array(
						'galleryTitle'=>trim($request->galleryTitle),
						'galleryMainImage'=>trim($gallery_img),
						'weblink'=>trim($weblink),
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'featured'=>$featured,
						'createdby'=>Session::get('admin_user')
						);

		if ($request->galleryID!= NULL && $request->galleryID > 0) 
		{
			$gallery= new Gallery;
			$galleryID=$request->galleryID;
			$query = $gallery->where('galleryID', $galleryID)
                				->update($record);
		}
		else
		{
			$url_title=preg_replace('/[^A-Za-z0-9\-]/', '-', $request->galleryTitle);
			$checkUrltitle=count(Gallery::where('url_title', $url_title)->get());

			$gallery= new Gallery($record);
			$gallery->save();
			$galleryID = $gallery->galleryID;

			if($checkUrltitle>0){$url_title=$url_title.'-'.$galleryID;}
			$recordUrltitle=array('url_title'=>$url_title);
			$query = $faq->where('galleryID', $galleryID)
                				->update($recordUrltitle);
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Gallery successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$galleryID =$request->galleryID;
		Gallery::destroy($galleryID);
	}
	
	public function singlestatus(Request $request)
	{
		$galleryID =$request->galleryID;
		$gallery=Gallery::find($galleryID);
		$isActive = $gallery->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Gallery::where('galleryID', $galleryID)
                				->update($data);
		echo $isActive;
	}
	
	public function imagedelete(Request $request)
	{
		$galleryID =$request->galleryID;
		$imagename = $request->imagename;
		
		$galleryImage = array('galleryMainImage'=>'');
		$query = Gallery::where('galleryID', $galleryID)
									->update($galleryImage);
				
		unlink(public_path('upload/gallery/'.$imagename));
		unlink(public_path('upload/gallery/th_'.$imagename));
		unlink(public_path('upload/gallery/mi_'.$imagename));
	}

	public function galleryorder(Request $request)
	{
		$result = Gallery::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllGallery']=$result;
		return view('adminarea.gallery.galleryorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Gallery::where('galleryID', $item[$i])
									->update($data);
		}
	}
}
