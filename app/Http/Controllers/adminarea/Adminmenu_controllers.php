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

class Adminmenu_controllers extends Controller
{
	public function index(Request $request)
	{
		if(session()->get('admin_role')!='1'){
			return Redirect::fun_redirect(url('/adminarea/home'))->withInput()->withErrors($validator)->with(array('flash_message' => 'Product successfully added'));
		}
		$adminmenu= new Adminmenu;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $menuID)
				{
					$query = Adminmenu::where('menuID', $menuID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $menuID)
				{
					Adminmenu::destroy($menuID);
				}
			}
		}
		
		$qGetAllParent = $adminmenu->getAllParent(0);
		$data['qGetAllParent']=$qGetAllParent['data'];
		//echo $qGetAllParent['rows'];
		//echo $qGetAllParent['data'][0]->menuName;
		
		$result = $adminmenu->getAllAdminmenu();
		$data['recordcount']=$result['rows'];
		$data['qGetAllAdminmenu']=$result['data'];
		
		
		return view( 'adminarea.adminmenu.adminmenu', compact('data') );
		
	}
	public function getReorder()
	{
		$adminmenu= new Adminmenu;
		$qGetReorder = $adminmenu->funGetReorder();
	}
	
	public function addeditadminmenu(Request $request)
	{	
		$menuID =$request->menuID;
		
		$data['getsingleadminmenu'] = Adminmenu::find($menuID);
		$adminmenu= new Adminmenu;
		$result=$adminmenu->getAllParent(0);
		$data['qGetAllParent']=$result['data'];
		
		$role= new Role;
		$result=$role->getAllRole();
		$data['qGetAllRole']=$result['data'];
		return view( 'adminarea.adminmenu.adminmenu-addedit', compact('data') );
	}

	public function saveadminmenu(Request $request)
	{
		$this->validate($request,array('menuName'=>'required','menuLink'=>'required','displayOrder'=>'required'));
		
		$record = array(
						'menuParentID'=>$request->menuParentID,
						'menuName'=>trim($request->menuName),
						'menuLink'=>trim($request->menuLink),
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$request->isActive,
						'classname'=>trim($request->classname),
						'createdBy'=>Session::get('admin_user')
						);

		if ($request->menuID!= NULL && $request->menuID > 0) 
		{
			$adminmenu= new Adminmenu;
			$menuID=$request->menuID;
			$query = $adminmenu->where('menuID', $menuID)
                				->update($record);
		}
		else
		{
			$record = array_merge($record, array('createdDate'=>date('Y-m-d H:i:s',strtotime('now'))));
			$adminmenu= new Adminmenu($record);
			$adminmenu->save();
			$menuID = $adminmenu->menuID;
		}
		
		$menurole= new Menurole();
		$result=$menurole->where('menuID',$menuID)->delete();
				
		$roleID = $request->roleID;
		for( $i=0 ; $i<count($roleID) ; $i++ )
		{
			$record = array(
						'roleID'=>$roleID[$i],
						'menuID'=>$menuID
						);
			$menurole= new Menurole($record);
			$menurole->save();
		}
		
		 //return back()->withInput()->with(array('flash_message' => 'Admin Menu successfully added', 'menuID' => $menuID));
		 return Redirect::to(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Admin Menu successfully added', 'menuID' => $menuID));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->menuID;
		Adminmenu::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$menuID =$request->menuID;
		$adminmenu=Adminmenu::find($menuID);
		$isActive = $adminmenu->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Adminmenu::where('menuID', $menuID)
                				->update($data);
		echo $isActive;
	}
	
}
