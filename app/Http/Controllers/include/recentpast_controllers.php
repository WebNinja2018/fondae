<?php

	use App\Http\Models\Product;
	use App\Http\Models\Product_size;
	use App\Http\Models\Product_price;
	
	//Get Portfolio Result start 
	$Product= new Product;
	$productCategoryUrlName=$urlName?$urlName:'';
	$productData=array('isActive'=>1,'paginate'=>10,'productCategoryUrlName'=>$productCategoryUrlName);
	$productResult=$Product->getByAttributesQuery($productData); 
	$data['qGetProductResult']=$productResult['data'];	
	
	if($productResult['recordCount']==0 ){
		//return Redirect::fun_redirect(url('/'));
	}
?>