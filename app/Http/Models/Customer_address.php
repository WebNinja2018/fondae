<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Customer_address extends Model
{
	protected $table = "customer_address";
	protected $primaryKey = "customerAddressID";
	protected $fillable = array('customerID','firstName','lastName','address1','address2','city','state','country','zipcode','phone','typeID','isActive');
	
	public function getAllCustomer_address()
	{
		$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('customer_address');
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
		
		$getAllCustomer_address=$query->paginate(10);  //With Pagination
		//$getAllCustomer_address=$query->get();      //Without Pagination
	    //echo $getAllCustomer_address=$query->toSql();	 //For Query print
		
		$result['data']=$getAllCustomer_address;
		$result['rows']=count($getAllCustomer_address);
		return $result;
	}

	function getByAttributesQuery($data)
	{
		$query = DB::table('customer_address');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('customer_address.*','country.country_name as countryName','states.stateName as stateName');
		}

		if(isset($data['customerAddressID']) && strlen(trim($data['customerAddressID'])) > 0)
		{
			$query->where('customer_address.customerAddressID',$data['customerAddressID']);
		}
		if(isset($data['customerID']) && strlen(trim($data['customerID'])) > 0)
		{
			$query->where('customer_address.customerID',$data['customerID']);
		}
		if(isset($data['firstName']) && strlen(trim($data['firstName'])) > 0)
		{
			$query->where('customer_address.firstName',$data['firstName']);
		}
		if(isset($data['lastName']) && strlen(trim($data['lastName'])) > 0)
		{
			$query->where('customer_address.lastName',$data['lastName']);
		}
		if(isset($data['address1']) && strlen(trim($data['address1'])) > 0)
		{
			$query->where('customer_address.address1',$data['address1']);
		}
		if(isset($data['address2']) && strlen(trim($data['address2'])) > 0)
		{
			$query->where('customer_address.address2',$data['address2']);
		}
		if(isset($data['city']) && strlen(trim($data['city'])) > 0)
		{
			$query->where('customer_address.city',$data['city']);
		}
		if(isset($data['state']) && strlen(trim($data['state'])) > 0)
		{
			$query->where('customer_address.state',$data['state']);
		}
		if(isset($data['country']) && strlen(trim($data['country'])) > 0)
		{
			$query->where('customer_address.country',$data['country']);
		}
		if(isset($data['zipcode']) && strlen(trim($data['zipcode'])) > 0)
		{
			$query->where('customer_address.zipcode',$data['zipcode']);
		}
		if(isset($data['phone']) && strlen(trim($data['phone'])) > 0)
		{
			$query->where('customer_address.phone',$data['phone']);
		}
		if(isset($data['typeID']) && strlen(trim($data['typeID'])) > 0)
		{
			$query->where('customer_address.typeID',$data['typeID']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('customer_address.isActive',$data['isActive']);
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
		$query->leftJoin('country','country.country_id','=','customer_address.country');
		$query->leftJoin('states','states.stateID','=','customer_address.state');

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
