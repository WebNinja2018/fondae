<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Testimonials extends Model
{
	protected $table = "testimonials";
	protected $primaryKey = 'testimonialsID';
    protected $fillable = array('clientName','designation','details','testimonial_img','displayOrder','isActive','createdBy','featured');
	
	public function getAllTestimonials()
	{
		$clientName=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		$query = DB::table('testimonials');
		
		if( strlen($clientName) )
		{
			$query->where('clientName','LIKE',trim($clientName).'%');
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
			$query->orderBy('testimonialsID', 'asc');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		
		
		$getAllTestimonials=$query->paginate(10);  //With Pagination
		//$getAllTestimonials=$query->get();      //Without Pagination
	    //echo $getAllTestimonials=$query->toSql();	 //For Query print
		
		$result['rows']=count($getAllTestimonials);
		$result['data']=$getAllTestimonials;
		
		return $result;
	}

	function getByAttributesQuery($data)
    {
        
		$query = DB::table('testimonials');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('testimonials.*');
		}
        if(isset($data['testimonialsID']) && strlen(trim($data['testimonialsID'])) > 0)
        {
            $query->where('testimonials.testimonialsID',intval($data['testimonialsID']));
        }
        if(isset($data['clientName']) && strlen(trim($data['clientName'])) > 0)
        {
			$query->where('testimonials.clientName',trim($data['clientName']));
        }
        if(isset($data['designation']) && strlen(trim($data['designation'])) > 0)
        {
			$query->where('testimonials.designation',trim($data['designation']));
        }
        if(isset($data['details']) && strlen(trim($data['details'])) > 0)
        {
            $query->where('testimonials.details',trim($data['details']));
        }
        if(isset($data['testimonial_img']) && strlen(trim($data['testimonial_img'])) > 0)
        {
            $query->where('testimonials.testimonial_img',trim($data['testimonial_img']));
        }
        if(isset($data['featured']) && strlen($data['featured']) > 0)
        {
             $query->where('testimonials.featured',intval($data['featured']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('testimonials.isActive',intval($data['isActive']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('testimonials.displayOrder',intval($data['displayOrder']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('testimonials.createdBy',intval($data['createdBy']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('testimonials.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('testimonials.updated_at',$data['updated_at']);
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
