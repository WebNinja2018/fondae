<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Coupon extends Model
{
	protected $table = "coupon";
	protected $primaryKey = 'couponID';
    protected $fillable = array('couponName','couponCode','couponStartDate','couponEndDate','discountType','discountRate','useLimit','isActive','createdBy');
	
	public function getAllCoupon()
	{
		$couponName=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		$query = DB::table('coupon');
		
		if( strlen($couponName) )
		{
			$query->where('couponName','LIKE',trim($couponName).'%');
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
			$query->orderBy('couponID', 'asc');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		
		
		$getAllCoupon=$query->paginate(10);  //With Pagination
		//$getAllCoupon=$query->get();      //Without Pagination
	    //echo $getAllCoupon=$query->toSql();	 //For Query print
		
		$result['rows']=count($getAllCoupon);
		$result['data']=$getAllCoupon;
		
		return $result;
	}

	function getByAttributesQuery($data)
    {
        
		$query = DB::table('coupon');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('coupon.*');
		}
        if(isset($data['couponID']) && strlen(trim($data['couponID'])) > 0)
        {
            $query->where('coupon.couponID',intval($data['couponID']));
        }
        if(isset($data['couponName']) && strlen(trim($data['couponName'])) > 0)
        {
			$query->where('coupon.couponName',trim($data['couponName']));
        }
        if(isset($data['couponCode']) && strlen(trim($data['couponCode'])) > 0)
        {
			$query->where('coupon.couponCode',trim($data['couponCode']));
        }
        if(isset($data['couponStartDate']) && strlen(trim($data['couponStartDate'])) > 0)
        {
            $query->where('coupon.couponStartDate',trim($data['couponStartDate']));
        }
        if(isset($data['couponEndDate']) && strlen(trim($data['couponEndDate'])) > 0)
        {
            $query->where('coupon.couponEndDate',trim($data['couponEndDate']));
        }
        if(isset($data['discountType']) && strlen($data['discountType']) > 0)
        {
             $query->where('coupon.discountType',intval($data['discountType']));
        }
		 if(isset($data['discountRate']) && strlen($data['discountRate']) > 0)
        {
             $query->where('coupon.discountRate',intval($data['discountRate']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('coupon.isActive',intval($data['isActive']));
        }
        if(isset($data['useLimit']) && strlen($data['useLimit']) > 0)
        {
            $query->where('coupon.useLimit',intval($data['useLimit']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('coupon.createdBy',intval($data['createdBy']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('coupon.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('coupon.updated_at',$data['updated_at']);
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
