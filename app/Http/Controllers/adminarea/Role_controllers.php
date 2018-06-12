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
use App\Http\Models\Adminmenu;
use App\Http\Models\Role;
use App\Http\Models\Menurole;

class Role_controllers extends Controller
{
	public function index(Request $request)
	{
		if(session()->get('admin_role')!='1'){
			return Redirect::fun_redirect(url('/adminarea/home'))->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
		}
		$role= new Role;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $roleID)
				{
					$query = Role::where('roleID', $roleID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $roleID)
				{
					Role::destroy($roleID);
				}
			}
		}
		
		$result=$role ->getAllRole();
		$data['recordcount']=$result['rows'];
		$data['qGetAllRole']=$result['data'];
		return view('adminarea.role.role',$data);
		
	}
	
	public function addeditrole(Request $request)
	{	
		$role= new Role;
		$roleID=$request->roleID;
		$data['pageno'] = $request->pageno ? $request->pageno:0;
		$data['getsingleRole'] = Role::find($roleID);
		return view('adminarea.role.role-addedit',$data);
	}

	public function saverole(Request $request)
	{
		$this->validate($request,array('name'=>'required'));
		
		$record = array(
						'name'=>ucwords(trim($request->name)),
						'isActive'=>$request->isActive,
						);

		if ($request->roleID!= NULL && $request->roleID > 0) 
		{
			$role= new Role;
			$roleID=$request->roleID;
			$query = $role->where('roleID', $roleID)
                				->update($record);
		}
		else
		{
			//$record = array_merge($record);
			$role= new Role($record);
			$role->save();
			$roleID = $role->roleID;
		}
		
		// return back()->withInput()->with(array('flash_message' => 'Admin Menu successfully added'));
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Role successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->roleID;
		Role::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$roleID =$request->roleID;
		$role=Role::find($roleID);
		$isActive = $role->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Role::where('roleID', $roleID)
                				->update($data);
		echo $isActive;
	}
	
}
