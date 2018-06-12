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
use View;

//Load Models
use App\Http\Models\Commonmessage;

class Commonmessage_controllers extends Controller
{
	public function index(Request $request)
	{
		$commonmessage= new Commonmessage;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $commonmessageID)
				{
					$query = Commonmessage::where('commonmessageID', $commonmessageID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $commonmessageID)
				{
					Commonmessage::destroy($commonmessageID);
				}
			}
		}
		
		$result=$commonmessage ->getAllCommonmessage();
		$data['recordcount']=$result['rows'];
		$data['qGetAllCommonmessage']=$result['data'];
		return view('adminarea.commonmessage.commonmessage',$data);
		
	}
	
	public function addeditcommonmessage(Request $request)
	{	
		//Get Single Commonmessage
		$commonmessageID=$request->commonmessageID;
		$data['getsinglecommonmessage'] = Commonmessage::find($commonmessageID);
		
		return view('adminarea.commonmessage.commonmessage-addedit',$data)->withInput(Input::all());
	}

	public function savecommonmessage(Request $request)
	{	
	
		if ($request->commonmessageID!= NULL && $request->commonmessageID > 0) 
		{
			$this->validate($request,array('variableName'=>'required'));
		}else{
			$this->validate($request,array('variableName'=>'required|unique:commonmessage,variableName'));
		}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$textTypeID=$request->textTypeID?$request->textTypeID:'1';
		
		if($textTypeID==1)
		{
			$record=array(
				'variableName'=>$request->variableName,
				'description'=>$request->description1,
				'isActive'=>$isActive,
				'textTypeID'=>$textTypeID,
			);
		}
		else
		{
			$record=array(
				'variableName'=>$request->variableName,
				'description'=>$request->description,
				'isActive'=>$isActive,
				'textTypeID'=>$textTypeID,
			);
		}

		if ($request->commonmessageID!= NULL && $request->commonmessageID > 0) 
		{
			$commonmessage= new Commonmessage;
			$commonmessageID=$request->commonmessageID;
			$query = $commonmessage->where('commonmessageID', $commonmessageID)
                				->update($record);
			
		}
		else
		{
			$commonmessage= new Commonmessage($record);
			$commonmessage->save();
			$commonmessageID = $commonmessage->commonmessageID;
		}
		return Redirect::to(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Commonmessage successfully added'));
	}
	

	
	public function singledelete(Request $request)
	{
		$menuID =$request->commonmessageID;
		Commonmessage::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$commonmessageID =$request->commonmessageID;
		$commonmessage=Commonmessage::find($commonmessageID);
		$isActive = $commonmessage->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Commonmessage::where('commonmessageID', $commonmessageID)
                				->update($data);
		echo $isActive;
	}
	public function createFile()
	{
		$qresultUser=Commonmessage::all();

		$body_message="";
		$body_message.="<?php \n";
		$body_message.="return [
		
";
		foreach($qresultUser as $resultUser)
		{
			$body_message.="'".$resultUser->variableName."' => ";
			//$body_message.='"'.$resultUser->description.'";';
			if (is_numeric($resultUser->description)) {
				$body_message.="".$resultUser->description.",";
			}else{
				$body_message.="'".$resultUser->description."',";
			}
			$body_message.="\n";
		}
		$body_message.="
		 
] ?>";
		
		$config['upload_path'] = public_path('/config/');
		$path = url('/').'/adminarea/commonmessage/index';
		$file_name=$config['upload_path']."commonmessage.php";
		if (file_exists($file_name)) {
		  	$file = fopen($file_name,"r");
			$content = fread($file,filesize($file_name));
			$content=str_replace($content,$body_message,$content);
			
			$file = fopen($file_name,"w");
			fwrite($file,$content);
			return Redirect::to($path)->withInput()->with(array('flash_message' => 'File Updated'));
		}
		else{
			$file = fopen($file_name, "w");
			fwrite($file,$body_message);
			return Redirect::to($path)->withInput()->with(array('flash_message' => 'File Created'));
		}
		fclose($file);
				
	//echo $body_message; exit;
	}
}
