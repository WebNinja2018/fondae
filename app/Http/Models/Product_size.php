<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Product_size extends Model
{
	protected $table = "product_size";
	protected $primaryKey = "sizeID";
	protected $fillable = array('productID','sizeName','sizeNumber','description','eventType','unpaidOption','isActive','createdBy','social_id');
	
	function getByAttributesQuery($data)
    {
        
		$query = DB::table('product_size');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('product_size.*');
		}
		if(isset($data['sizeID']) && strlen(trim($data['sizeID'])) > 0)
        {
            $query->where('product_size.sizeID',trim($data['sizeID']));
        }
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
        {
			$query->where('product_size.productID',$data['productID']);
			$query->orWhere('product_size.productID',0);
        }
		if(isset($data['sizeName']) && strlen(trim($data['sizeName'])) > 0)
        {
            $query->where('product_size.sizeName',trim($data['sizeName']));
        }
		if(isset($data['sizeNumber']) && strlen(trim($data['sizeNumber'])) > 0)
        {
            $query->where('product_size.sizeNumber',trim($data['sizeNumber']));
        }
		if(isset($data['isActive']) && strlen(intval($data['isActive'])) > 0)
        {
            $query->where('product_size.isActive',intval($data['isActive']));
        }
		if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('product_size.createdBy',intval($data['createdBy']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('product_size.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('product_size.updated_at',$data['updated_at']);
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
