<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Commonmessage extends Model
{
	protected $table = "commonmessage";
	protected $primaryKey = "commonmessageID";
	protected $fillable = array('variableName','description','isActive','textTypeID');
	
	public function getAllCommonmessage()
	{
		$variableName=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('commonmessage');
		if( strlen($variableName) )
		{
			$query->where('variableName','LIKE',trim($variableName).'%');
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
			$query->orderBy('created_at', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		//$getAllCommonmessage=$query->paginate(25);  //With Pagination
		$getAllCommonmessage=$query->get();      //Without Pagination
	    //echo $getAllCommonmessage=$query->toSql();	 //For Query print
		
		$result['data']=$getAllCommonmessage;
		$result['rows']=count($getAllCommonmessage);
		return $result;
	}
	
	
}
