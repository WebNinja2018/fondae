<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Order_details extends Model
{
	protected $table = "order_details";
	protected $primaryKey = "orderDetailsID";
	protected $fillable = array('customerID','productID','sizeID','itemID','orderID','productName','price','product_quantity','total','sizeName','itemName','email','image');
	
	function getByAttributesQuery($data)
    {
		$query = DB::table('order_details');

		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('orders.*','order_details.*','product.productName','product.itemnumber','product.prodcutImage','productsize.*','product_price.*');
		}
		if(isset($data['orderDetailsID']) && strlen(trim($data['orderDetailsID'])) > 0)
		{
			$query->where('order_details.orderDetailsID',$data['orderDetailsID']);
		}
		if(isset($data['customerID']) && strlen(trim($data['customerID'])) > 0)
		{
			$query->where('order_details.customerID',$data['customerID']);
		}
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
		{
			$query->where('order_details.productID',$data['productID']);
		}
		if(isset($data['sizeID']) && strlen(trim($data['sizeID'])) > 0)
		{
			$query->where('order_details.sizeID',$data['sizeID']);
		}
		if(isset($data['itemID']) && strlen(trim($data['itemID'])) > 0)
		{
			$query->where('order_details.itemID',$data['itemID']);
		}
		if(isset($data['orderID']) && strlen(trim($data['orderID'])) > 0)
		{
			$query->where('order_details.orderID',$data['orderID']);
		}
		if(isset($data['cardID']) && strlen(trim($data['cardID'])) > 0)
		{
			$query->where('order_details.cardID',$data['cardID']);
		}
		if(isset($data['productName']) && strlen(trim($data['productName'])) > 0)
		{
			$query->where('order_details.productName',$data['productName']);
		}
		if(isset($data['price']) && strlen(trim($data['price'])) > 0)
		{
			$query->where('order_details.price',$data['price']);
		}
		if(isset($data['product_quantity']) && strlen(trim($data['product_quantity'])) > 0)
		{
			$query->where('order_details.product_quantity',$data['product_quantity']);
		}
		if(isset($data['total']) && strlen(trim($data['total'])) > 0)
		{
			$query->where('order_details.total',$data['total']);
		}
		if(isset($data['email']) && strlen(trim($data['email'])) > 0)
		{
			$query->where('order_details.email',$data['email']);
		}
		if(isset($data['image']) && strlen(trim($data['image'])) > 0)
		{
			$query->where('order_details.image',$data['image']);
		}
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('order_details.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('order_details.updated_at',$data['updated_at']);
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
		
		$query->join('orders','orders.orderID','=','order_details.orderID');
		$query->join('product','product.productID','=','order_details.productID');	
		$query->join('product_size','product_size.sizeID','=','order_details.sizeID');
		$query->join('product_price','product_price.sizeID','=','product_size.sizeID');

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
