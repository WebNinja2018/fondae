<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Category_model extends Model
{
	protected $table = "category";
	protected $primaryKey = 'categoryID';
    protected $fillable = array('categoryname','parentCategoryID','categorytypeID','displayOrder','isActive','isFeatured','pageTitle','pageMetaKeyword','pageDescription','content','imagename','createdby','urlName','explore_page');
	
	public function getAllCategory($categorytypeID)
	{
		$categoryname=Input::get('srach_categoryname')?Input::get('srach_categoryname'):'';
		$srch_status=Input::get('srch_status');
		$srach_parentcategoryname=Input::get('srach_parentcategoryname')?Input::get('srach_parentcategoryname'):'';
		$srch_parentCategory=Input::get('srch_parentCategory')?Input::get('srch_parentCategory'):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';

		$explore_page=Input::get('explore_page')?Input::get('explore_page'):'';

		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		
		$query = DB::table('category');
		
		$query->select('category.*','s.categoryname as parentcategoryname');
		$query->leftJoin('category as s', 's.categoryID', '=', 'category.parentCategoryID');
		if( strlen($categoryname) )
		{
			$query->where('category.categoryname','LIKE',trim($categoryname).'%');
		}
		if( strlen($categorytypeID) )
		{
			$query->where('category.categorytypeID',$categorytypeID);
		}
		if(strlen($srch_status))
		{
			$query->where('category.isActive',$srch_status);
		}

		if(strlen($explore_page))
		{
			$query->where('category.explore_page',$explore_page);
		}



		if( strlen($srch_parentCategory) > 0)
		{
			$query->where('category.parentCategoryID',$srch_parentCategory);
		}
		if( strlen($srach_parentcategoryname) > 0)
		{
			$query->where('s.categoryname',$srach_parentcategoryname);
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('category.created_at', array($startDate,$endDate));
		}
		if($fieldname=='' || $order==''){
			//$query->orderBy('category.created_at', 'desc');		
			$query->orderBy('category.displayOrder', 'asc');		
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllCategory=$query->paginate(10);  //With Pagination
		//$getAllCategory=$query->get();      //Without Pagination
	    //echo $getAllCategory=$query->toSql();	 //For Query print
		
		$result['data']=$getAllCategory;
		$result['rows']=count($getAllCategory);
		
		
		return $result;
		
	}
	
	public function fun_getparent($id)
	{
		global $tmp;
		
		$query = DB::table('category');
		$query->select('parentCategoryID');
		$query->where('categoryID',$id);
		$q_select_row=$query->get();    
		$q_get_result =count($q_select_row);

		if($q_get_result[0] > 0)
		{
			$tmp = $q_get_result[0].",".$tmp;
			fun_getparent($q_get_result[0]);
		}
		else
		{
			$_SESSION['str2']=$tmp;
		}
	}
	
	public function getByAttributesQuery($data)
    {
		$query = DB::table('category');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('category.*');
		}
        if(isset($data['categoryID']) && strlen(trim($data['categoryID'])) > 0)
        {
            $query->where('category.categoryID',intval($data['categoryID']));
        }
        if(isset($data['categoryname']) && strlen(trim($data['categoryname'])) > 0)
        {
			$query->where('category.categoryname',trim($data['categoryname']));
        }
		if(isset($data['parentCategoryID']) && strlen(trim($data['parentCategoryID'])) > 0)
        {
            $query->where('category.parentCategoryID',intval($data['parentCategoryID']));
        }
        if(isset($data['categorytypeID']) && strlen(trim($data['categorytypeID'])) > 0)
        {
            $query->where('category.categorytypeID',intval($data['categorytypeID']));
        }
        if(isset($data['displayOrder']) && strlen(trim($data['displayOrder'])) > 0)
        {
            $query->where('category.displayOrder',intval($data['displayOrder']));
        }
		if(isset($data['pageTitle']) && strlen(trim($data['pageTitle'])) > 0)
        {
            $query->where('category.pageTitle',trim($data['pageTitle']));
        }
        if(isset($data['pageMetaKeyword']) && strlen(trim($data['pageMetaKeyword'])) > 0)
        {
            $query->where('category.pageMetaKeyword',trim($data['pageMetaKeyword']));
        }
        if(isset($data['pageDescription']) && strlen(trim($data['pageDescription'])) > 0)
        {
            $query->where('category.pageDescription',trim($data['pageDescription']));
        }
        
        if(isset($data['featured']) && strlen($data['featured']) > 0)
        {
             $query->where('category.featured',intval($data['featured']));
        }

        if(isset($data['explore_page']) && strlen($data['explore_page']) > 0)
        {
             $query->where('category.explore_page',intval($data['explore_page']));
        }

        
        if(isset($data['isFeatured']) && strlen($data['isFeatured']) > 0)
        {
            $query->where('category.isFeatured',intval($data['isFeatured']));
        }


        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('category.isActive',intval($data['isActive']));
        }


        
        if(isset($data['content']) && strlen($data['content']) > 0)
        {
            $query->where('category.content',trim($data['content']));
        }
        if(isset($data['imagename']) && strlen($data['imagename']) > 0)
        {
            $query->where('category.imagename',trim($data['imagename']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('category.createdBy',intval($data['createdBy']));
        }
        if(isset($data['urlName']) && strlen(trim($data['urlName'])) > 0)
        {
           $query->where('category.urlName',trim($data['urlName']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('category.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('category.updated_at',$data['updated_at']);
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
