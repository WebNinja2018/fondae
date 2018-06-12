<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Orders extends Model
{
	protected $table = "orders";
	protected $primaryKey = "orderID";
	protected $fillable = array('customerID','billingID','orderNumber','shippingID','grandTotal','subTotal','shippingMethod','shippingTotal','discount','orderStatus','paymentMethod'
,'discountCouponID','orderTypeID','tax','eventType');
	
	public function getAllorder()
	{
		$orderNumber=Input::get('srach_orderNumber')?Input::get('srach_orderNumber'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('orders');

		$query->select('orders.*','order_details.*','orderstatus.*','customer.firstName','customer.lastName');

		if( strlen($orderNumber) )
		{
			$query->where('orders.orderNumber','LIKE',trim($orderNumber).'%');
		}
		if(strlen(trim($srch_status)) > 0)
		{
			$query->where('orders.orderStatus',$srch_status);
		}
		if(session()->get('admin_role')!=1){
			$query->where('orders.customerID',session()->get('customerID'));
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('orders.created_at', array($startDate,$endDate));
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('orders.created_at', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$query->join('order_details','order_details.orderID','=','orders.orderID');
		$query->join('orderstatus','orders.orderStatus','=','orderstatus.orderstatusID');
		$query->join('customer','customer.customerID','=','orders.customerID');

		$getAllOrder=$query->paginate(10);  //With Pagination
		//$getAllOrder=$query->get();      //Without Pagination
	    //echo $getAllOrder=$query->toSql();	 //For Query print
		
		$result['data']=$getAllOrder;
		$result['rows']=count($getAllOrder);
		return $result;
	}

	function getByAttributesQuery($data)
    {
		$query = DB::table('orders');

		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('orders.*','orderstatus.*','order_details.*','order_details.email as orderEmail','product.productID','product.productName','product.url_title','product.createdBy','product.price','product_size.unpaidOption','customer.firstName','customer.lastName','customer.email');
		}
		if(isset($data['orderID']) && strlen(trim($data['orderID'])) > 0)
		{
			$query->where('orders.orderID',$data['orderID']);
		}
		if(isset($data['customerID']) && strlen(trim($data['customerID'])) > 0)
		{
			$query->where('orders.customerID',$data['customerID']);
		}
		if(isset($data['billingID']) && strlen(trim($data['billingID'])) > 0)
		{
			$query->where('orders.billingID',$data['billingID']);
		}
		if(isset($data['md5(orderNumber)']) && strlen(trim($data['md5(orderNumber)'])) > 0)
		{
			$query->where('md5(orders.orderNumber)',$data['md5(orderNumber)']);
		}
		if(isset($data['orderNumber']) && strlen(trim($data['orderNumber'])) > 0)
		{
			$query->where('orders.orderNumber',$data['orderNumber']);
		}
		if(isset($data['shippingID']) && strlen(trim($data['shippingID'])) > 0)
		{
			$query->where('orders.shippingID',$data['shippingID']);
		}
		if(isset($data['grandTotal']) && strlen(trim($data['grandTotal'])) > 0)
		{
			$query->where('orders.grandTotal',$data['grandTotal']);
		}
		if(isset($data['subTotal']) && strlen(trim($data['subTotal'])) > 0)
		{
			$query->where('orders.subTotal',$data['subTotal']);
		}
		if(isset($data['shippingMethod']) && strlen(trim($data['shippingMethod'])) > 0)
		{
			$query->where('orders.shippingMethod',$data['shippingMethod']);
		}
		if(isset($data['shippingTotal']) && strlen(trim($data['shippingTotal'])) > 0)
		{
			$query->where('orders.shippingTotal',$data['shippingTotal']);
		}
		if(isset($data['discount']) && strlen(trim($data['discount'])) > 0)
		{
			$query->where('orders.discount',$data['discount']);
		}
		if(isset($data['orderStatus']) && strlen(trim($data['orderStatus'])) > 0)
		{
			$query->where('orders.orderStatus',$data['orderStatus']);
		}
		if(isset($data['paymentMethod']) && strlen(trim($data['paymentMethod'])) > 0)
		{
			$query->where('orders.paymentMethod',$data['paymentMethod']);
		}
		if(isset($data['discountCouponID']) && strlen(trim($data['discountCouponID'])) > 0)
		{
			$query->where('orders.discountCouponID',$data['discountCouponID']);
		}
		if(isset($data['orderTypeID']) && strlen(trim($data['orderTypeID'])) > 0)
		{
			$query->where('orders.orderTypeID',$data['orderTypeID']);
		}
		if(isset($data['tax']) && strlen(trim($data['tax'])) > 0)
		{
			$query->where('orders.tax',$data['tax']);
		}
		
		if(isset($data['productID']) && strlen(trim($data['productID'])) > 0)
		{
			$query->where('order_details.productID',$data['productID']);
		}
		if(isset($data['eventType']) && strlen($data['eventType']) > 0)
        {
            $query->where('orders.eventType',$data['eventType']);
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('orders.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('orders.updated_at',$data['updated_at']);
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
		
		$query->join('order_details','order_details.orderID','=','orders.orderID');
		$query->join('orderstatus','orders.orderStatus','=','orderstatus.orderstatusID');
		$query->join('product','product.productID','=','order_details.productID');
		$query->join('product_size','product_size.sizeID','=','order_details.sizeID');
		$query->join('customer','customer.customerID','=','orders.customerID');

		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }

		$result['recordCount'] = count($result['data']);
        return $result;
    }

	function getCardDataWithPrice($data)
    {
        
		$query = DB::table('orders');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('orders.*','product.productID','product.productName','product.prodcutImage','product.itemnumber','product.url_title','product_size.sizeID','product_size.sizeName','product_price.quantity as sizeQuantity','order_details.orderDetailsID','order_details.product_quantity','product_price.price');
		}
		if(isset($data['orderID']) && strlen(trim($data['orderID'])) > 0)
		{
			$query->where('orders.orderID',$data['orderID']);
		}
		if(isset($data['customerID']) && strlen(trim($data['customerID'])) > 0)
		{
			$query->where('orders.customerID',$data['customerID']);
		}
		if(isset($data['billingID']) && strlen(trim($data['billingID'])) > 0)
		{
			$query->where('orders.billingID',$data['billingID']);
		}
		if(isset($data['md5(orderNumber)']) && strlen(trim($data['md5(orderNumber)'])) > 0)
		{
			$query->where('md5(orders.orderNumber)',$data['md5(orderNumber)']);
		}
		if(isset($data['orderNumber']) && strlen(trim($data['orderNumber'])) > 0)
		{
			$query->where('orders.orderNumber',$data['orderNumber']);
		}
		if(isset($data['shippingID']) && strlen(trim($data['shippingID'])) > 0)
		{
			$query->where('orders.shippingID',$data['shippingID']);
		}
		if(isset($data['grandTotal']) && strlen(trim($data['grandTotal'])) > 0)
		{
			$query->where('orders.grandTotal',$data['grandTotal']);
		}
		if(isset($data['subTotal']) && strlen(trim($data['subTotal'])) > 0)
		{
			$query->where('orders.subTotal',$data['subTotal']);
		}
		if(isset($data['shippingMethod']) && strlen(trim($data['shippingMethod'])) > 0)
		{
			$query->where('orders.shippingMethod',$data['shippingMethod']);
		}
		if(isset($data['shippingTotal']) && strlen(trim($data['shippingTotal'])) > 0)
		{
			$query->where('orders.shippingTotal',$data['shippingTotal']);
		}
		if(isset($data['discount']) && strlen(trim($data['discount'])) > 0)
		{
			$query->where('orders.discount',$data['discount']);
		}
		if(isset($data['orderStatus']) && strlen(trim($data['orderStatus'])) > 0)
		{
			$query->where('orders.orderStatus',$data['orderStatus']);
		}
		if(isset($data['paymentMethod']) && strlen(trim($data['paymentMethod'])) > 0)
		{
			$query->where('orders.paymentMethod',$data['paymentMethod']);
		}
		if(isset($data['discountCouponID']) && strlen(trim($data['discountCouponID'])) > 0)
		{
			$query->where('orders.discountCouponID',$data['discountCouponID']);
		}
		if(isset($data['orderTypeID']) && strlen(trim($data['orderTypeID'])) > 0)
		{
			$query->where('orders.orderTypeID',$data['orderTypeID']);
		}
		if(isset($data['tax']) && strlen(trim($data['tax'])) > 0)
		{
			$query->where('orders.tax',$data['tax']);
		}
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('orders.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('orders.updated_at',$data['updated_at']);
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

		$query->join('order_details','order_details.orderID','=','orders.orderID');
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
