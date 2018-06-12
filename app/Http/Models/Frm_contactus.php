<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Frm_contactus extends Model
{
	protected $table = "frm_contactus";
	protected $primaryKey = "contactusID";
	protected $fillable = array('firstName','lastName','email','phone','comment','company','role', 'other', 'ip');
	
	public function getAllContactus()
	{
		$firstName=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('frm_contactus');
		if( strlen($firstName) )
		{
			$query->where('firstName','LIKE',trim($firstName).'%');
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('created_at', array($startDate,$endDate));
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('created_at', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllContactus=$query->paginate(10);  //With Pagination
		//$getAllContactus=$query->get();      //Without Pagination
	    //echo $getAllContactus=$query->toSql();	 //For Query print
		
		$result['data']=$getAllContactus;
		$result['rows']=count($getAllContactus);
		return $result;
	}
}
