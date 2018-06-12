<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Role extends Model
{
	protected $table = "role";
	protected $primaryKey = "roleID";
	protected $fillable = array('roleID','name','description', 'isActive', 'createdDate','createdBy');
	
	public function getAllRole()
	{
		$name=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')?date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')?date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('role');
		if( strlen($name)>0 )
		{
			$query->where('name','LIKE',trim($name).'%');
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
			$query->orderBy('roleID', 'asc');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
	  

		$getAllRole=$query->paginate(10);  //With Pagination
		//$getAllRole=$query->get();      //Without Pagination
	    //echo $getAllRole=$query->toSql();	 //For Query print
		
		$result['data']=$getAllRole;
		$result['rows']=count($getAllRole);
		return $result;
	}
}
