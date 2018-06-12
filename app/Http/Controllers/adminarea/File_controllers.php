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
use App\Http\Models\File;
use App\Http\Models\Filetype;

class File_controllers extends Controller
{
	
	function savefile(Request $request)
	{
		$this->validate($request,array('fileName' => 'required|file|mimes:doc,pdf,xls,txt|max:2048'));		
		$fileTypeID=$request->fileTypeID;
		$itemID=$request->itemID;
		$caption=$request->caption?$request->caption:'';
		$displayOrder=$request->displayOrder?$request->displayOrder:'';
		$isActive=$request->isActive?$request->isActive:1;
		$file = $request->file('fileName');
		
		if($file){
			
			//$input['filename'] = $request->fileName;;	
			$input['filename'] = time().'.'.$file->getClientOriginalExtension();
			
			
			if($fileTypeID==2)
			{
				$destinationPath = public_path('/upload/news/file/').$itemID;
			}
			elseif($fileTypeID==3)
			{
				$destinationPath = public_path('/upload/portfolio/file/').$itemID;
			}
			elseif($fileTypeID==5)
			{
				$destinationPath = public_path('/upload/event/file/').$itemID;
			}
			elseif($fileTypeID==6)
			{
				$destinationPath = public_path('/upload/gallery/file/').$itemID;
			}
			elseif($fileTypeID==7)
			{
				$destinationPath = public_path('/upload/services/file/').$itemID;
			}
			else
			{
				$destinationPath = public_path('/upload/product/file/').$itemID.'/';		
			}
			
			if( !file_exists($destinationPath) )
			{
				mkdir($destinationPath);
			}
			$destinationPath = $destinationPath.'/';
			
			$file->move($destinationPath, $input['filename']);
			$filename=$input['filename'];
			
		}
		$record = array(
				'itemID'=>$itemID,
				'fileName'=>trim($filename),
				'caption'=>$caption,
				'displayOrder'=>$displayOrder,
				'fileTypeID'=>$fileTypeID,
				'isActive'=>$isActive,
				'createdBy'=>1
			);
		
		$file= new File($record);
		$file->save();
		echo $fileID = $file->fileID;
		exit;	
	}
	
	public function singledelete(Request $request)
	{
		$fileID=$request->fileID;
		File::destroy($fileID);
	}
	
	public function singlestatus(Request $request)
	{
		$fileID=$request->fileID;
		$file=File::find($fileID);
		$isActive = $file->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = File::where('fileID', $fileID)
                				->update($data);
		echo $isActive;
	}
	public function fileorder(Request $request)
	{
		$fileTypeID=$request->fileTypeID;
		$itemID=$request->itemID;
		$data = array('fileTypeID'=>$fileTypeID,'itemID'=>$itemID);
		$result = File::where($data)->orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllFile']=$result;
		return view('adminarea.file.fileorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = File::where('fileID', $item[$i])
									->update($data);
		}
	}
}
