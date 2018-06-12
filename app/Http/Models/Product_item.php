<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Product_item extends Model
{
	protected $table = "product_item";
	protected $primaryKey = "itemID";
	protected $fillable = array('itemName','sizeID','productID','isActive','createdBy');

	public function getByAttributesQuery($data)
    {
		$query = DB::table('product_item');
        if(isset($data['fieldList']))
        {
            $query->select($data['fieldList']);
        }else{
            $query->select('product_item.*');
        }
        if(isset($data['itemID']) && strlen(trim($data['itemID'])) > 0)
        {
            $query->where('product_item.itemID',trim($data['itemID']));
        }
        if(isset($data['itemName']) && strlen(trim($data['itemName'])) > 0)
        {
            $query->where('product_item.itemName',trim($data['itemName']));
        }
        if(isset($data['sizeID']) && strlen(trim($data['sizeID'])) > 0)
        {
            $query->where('product_item.sizeID',trim($data['sizeID']));
        }
        if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
        {
            $query->where('product_item.productID',$data['productID']);
			$query->orWhere('product_item.productID',0);
        }
        if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
        {
            $query->where('product_item.isActive',trim($data['isActive']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('product_item.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('product_item.updated_at',$data['updated_at']);
        }
        if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
        {
            $query->where('product_item.createdBy',trim($data['createdBy']));
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
