<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Customer extends Model
{
	protected $table = "customer";
	protected $primaryKey = "customerID";
	protected $fillable = array('firstName','lastName','email','password','isActive','facebookConnect','location','bio','isApprove','customerType','ip','MacID','roleID');
	
	public function getAllCustomer()
	{
		$srach_name=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('customer');
		$query->select('customer.*','role.name');
		$query->join('role', 'role.roleID', '=', 'customer.roleID');
		if( strlen($srach_name) )
		{
			$query->where('firstName','LIKE',trim($srach_name).'%');
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('created_at', array($startDate,$endDate));
		}
		if(strlen($srch_status)>0)
		{
			$query->where('isActive',$srch_status);
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('created_at', 'ASC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllCustomer=$query->paginate(10);  //With Pagination
		//$getAllCustomer=$query->get();      //Without Pagination
	    //echo $getAllCustomer=$query->toSql();	 //For Query print
		
		$result['data']=$getAllCustomer;
		$result['rows']=count($getAllCustomer);
		return $result;
	}

	function getByAttributesQuery($data)
	{
		$query = DB::table('customer');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('customer.*');
		}

		if(isset($data['customerID']) && strlen(trim($data['customerID'])) > 0)
		{
			$query->where('customer.customerID',$data['customerID']);
		}
		if(isset($data['md5(customerID)']) && strlen(trim($data['md5(customerID)'])) > 0)
		{
			$query->whereRaw('md5(`customerID`) = "'.$data['md5(customerID)'].'"');
		}
		if(isset($data['firstName']) && strlen(trim($data['firstName'])) > 0)
		{
			$query->where('customer.firstName',$data['firstName']);
		}
		if(isset($data['lastName']) && strlen(trim($data['lastName'])) > 0)
		{
			$query->where('customer.lastName',$data['lastName']);
		}
		if(isset($data['email']) && strlen(trim($data['email'])) > 0)
		{
			$query->where('customer.email',$data['email']);
		}
		if(isset($data['password']) && strlen(trim($data['password'])) > 0)
		{
			$query->where('customer.password',$data['password']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('customer.isActive',$data['isActive']);
		}
		if(isset($data['isApprove']) && strlen(trim($data['isApprove'])) > 0)
		{
			$query->where('customer.isApprove',$data['isApprove']);
		}
		if(isset($data['customerType']) && strlen(trim($data['customerType'])) > 0)
		{
			$query->where('customer.customerType',$data['customerType']);
		}
		if(isset($data['ip']) && strlen(trim($data['ip'])) > 0)
		{
			$query->where('customer.ip',$data['ip']);
		}
		if(isset($data['MacID']) && strlen(trim($data['MacID'])) > 0)
		{
			$query->where('customer.MacID',$data['MacID']);
		}
		if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
        {
			if(isset($data['order']) && strlen(trim($data['order'])) > 0)
			{
           		$query->orderBy($data['orderBy'],$data['order']);
        	}else{
				$query->orderBy($data['orderBy']);
			}
		}
		if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
		{
			$query->groupBy($data['groupBy']);
		}
		//$query->leftJoin('customercategory','customer.customerID','=','customercategory.customerID');
		//$query->leftJoin('category','category.categoryID','=','customercategory.categoryID');

		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }
		$result['recordCount'] = count($result['data']);
        return $result;
	}
}
