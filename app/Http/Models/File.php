<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class File extends Model
{
	protected $table = "file";
	protected $primaryKey = "fileID";
	protected $fillable = array('fileName','fileTypeID','caption','displayOrder', 'isActive','itemID','createdBy');
	
	public function getAllFile()
	{
		$fileName=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('file');
		if( strlen($fileName) )
		{
			$query->where('fileName','LIKE',trim($fileName).'%');
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
			//$query->orderBy('fileID', 'DESC');			
			$query->orderBy('displayOrder', 'DESC');	
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
	
		$getAllFile=$query->paginate(10);  //With Pagination
		//$getAllFile=$query->get();      //Without Pagination
	    //echo $getAllFile=$query->toSql();	 //For Query print
		
		$result['data']=$getAllFile;
		$result['rows']=count($getAllFile);
		return $result;
	}
}
