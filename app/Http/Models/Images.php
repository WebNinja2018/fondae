<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Images extends Model
{
	protected $table = "images";
	protected $primaryKey = "imagesID";
	protected $fillable = array('imagesID','imagesName','imagesTypeID','caption','displayOrder', 'isActive','itemID',
								'weblink','description','createdBy','caption1','page_id');
	
	public function getAllImages()
	{
		$question=Input::get('srach_question')?Input::get('srach_question'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('images');
		if( strlen($question) )
		{
			$query->where('question','LIKE',trim($question).'%');
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
			//$query->orderBy('imagesID', 'DESC');			
			$query->orderBy('displayOrder', 'DESC');	
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
	
		$getAllImages=$query->paginate(10);  //With Pagination
		//$getAllImages=$query->get();      //Without Pagination
	    //echo $getAllImages=$query->toSql();	 //For Query print
		
		$result['data']=$getAllImages;
		$result['rows']=count($getAllImages);
		return $result;
	}
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('images');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('images.*');
		}
		if(isset($data['imagesID']) && strlen(trim($data['imagesID'])) > 0)
		{
			$query->where('images.imagesID',$data['imagesID']);
		}
		if(isset($data['imagesName']) && strlen(trim($data['imagesName'])) > 0)
		{
			$query->where('images.imagesName',$data['imagesName']);
		}
		if(isset($data['imagesTypeID']) && strlen(trim($data['imagesTypeID'])) > 0)
		{
			$query->where('images.imagesTypeID',$data['imagesTypeID']);
		}
		if(isset($data['caption']) && strlen(trim($data['caption'])) > 0)
		{
			$query->where('images.caption',$data['caption']);
		}
		if(isset($data['displayOrder']) && strlen(trim($data['displayOrder'])) > 0)
		{
			$query->where('images.displayOrder',$data['displayOrder']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('images.isActive',$data['isActive']);
		}
		if(isset($data['itemID']) && strlen(trim($data['itemID'])) > 0)
		{
			$query->where('images.itemID',$data['itemID']);
		}
		if(isset($data['weblink']) && strlen(trim($data['weblink'])) > 0)
		{
			$query->where('images.weblink',$data['weblink']);
		}
		if(isset($data['description']) && strlen(trim($data['description'])) > 0)
		{
			$query->where('images.description',$data['description']);
		}
		if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
		{
			$query->where('images.createdBy',$data['createdBy']);
		}
		if(isset($data['caption1']) && strlen(trim($data['caption1'])) > 0)
		{
			$query->where('images.caption1',$data['caption1']);
		}
		if(isset($data['page_id']) && strlen(trim($data['page_id'])) > 0)
		{
			$query->where('images.page_id',$data['page_id']);
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
