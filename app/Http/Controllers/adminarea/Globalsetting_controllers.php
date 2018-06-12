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
use App\Http\Models\Globalsetting;

class Globalsetting_controllers extends Controller
{
	public function index(Request $request)
	{
		$globalsetting= new Globalsetting;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $globalsettingID)
				{
					$query = Globalsetting::where('globalsettingID', $globalsettingID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $globalsettingID)
				{
					Globalsetting::destroy($globalsettingID);
				}
			}
		}
		
		$result=$globalsetting ->getAllGlobalsetting();
		$data['recordcount']=$result['rows'];
		$data['qGetAllGlobalsetting']=$result['data'];
		return view('adminarea.globalsetting.globalsetting',$data);
		
	}
	
	public function addeditglobalsetting(Request $request)
	{	
		//Get Single Globalsetting
		$globalsettingID=$request->globalsettingID;
		$data['getsingleglobalsetting'] = Globalsetting::find($globalsettingID);
		
		return view('adminarea.globalsetting.globalsetting-addedit',$data)->withInput(Input::all());
	}

	public function saveglobalsetting(Request $request)
	{	
	
		if ($request->globalsettingID!= NULL && $request->globalsettingID > 0) 
		{
			$this->validate($request,array('globalsettingname'=>'required'));
		}else{
			$this->validate($request,array('globalsettingname'=>'required|unique:globalsetting,globalsettingname'));
		}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$textTypeID=$request->textTypeID?$request->textTypeID:'1';
		
		if($textTypeID==1)
		{
			$record=array(
				'globalsettingname'=>$request->globalsettingname,
				'globalsettingvalue'=>$request->globalsettingTextvalue,
				'isActive'=>$isActive,
				'textTypeID'=>$textTypeID,
			);
		}
		else
		{
			$record=array(
				'globalsettingname'=>$request->globalsettingname,
				'globalsettingvalue'=>$request->globalsettingTextareavalue,
				'isActive'=>$isActive,
				'textTypeID'=>$textTypeID,
			);
		}

		if ($request->globalsettingID!= NULL && $request->globalsettingID > 0) 
		{
			$globalsetting= new Globalsetting;
			$globalsettingID=$request->globalsettingID;
			$query = $globalsetting->where('globalsettingID', $globalsettingID)
                				->update($record);
			
		}
		else
		{
			$globalsetting= new Globalsetting($record);
			$globalsetting->save();
			$globalsettingID = $globalsetting->globalsettingID;
		}
		return Redirect::to(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Globalsetting successfully added'));
	}
	

	
	public function singledelete(Request $request)
	{
		$menuID =$request->globalsettingID;
		Globalsetting::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$globalsettingID =$request->globalsettingID;
		$globalsetting=Globalsetting::find($globalsettingID);
		$isActive = $globalsetting->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Globalsetting::where('globalsettingID', $globalsettingID)
                				->update($data);
		echo $isActive;
	}
	public function createFile()
	{
		$qresultUser=Globalsetting::all();

		$body_message="";
		$body_message.="<?php \n";
		$body_message.="return [
		
";		
		foreach($qresultUser as $resultUser)
		{
			$body_message.="'".$resultUser->globalsettingname."' => ";
			//$body_message.='"'.$resultUser->globalsettingvalue.'";';
			if (is_numeric($resultUser->globalsettingvalue)) {
				$body_message.="".$resultUser->globalsettingvalue.",";
			}else{
				$body_message.="'".$resultUser->globalsettingvalue."',";
			}
			$body_message.="\n";
		}
		$body_message.="
		 
] ?>";
		
		$config['upload_path'] = public_path('/config/');
		$path = url('/').'/adminarea/globalsetting/index';
		$file_name=$config['upload_path']."config.php";
		//$file_name=$config['upload_path']."global_settings.php";
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
