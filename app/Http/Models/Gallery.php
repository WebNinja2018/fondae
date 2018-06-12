<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Gallery extends Model
{
	protected $table = "gallery";
	protected $primaryKey = "galleryID";
	protected $fillable = array('imagesTypeID','galleryTitle','galleryMainImage','weblink','displayOrder', 'isActive', 'featured','createdBy','url_title');
	
	public function getAllGallery()
	{
		$name=Input::get('srach_title')?Input::get('srach_title'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('gallery');
	    //$query->select('*,(select count(*) from images where itemID=gallery.galleryID  AND imagesTypeID=6) as images');
		if( strlen($name) )
		{
			$query->where('galleryTitle','LIKE',trim($name).'%');
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
		
		$getAllGallery=$query->paginate(10);  //With Pagination
		//$getAllGallery=$query->get();      //Without Pagination
	    //echo $getAllGallery=$query->toSql();	 //For Query print
		
		$result['data']=$getAllGallery;
		$result['rows']=count($getAllGallery);
		return $result;
	}

	function getByAttributesQuery($data)
	{

		$query = DB::table('gallery');
		if(isset($data['fieldList']))
		{
			 $query->select($data['fieldList']);
		}else{
			 $query->select('gallery.*');
		}
		if(isset($data['galleryID']) && strlen(trim($data['galleryID'])) > 0)
		{
			 $query->where('gallery.galleryID',$data['galleryID']);
		}
		if(isset($data['imagesTypeID']) && strlen(trim($data['imagesTypeID'])) > 0)
		{
			 $query->where('gallery.imagesTypeID',$data['imagesTypeID']);
		}
		if(isset($data['caption']) && strlen(trim($data['caption'])) > 0)
		{
			 $query->where('gallery.caption',$data['caption']);
		}
		if(isset($data['galleryMainImage']) && strlen(trim($data['galleryMainImage'])) > 0)
		{
			 $query->where('gallery.galleryMainImage',$data['galleryMainImage']);
		}
		if(isset($data['weblink']) && strlen(trim($data['weblink'])) > 0)
		{
			 $query->where('gallery.weblink',$data['weblink']);
		}
		if(isset($data['featured']) && strlen(trim($data['featured'])) > 0)
		{
			 $query->where('gallery.featured',$data['featured']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			 $query->where('gallery.isActive',$data['isActive']);
		}
		if(isset($data['displayOrder']) && strlen(trim($data['displayOrder'])) > 0)
		{
			 $query->where('gallery.displayOrder',$data['displayOrder']);
		}
		if(isset($data['url_title']) && strlen(trim($data['url_title'])) > 0)
		{
			 $query->where('gallery.url_title',$data['url_title']);
		}
		if(isset($data['createdDate']) && strlen(trim($data['createdDate'])) > 0)
		{
			 $query->where('gallery.createdDate',$data['createdDate']);
		}
		if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
		{
			 $query->where('gallery.createdBy',$data['createdBy']);
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
