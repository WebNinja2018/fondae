<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Faqcategory extends Model
{
	protected $table = "faqcategory";
	protected $primaryKey = "faqCategoryID";
	protected $fillable = array('faqID','categoryID');
	
	public function getAllFaqcategory()
	{
		
	}
	function getByAttributesQuery($data)
    {
        
		$query = DB::table('faqcategory');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('faqcategory.*');
		}
        if(isset($data['faqCategoryID']) && strlen(trim($data['faqCategoryID'])) > 0)
        {
            $query->where('faqcategory.faqCategoryID',intval($data['faqCategoryID']));
        }
		if(isset($data['faqID']) && strlen(trim($data['faqID'])) > 0)
        {
            $query->where('faqcategory.faqID',intval($data['faqID']));
        }
		if(isset($data['categoryID']) && strlen(trim($data['categoryID'])) > 0)
        {
            $query->where('faqcategory.categoryID',intval($data['categoryID']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('faqcategory.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('faqcategory.updated_at',$data['updated_at']);
        }
		if(isset($data['urlName']) && strlen(trim($data['urlName'])) > 0)
        {
           $query->where('category.urlName',trim($data['urlName']));
        }
		$query->join('category','category.categoryID','=','faqcategory.categoryID');
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
