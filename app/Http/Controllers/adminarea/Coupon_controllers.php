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
use App\Http\Models\Coupon;

class Coupon_controllers extends Controller
{
	public function index(Request $request)
	{
		$coupon= new Coupon;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $couponID)
				{
					$query = Coupon::where('couponID', $couponID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $couponID)
				{
					Coupon::destroy($couponID);
				}
			}
		}
		
		$result=$coupon ->getAllCoupon();
		$data['recordcount']=$result['rows'];
		$data['qGetAllCoupon']=$result['data'];
		return view('adminarea.coupon.coupon',$data);
		
	}
	
	public function addeditcoupon(Request $request)
	{	
		
		//Get Single Coupon
		$couponID=$request->couponID;
		$data['getsinglecoupon'] = Coupon::find($couponID);
		return view('adminarea.coupon.coupon-addedit',$data);
	}

	public function savecoupon(Request $request)
	{	
	
		if($request->couponID !='' && $request->couponID >0)
		{
			$this->validate($request,array('couponName'=>'required','couponCode'=>'required','couponStartDate' => 'required','couponEndDate' => 'required','useLimit' => 'required'));
		}
		else
		{
			$this->validate($request,array('couponName'=>'required|unique:coupon,couponName','couponCode'=>'required','couponStartDate' => 'required','couponEndDate' => 'required','useLimit' => 'required'));

		}
			
		$isActive=$request->isActive;
		
		$record = array(
						'couponName'=>ucwords(trim($request->couponName)),
						'couponCode'=>ucwords(trim($request->couponCode)),
						'couponStartDate'=>date('Y-m-d H:i:s',strtotime($request->couponStartDate)),
						'couponEndDate'=>date('Y-m-d H:i:s',strtotime($request->couponEndDate)),
						'discountType'=>$request->discountType,
						'discountRate'=>$request->discountRate,
						'useLimit'=>$request->useLimit,
						'isActive'=>$isActive,
						'createdby'=>Session::get('admin_user')
						);
		
		if ($request->couponID!= NULL && $request->couponID > 0) 
		{
			$coupon= new Coupon;
			$couponID=$request->couponID;
			$query = $coupon->where('couponID', $couponID)
                				->update($record);
			
		}
		else
		{
			$coupon= new Coupon($record);
			$coupon->save();
			$couponID = $coupon->couponID;
			
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Coupon successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->couponID;
		Coupon::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$couponID =$request->couponID;
		$coupon=Coupon::find($couponID);
		$isActive = $coupon->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Coupon::where('couponID', $couponID)
                				->update($data);
		echo $isActive;
	}
	
	public function couponorder(Request $request)
	{
		$result = Coupon::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllCoupon']=$result;
		return view('adminarea.coupon.couponorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Coupon::where('couponID', $item[$i])
									->update($data);
		}
	}
}
