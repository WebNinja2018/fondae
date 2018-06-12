<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Cart_detail extends Model
{
	protected $table = "cart_detail";
	protected $primaryKey = "cartDetailID";
	protected $fillable = array('cartID','productID','sizeID','itemID','quantity','createdBy');
	
	function getByAttributesQuery($data)
    {
        
		$query = DB::table('cart_detail');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('cart_detail.*');
		}
		if(isset($data['cartDetailID']) && strlen(trim($data['cartDetailID'])) > 0)
		{
			$query->where('cart_detail.cartDetailID',$data['cartDetailID']);
		}
		if(isset($data['cartID']) && strlen(trim($data['cartID'])) > 0)
		{
			$query->where('cart_detail.cartID',$data['cartID']);
		}
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
		{
			$query->where('cart_detail.productID',$data['productID']);
		}
		if(isset($data['sizeID']) && strlen(trim($data['sizeID'])) > 0)
		{
			$query->where('cart_detail.sizeID',$data['sizeID']);
		}
		if(isset($data['itemID']) && strlen(trim($data['itemID'])) > 0)
		{
			$query->where('cart_detail.itemID',$data['itemID']);
		}
		if(isset($data['quantity']) && strlen(trim($data['quantity'])) > 0)
		{
			$query->where('cart_detail.quantity',$data['quantity']);
		}
		if(isset($data['createdBy']) && strlen(trim($data['createdBy'])) > 0)
		{
			$query->where('cart_detail.createdBy',$data['createdBy']);
		}
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('cart.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('cart.updated_at',$data['updated_at']);
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
