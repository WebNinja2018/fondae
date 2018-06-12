<?php
	
	use App\Http\Models\Product;

	//Get Product Result Start 
	$Product= new Product;
	
	if($urlName=='upcoming' || $urlName=='ondemand')
	{
		$category=$urlName;
		$productCategoryUrlName="";
	}elseif($urlName!=null){
		$category=$request->category;
		$productCategoryUrlName=$urlName;
	}else{
		$category=$request->category?$request->category:'upcoming';
		$productCategoryUrlName=$urlName;
	}	

	$productData=array(	
							'productCategoryUrlName'=>$productCategoryUrlName,
							'category'=>$category,
							'categorytypeID'=>Config::get('config.productCategorytypeID','3'),
							'isActive'=>1,
							'productExpiredDate'=>'Check',
							'groupBy'=>'product.productID',
							'orderBy'=>'product.productDate',
							'order'=>'ASC',
							'paginate'=>8 
						); 
	//dd($productData);
	$productResult=$Product->getByAttributesQuery($productData);
	$data['qGetProductResult'] = $productResult['data'];
	$data['ProductRecordCount'] = $productResult['recordCount'];
	//Get Product Result End 
?>