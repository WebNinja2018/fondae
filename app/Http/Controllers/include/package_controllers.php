<?php
	
	use App\Http\Models\Product;

	//Get Product Result Start 
	$Product= new Product;
	
	$productData=array(	
							'categorytypeID'=>Config::get('config.packageCategorytypeID','12'),
							'isActive'=>1,
							// 'productExpiredDate'=>'Check',
							'groupBy'=>'product.productID',
							'orderBy'=>'product.displayOrder',
							'order'=>'ASC',
							'paginate'=>8 
						); 
	//dd($productData);
	$productResult=$Product->getByAttributesQuery($productData);
	$data['qGetProductResult'] = $productResult['data'];
	$data['ProductRecordCount'] = $productResult['recordCount'];
	//Get Product Result End 
?>