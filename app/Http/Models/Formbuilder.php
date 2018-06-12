<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Formbuilder extends Model
{
	protected $table = "formbuilder";
	protected $primaryKey = "formID";
	protected $fillable = array('formName','formLabel','tableName','pageTitle','pageMetaKeywords','pageMetaDiscriptions'
,'displayOrder', 'isActive', 'isEmail', 'isInstant', 'isAuto', 'isCaptcha', 'createdBy', 'isadminmail');
	
	public function getAllFormbuilder()
	{
		$formName=Input::get('srach_formName')?Input::get('srach_formName'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$isActive=1;
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('formbuilder');
		if( strlen($formName) )
		{
			$query->where('formName','LIKE',trim($formName).'%');
		}
		if( strlen($isActive) )
		{
			$query->where('isActive',trim($isActive));
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('created_at', array($startDate,$endDate));
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('formID', 'ASC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllFormbuilder=$query->paginate(10);  //With Pagination
		//$getAllFormbuilder=$query->get();      //Without Pagination
	    //echo $getAllFormbuilder=$query->toSql();	 //For Query print
		
		$result['data']=$getAllFormbuilder;
		$result['rows']=count($getAllFormbuilder);
		return $result;
	}
}
