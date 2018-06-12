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
use App\Http\Models\Customer;
use App\Http\Models\Role;

class Customer_controllers extends Controller
{
	public function index(Request $request)
	{
		$customer= new Customer;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $customerID)
				{
					$query = Customer::where('customerID', $customerID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $customerID)
				{
					Customer::destroy($customerID);
				}
			}
		}
		$result=$customer->getAllCustomer();
		$data['recordcount']=$result['rows'];
		$data['qGetAllCustomer']=$result['data'];
		return view('adminarea.customer.customer',$data);
		
	}
	public function addeditcustomer(Request $request)
	{	
		$customerID=$request->customerID;
		$data['pageno'] = $request->pageno ? $request->pageno:0;
		$data['getsingleCustomers'] = Customer::find($customerID);
		
		$role= new Role;
		$result=$role->getAllRole();
		$data['getRole']=$result['data'];
		return view('adminarea.customer.customer-addedit',$data);
	}

	public function savecustomer(Request $request)
	{
		if ($request->customerID!= NULL && $request->customerID > 0) 
		{
			$this->validate($request,array('firstName'=>'required','lastName'=>'required','roleID'=>'required','email'=>'required|email','imgName'=>'image|mimes:jpeg,jpg|max:2000'));
		}else{
			$this->validate($request,array('firstName'=>'required','lastName'=>'required','roleID'=>'required','email'=>'required|email|unique:customer,email','imgName'=>'image|mimes:jpeg,jpg|max:2000'));
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
		
		$image = $request->file('imgName');
		
		if($image){
			
			//$input['imagename'] = $request->imagesName;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/customer');
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
			$customer_img=$input['imagename'];
			
		}else{
			$customer_img=$request->imgName_old;
		}
		
		$record = array(
						'roleID'=>$request->roleID,
						'firstName'=>ucwords(trim($request->firstName)),
						'lastName'=>ucwords(trim($request->lastName)),
						'email'=>trim($request->email),
						'facebookConnect'=>trim($request->facebookConnect),
						'location'=>trim($request->location),
						'bio'=>trim($request->bio),
						'imgName'=>trim($customer_img),
						'isActive'=>$request->isActive,
						'password'=>$key
						);

		if ($request->customerID!= NULL && $request->customerID > 0) 
		{
			$customer= new Customer;
			$customerID=$request->customerID;
			$query = $customer->where('customerID', $customerID)
                				->update($record);
		}
		else
		{
			$customer= new Customer($record);
			$customer->save();
			$customerID = $customer->customerID;
		}
		
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Customer successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->customerID;
		Customer::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$customerID =$request->customerID;
		$customer=Customer::find($customerID);
		$isActive = $customer->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Customer::where('customerID', $customerID)
                				->update($data);
		echo $isActive;
	}
}
