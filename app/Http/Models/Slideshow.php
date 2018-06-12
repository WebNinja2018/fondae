<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Slideshow extends Model
{
	protected $table = "slideshow";
	protected $primaryKey = "slideshowID";
	protected $fillable = array('imagesName','slideshowTitle','caption1','caption2','weblink','displayOrder', 'isActive', 'createdBy');
	
	public function getAllSlideshow()
	{
		$name=Input::get('srach_title')?Input::get('srach_title'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('slideshow');
		if( strlen($name) )
		{
			$query->where('slideshowTitle','LIKE',trim($name).'%');
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
		
		$getAllSlideshow=$query->paginate(10);  //With Pagination
		//$getAllSlideshow=$query->get();      //Without Pagination
	    //echo $getAllSlideshow=$query->toSql();	 //For Query print
		
		$result['data']=$getAllSlideshow;
		$result['rows']=count($getAllSlideshow);
		return $result;
	}

	function getByAttributesQuery($data)
    {
        
		$query = DB::table('slideshow');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('slideshow.*');
		}
        if(isset($data['slideshowID']) && strlen(trim($data['slideshowID'])) > 0)
        {
            $query->where('slideshow.slideshowID',intval($data['slideshowID']));
        }
        if(isset($data['imagesName']) && strlen(trim($data['imagesName'])) > 0)
        {
			$query->where('slideshow.imagesName',trim($data['imagesName']));
        }
        if(isset($data['slideshowTitle']) && strlen(trim($data['slideshowTitle'])) > 0)
        {
			$query->where('slideshow.slideshowTitle',trim($data['slideshowTitle']));
        }
        if(isset($data['caption1']) && strlen(trim($data['caption1'])) > 0)
        {
            $query->where('slideshow.caption1',trim($data['caption1']));
        }
        if(isset($data['caption2']) && strlen(trim($data['caption2'])) > 0)
        {
            $query->where('slideshow.caption2',trim($data['caption2']));
        }
		if(isset($data['weblink']) && strlen(trim($data['weblink'])) > 0)
        {
            $query->where('slideshow.weblink',trim($data['weblink']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('slideshow.isActive',intval($data['isActive']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('slideshow.displayOrder',intval($data['displayOrder']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('slideshow.createdBy',intval($data['createdBy']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('slideshow.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('slideshow.updated_at',$data['updated_at']);
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
