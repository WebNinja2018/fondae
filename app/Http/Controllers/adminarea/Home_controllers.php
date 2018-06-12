<?php

namespace App\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;

use App\Http\Models\Users;
use App\Http\Models\Adminmenu;
use App\Http\Models\Frm_contactus;

class Home_controllers extends Controller
{
	public function index(Request $request)
	{
		$adminmenu= new Adminmenu;
		$data['qGetAllParent']= $adminmenu->getAllParent(0);

		$frm_contactus= new Frm_contactus;
		$result=$frm_contactus ->getAllContactus();
		$data['recordcount']=$result['rows'];
		$data['qGetAllContactus']=$result['data'];

		return view('adminarea.dashboard',$data);
	}
	
	public function setSidemenu(Request $request)
	{
		if( Session::get('leftmenuhide')==0 )
		{
			Session::put('leftmenuhide', 1);
		}
		elseif( Session::get('leftmenuhide')==1 )
		{
			Session::put('leftmenuhide', 0);
		}
	}
	
	public function setsearch(Request $request)
	{
		$obj = Input::get('obj') ? Input::get('obj') : '';
		if( Session::get('searchSection'.$obj)==0 )
		{
			Session::put('searchSection'.$obj, 1);
		}
		elseif( Session::get('searchSection'.$obj)==1 )
		{
			Session::put('searchSection'.$obj, 0);
		}
	}
	
	public function setFontsize(Request $request)
	{
		Session::put('adminfontsize', Input::get('size'));
	}
}
