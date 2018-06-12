<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Globalsetting extends Model
{
	protected $table = "globalsetting";
	protected $primaryKey = "globalsettingID";
	protected $fillable = array('globalsettingname','globalsettingvalue','isActive','textTypeID', 'valuetype');
	
	public function getAllGlobalsetting()
	{
		$globalsettingname=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('globalsetting');
		if( strlen($globalsettingname) )
		{
			$query->where('globalsettingname','LIKE',trim($globalsettingname).'%');
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
			$query->orderBy('globalsettingID', 'ASC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		//$getAllGlobalsetting=$query->paginate(25);  //With Pagination
		$getAllGlobalsetting=$query->get();      //Without Pagination
	    //echo $getAllGlobalsetting=$query->toSql();	 //For Query print
		
		$result['data']=$getAllGlobalsetting;
		$result['rows']=count($getAllGlobalsetting);
		return $result;
	}
	
	
}
