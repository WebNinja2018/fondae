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
use App\Http\Models\User;
use App\Http\Models\Role;

class User_controllers extends Controller
{
	public function index(Request $request)
	{
		$user= new User;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $userID)
				{
					$query = User::where('userID', $userID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $userID)
				{
					User::destroy($userID);
				}
			}
		}
		$result=$user->getAllUser();
		$data['recordcount']=$result['rows'];
		$data['qGetAllUser']=$result['data'];
		return view('adminarea.user.user',$data);
		
	}
	public function addedituser(Request $request)
	{	
		$userID=$request->userID;
		$data['pageno'] = $request->pageno ? $request->pageno:0;
		$data['getsingleUsers'] = User::find($userID);
		
		$role= new Role;
		$result=$role->getAllRole();
		$data['getRole']=$result['data'];
		return view('adminarea.user.user-addedit',$data);
	}

	public function saveuser(Request $request)
	{
		if ($request->userID!= NULL && $request->userID > 0) 
		{
			$this->validate($request,array('firstName'=>'required','lastName'=>'required','roleID'=>'required','email'=>'required|email'));
		}else{
			$this->validate($request,array('firstName'=>'required','lastName'=>'required','roleID'=>'required','email'=>'required|email|unique:user,email'));
		}
		
		$oldPassword=$request->old_password;
		$passwordKey = $request->password;
		if(strlen($passwordKey)>0)
		{
			$key = md5($passwordKey);
		}
		else
		{
			$key=$oldPassword;
		}
		
		$record = array(
						'roleID'=>$request->roleID,
						'firstName'=>ucwords(trim($request->firstName)),
						'lastName'=>ucwords(trim($request->lastName)),
						'email'=>trim($request->email),
						'isActive'=>$request->isActive,
						'password'=>$key
						);

		if ($request->userID!= NULL && $request->userID > 0) 
		{
			$user= new User;
			$userID=$request->userID;
			$query = $user->where('userID', $userID)
                				->update($record);
		}
		else
		{
			$user= new User($record);
			$user->save();
			$userID = $user->userID;
		}
		
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'User successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->userID;
		User::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$userID =$request->userID;
		$user=User::find($userID);
		$isActive = $user->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = User::where('userID', $userID)
                				->update($data);
		echo $isActive;
	}
}
