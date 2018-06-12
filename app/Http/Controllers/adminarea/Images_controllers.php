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
use App\Http\Models\Images;
use App\Http\Models\Imagestype;

class Images_controllers extends Controller
{
	
	function saveimages(Request $request)
	{
		$this->validate($request,array('imagesName' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048'));
		$imagesTypeID=$request->imagesTypeID;
		$itemID=$request->itemID;
		$caption=$request->caption?$request->caption:'';
		$displayOrder=$request->displayOrder?$request->displayOrder:'';
		$isActive=$request->isActive?$request->isActive:1;
		//$image_name = $_FILES['imagesName']['name'];
        $image = $request->file('imagesName');
		
		if($image){
			
			//$input['imagename'] = $request->imagesName;;	
			$input['imagename'] = time().uniqid().'.'.$image->getClientOriginalExtension();
			
			//if($_POST['imagesTypeID']==2)
//			{
//				$destinationPath = public_path('/upload/news/');
//			}
//			elseif($_POST['imagesTypeID']==4)
//			{
//				$destinationPath = public_path('/upload/event/');	
//			}
//			elseif($_POST['imagesTypeID']==6)
//			{
//				$destinationPath = public_path('/upload/gallery/images/');	
//			}
//			else
//			{
//				$destinationPath = public_path('/upload/gallery/images/').$itemID.'/';		
//			}
			
			if($imagesTypeID==2)
			{
				$destinationPath = public_path('/upload/news/images/').$itemID;
			}
			elseif($imagesTypeID==3)
			{
				$destinationPath = public_path('/upload/portfolio/images/').$itemID;
			}
			elseif($imagesTypeID==5)
			{
				$destinationPath = public_path('/upload/event/images/').$itemID;
			}
			elseif($imagesTypeID==6)
			{
				$destinationPath = public_path('/upload/gallery/images/').$itemID;
			}
			elseif($imagesTypeID==7)
			{
				$destinationPath = public_path('/upload/services/images/').$itemID;
			}
			else
			{
				$destinationPath = public_path('/upload/product/images/').$itemID.'/';		
			}
			
			if( !file_exists($destinationPath) )
			{
				mkdir($destinationPath);
			}
			$destinationPath = $destinationPath.'/';
			
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
			$imagename=$input['imagename'];
			
		}
		$record = array(
				'itemID'=>$itemID,
				'imagesName'=>trim($imagename),
				'caption'=>$caption,
				'displayOrder'=>$displayOrder,
				'imagesTypeID'=>$imagesTypeID,
				'isActive'=>$isActive,
				'createdBy'=>1
			);
		
		$images= new Images($record);
		$images->save();
		echo $imagesID = $images->imagesID;

		//if(is_array($result))
//		{
//			echo json_encode($result['error']);
//		}
//		else
//		{
//			echo json_encode($_FILES['imagesName']['name']);
//		}
		exit;	
	}
	
	public function singledelete(Request $request)
	{
		$imagesID=$request->imagesID;
		Images::destroy($imagesID);
	}
	
	public function singlestatus(Request $request)
	{
		$imagesID=$request->imagesID;
		$images=Images::find($imagesID);
		$isActive = $images->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Images::where('imagesID', $imagesID)
                				->update($data);
		echo $isActive;
	}
	public function imagesorder(Request $request)
	{
		$imagesTypeID=$request->imagesTypeID;
		$itemID=$request->itemID;
		$data = array('imagesTypeID'=>$imagesTypeID,'itemID'=>$itemID);
		$result = Images::where($data)->orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllImages']=$result;
		return view('adminarea.images.imagesorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Images::where('imagesID', $item[$i])
									->update($data);
		}
	}
}
