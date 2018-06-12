<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Product_price extends Model
{
	protected $table = "product_price";
	protected $primaryKey = "priceID";
	protected $fillable = array('productID','sizeID','itemID','categoryID','price','quantity','remainingQuantity','isActive');
	
	function getByAttributesQuery($data)
    {
       
		$query = DB::table('product_price');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('product_price.*','product_price.productID as priceProductID','product_price.isActive as priceStatus','category.*','product_size.*','product_size.isActive as sizeStatus','product_item.itemName')->orderBy('price','asc');
		}
		if(isset($data['priceID']) && strlen(trim($data['priceID'])) > 0)
        {
            $query->where('product_price.priceID',trim($data['priceID']));
        }
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
        {
            $query->where('product_price.productID',trim($data['productID']));
        }
        if(isset($data['sizeID']) && strlen(trim($data['sizeID'])) > 0)
        {
            $query->where('product_price.sizeID',trim($data['sizeID']));
        }
        if(isset($data['itemID']) && strlen(trim($data['itemID'])) > 0)
        {
			$query->where('product_price.itemID',trim($data['itemID']));
        }
        if(isset($data['categoryID']) && strlen(trim($data['categoryID'])) > 0)
        {
			$query->where('product_price.categoryID',trim($data['categoryID']));
        }
        if(isset($data['price']) && strlen(trim($data['price'])) > 0)
        {
			$query->where('product_price.price',trim($data['price']));
        }
        if(isset($data['quantity']) && strlen(trim($data['quantity'])) > 0)
        {
			$query->where('product_price.quantity',trim($data['quantity']));
        }
		if(isset($data['isActive']) && strlen(intval($data['isActive'])) > 0)
        {
            $query->where('product_price.isActive',intval($data['isActive']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('product_size.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('product_size.updated_at',$data['updated_at']);
        }
		if(isset($data['categorytypeID']) && strlen(trim($data['categorytypeID'])) > 0)
        {
            $query->where('category.categorytypeID',trim($data['categorytypeID']));
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

		$query->leftJoin('product','product.productID','=','product_price.productID');
		$query->leftJoin('category','category.categoryID','=','product_price.categoryID');	
		$query->leftJoin('product_size','product_size.sizeID','=','product_price.sizeID');
		$query->leftJoin('product_item','product_item.itemID','=','product_price.itemID');

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
