<?php
	
	use App\Http\Models\Product;

	//Get Search Result Start 
	$Product= new Product;
	$srchByKeyword=$request->srchByKeyword?$request->srchByKeyword:'';
	
	if(strlen(trim($srchByKeyword)) > 0)
	{
		$productData=array(	
								'srachProductName'=>$srchByKeyword,
								'isActive'=>1,
								'groupBy'=>'product.productID',
								'orderBy'=>'product.productDate',
								'order'=>'DESC',
								'paginate'=>6 
							); 
		
		$productResult=$Product->getByAttributesQuery($productData);
		$data['qGetProductResult'] = $productResult['data'];
		$data['ProductRecordCount'] = $productResult['recordCount'];
	}else{
		$data['qGetProductResult'] = '';
		$data['ProductRecordCount'] = 0;
	}
	//Get Search Result End 
?>