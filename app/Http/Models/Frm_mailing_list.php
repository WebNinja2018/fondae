<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Frm_mailing_list extends Model
{
	protected $table = "frm_mailing_list";
	protected $primaryKey = "mailingID";
	protected $fillable = array('email','isActive','ip');
	
	public function getAllEmailnews()
	{
		$email=Input::get('srach_email')?Input::get('srach_email'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('frm_mailing_list');
		if( strlen($email) )
		{
			$query->where('email','LIKE',trim($email).'%');
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
		
		$getAllEmailthispage=$query->paginate(10);  //With Pagination
		//$getAllEmailthispage=$query->get();      //Without Pagination
	    //echo $getAllEmailthispage=$query->toSql();	 //For Query print
		
		$result['data']=$getAllEmailthispage;
		$result['rows']=count($getAllEmailthispage);
		return $result;
	}
}
