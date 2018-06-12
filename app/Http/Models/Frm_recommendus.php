<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Frm_recommendus extends Model
{
	protected $table = "frm_recommendus";
	protected $primaryKey = "recommendusID";
	protected $fillable = array('yourName','yourEmail','friendName','friendEmail','message','pageLink','recommendType','ip');
	
	public function getAllEmailthispage()
	{
		$yourName=Input::get('srach_yourName')?Input::get('srach_yourName'):'';
		$friendName=Input::get('srach_friendName')?Input::get('srach_friendName'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('frm_recommendus');
		if( strlen($yourName) )
		{
			$query->where('yourName','LIKE',trim($yourName).'%');
		}
		if( strlen($friendName) )
		{
			$query->where('friendName','LIKE',trim($friendName).'%');
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
