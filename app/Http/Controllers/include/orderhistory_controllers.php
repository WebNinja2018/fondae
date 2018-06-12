<?php
	
	use App\Http\Models\Orders;

	//Get Product Result Start 
	$Orders= new Orders;
	$orderNumber=$request->searchOrder?$request->searchOrder:'';
	$orderDate = $request->orderDate? date('Y-m-d',strtotime($request->orderDate)):'';
	$orderData=array(	
						'customerID'=>$customerID,
						'orderNumber'=>trim($orderNumber),
						'created_at'=>$orderDate,
						'orderBy'=>'orders.created_at',
						'order'=>'DESC',
						'groupBy'=>'orders.orderID',
						'paginate'=>10 
					  ); 

	$getAllOrderResult=$Orders->getByAttributesQuery($orderData);
	$data['orderRecordCount']=$getAllOrderResult['recordCount'];
	$data['qGetOrderlist']=$getAllOrderResult['data'];
	//Get Product Result End 
?>