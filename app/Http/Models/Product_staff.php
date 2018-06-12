<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Product_staff extends Model
{
	protected $table = "product_staff";
	protected $primaryKey = "productstaffID";
	protected $fillable = array('productID','staffID','parentID');
	
	public function getAllProductStaff()
	{
		
	}

	function getByAttributesQuery($data)
	{
		$query = DB::table('product_staff');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('product_staff.*','product.*','category.categoryName');
		}

		if(isset($data['productstaffID']) && strlen(trim($data['productstaffID'])) > 0)
		{
			$query->where('product_staff.productstaffID',$data['productstaffID']);
		}
		if(isset($data['staffID']) && strlen(trim($data['staffID'])) > 0)
		{
			$query->where('product_staff.staffID',$data['staffID']);
		}
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
		{
			$query->where('product_staff.productID',$data['productID']);
		}
		if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('product_staff.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('product_staff.updated_at',$data['updated_at']);
        }

		if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('product.isActive',$data['isActive']);
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
		$query->join('product','product.productID','=','product_staff.productID');
		$query->join('staff','staff.staffID','=','product_staff.staffID');
		$query->leftJoin('product_category','product.productID','=','product_category.productID');
		$query->leftJoin('category','category.categoryID','=','product_category.categoryID');	

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
