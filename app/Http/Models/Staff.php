<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Staff extends Model
{
	protected $table = "staff";
	protected $primaryKey = "staffID";
	protected $fillable = array('firstname','lastname','position','email','telephone','telephone_type', 'alt_telephone_type', 'alt_telephone', 'bio','facebook','google','twitter', 'displayOrder'
, 'imgFileName_staff', 'isActive', 'firstname_public', 'lastname_public', 'position_public', 'email_public', 'telephone_public', 'alt_telephone_public', 'bio_public', 'image_public', 'createdBy', 'alttag');
	
	public function getAllStaff()
	{
		$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('staff');
		if( strlen($srach_name) )
		{
			$query->where('firstname','LIKE',trim($srach_name).'%');
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
			$query->orderBy('created_at', 'ASC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllStaff=$query->paginate(10);  //With Pagination
		//$getAllStaff=$query->get();      //Without Pagination
	    //echo $getAllStaff=$query->toSql();	 //For Query print
		
		$result['data']=$getAllStaff;
		$result['rows']=count($getAllStaff);
		return $result;
	}

	function getByAttributesQuery($data)
	{
		$query = DB::table('staff');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			//$query->select('staff.*','category.urlName','category.categoryID','category.categoryName');
			$query->select('staff.*');
		}

		if(isset($data['staffID']) && strlen(trim($data['staffID'])) > 0)
		{
			$query->where('staff.staffID',$data['staffID']);
		}
		if(isset($data['firstname']) && strlen(trim($data['firstname'])) > 0)
		{
			$query->where('staff.firstname',$data['firstname']);
		}
		if(isset($data['lastname']) && strlen(trim($data['lastname'])) > 0)
		{
			$query->where('staff.lastname',$data['lastname']);
		}
		if(isset($data['position']) && strlen(trim($data['position'])) > 0)
		{
			$query->where('staff.position',$data['position']);
		}
		if(isset($data['email']) && strlen(trim($data['email'])) > 0)
		{
			$query->where('staff.email',$data['email']);
		}
		if(isset($data['telephone']) && strlen(trim($data['telephone'])) > 0)
		{
			$query->where('staff.telephone',$data['telephone']);
		}
		if(isset($data['telephone_type']) && strlen(trim($data['telephone_type'])) > 0)
		{
			$query->where('staff.telephone_type',$data['telephone_type']);
		}
		if(isset($data['alt_telephone_type']) && strlen(trim($data['alt_telephone_type'])) > 0)
		{
			$query->where('staff.alt_telephone_type',$data['alt_telephone_type']);
		}
		if(isset($data['alt_telephone']) && strlen(trim($data['alt_telephone'])) > 0)
		{
			$query->where('staff.alt_telephone',$data['alt_telephone']);
		}
		if(isset($data['bio']) && strlen(trim($data['bio'])) > 0)
		{
			$query->where('staff.bio',$data['bio']);
		}
		if(isset($data['facebook']) && strlen(trim($data['facebook'])) > 0)
		{
			$query->where('staff.facebook',$data['facebook']);
		}
		if(isset($data['google']) && strlen(trim($data['google'])) > 0)
		{
			$query->where('staff.google',$data['google']);
		}
		if(isset($data['twitter']) && strlen(trim($data['twitter'])) > 0)
		{
			$query->where('staff.twitter',$data['twitter']);
		}
		if(isset($data['displayOrder']) && strlen(trim($data['displayOrder'])) > 0)
		{
			$query->where('staff.displayOrder',$data['displayOrder']);
		}
		if(isset($data['imgFileName_staff']) && strlen(trim($data['imgFileName_staff'])) > 0)
		{
			$query->where('staff.imgFileName_staff',$data['imgFileName_staff']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('staff.isActive',$data['isActive']);
		}
		if(isset($data['firstname_public']) && strlen(trim($data['firstname_public'])) > 0)
		{
			$query->where('staff.firstname_public',$data['firstname_public']);
		}
		if(isset($data['lastname_public']) && strlen(trim($data['lastname_public'])) > 0)
		{
			$query->where('staff.lastname_public',$data['lastname_public']);
		}
		if(isset($data['position_public']) && strlen(trim($data['position_public'])) > 0)
		{
			$query->where('staff.position_public',$data['position_public']);
		}
		if(isset($data['email_public']) && strlen(trim($data['email_public'])) > 0)
		{
			$query->where('staff.email_public',$data['email_public']);
		}
		if(isset($data['telephone_public']) && strlen(trim($data['telephone_public'])) > 0)
		{
			$query->where('staff.telephone_public',$data['telephone_public']);
		}
		if(isset($data['alt_telephone_public']) && strlen(trim($data['alt_telephone_public'])) > 0)
		{
			$query->where('staff.alt_telephone_public',$data['alt_telephone_public']);
		}
		if(isset($data['bio_public']) && strlen(trim($data['bio_public'])) > 0)
		{
			$query->where('staff.bio_public',$data['bio_public']);
		}
		if(isset($data['image_public']) && strlen(trim($data['image_public'])) > 0)
		{
			$query->where('staff.image_public',$data['image_public']);
		}
		if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
		{
			$query->where('staff.createdBy',$data['createdBy']);
		}
		if(isset($data['alttag']) && strlen(trim($data['alttag'])) > 0)
		{
			$query->where('staff.alttag',$data['alttag']);
		}
		//if(isset($data['staffCategoryUrlName']) && strlen(trim($data['staffCategoryUrlName'])) > 0)
//		{
//			$query->where('category.urlName',$data['staffCategoryUrlName']);
//		}
		if(isset($data['url_title']) && strlen(trim($data['url_title'])) > 0)
		{
			$query->where('staff.url_title',$data['url_title']);
		}
		//if(isset($data['categoryisActive']) && strlen(trim($data['categoryisActive'])) > 0)
//		{
//			$query->where('category.isActive',$data['categoryisActive']);
//		}
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
		//$query->leftJoin('staffcategory','staff.staffID','=','staffcategory.staffID');
		//$query->leftJoin('category','category.categoryID','=','staffcategory.categoryID');

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
