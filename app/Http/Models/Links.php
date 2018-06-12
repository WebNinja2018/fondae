<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Links extends Model
{
	protected $table = "links";
	protected $primaryKey = "linksID";
	protected $fillable = array('linksID','name','description','linksImage','altTag','weblink','displayOrder', 'isActive', 'isFeature', 'createdBy');
	
	public function getAllLinks()
	{
		$name=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('links');
		if( strlen($name) )
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
			$query->orderBy('created_at', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllLinks=$query->paginate(10);  //With Pagination
		//$getAllLinks=$query->get();      //Without Pagination
	    //echo $getAllLinks=$query->toSql();	 //For Query print
		
		$result['data']=$getAllLinks;
		$result['rows']=count($getAllLinks);
		return $result;
	}

	function getByAttributesQuery($data)
	{
		$query = DB::table('links');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('links.*');
		}
		if(isset($data['linksID']) && strlen(trim($data['linksID'])) > 0)
		{
			$query->where('links.linksID',$data['linksID']);
		}
		if(isset($data['name']) && strlen(trim($data['name'])) > 0)
		{
			$query->where('links.name',$data['name']);
		}
		if(isset($data['description']) && strlen(trim($data['description'])) > 0)
		{
			$query->where('links.description',$data['description']);
		}
		if(isset($data['linksImage']) && strlen(trim($data['linksImage'])) > 0)
		{
			$query->where('links.linksImage',$data['linksImage']);
		}
		if(isset($data['altTag']) && strlen(trim($data['altTag'])) > 0)
		{
			$query->where('links.altTag',$data['altTag']);
		}
		if(isset($data['weblink']) && strlen(trim($data['weblink'])) > 0)
		{
			$query->where('links.weblink',$data['weblink']);
		}
		if(isset($data['displayOrder']) && strlen(trim($data['displayOrder'])) > 0)
		{
			$query->where('links.displayOrder',$data['displayOrder']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('links.isActive',$data['isActive']);
		}
		if(isset($data['isFeature']) && strlen(trim($data['isFeature'])) > 0)
		{
			$query->where('links.isFeature',$data['isFeature']);
		}
		if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
		{
			$query->where('links.createdBy',$data['createdBy']);
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
