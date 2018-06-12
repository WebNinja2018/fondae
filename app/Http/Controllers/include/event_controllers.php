<?php

	use App\Http\Models\Product;
	use App\Http\Models\Product_size;
	use App\Http\Models\Product_price;
	
	
	//Get Portfolio Result start 
	$Product= new Product;
	$productData=array('url_title'=>$urlName,'isActive'=>1);
	$productResult=$Product->getByAttributesQuery($productData); 
	$data['qGetProductResult']=$productResult['data'];	
	
	
	////To fetch data from size model Start
//	$Product_size= new Product_size;
//	$productID=$data['qGetProductResult'][0]->productID;
//	$sizeData=array('productID'=>$productID,
//					 'isActive'=>1
//					);
//	//$resultSize=$Product_size->getByAttributesQuery($sizeData);
//	//$data['qGetSize']=$resultSize['data'];
//	//$data['sizeCount']=$resultSize['recordCount'];
//	$resultSize=$Product_size->where($sizeData)->get();
//	$data['qGetSize']=$resultSize;
//	$data['sizeCount']=count($resultSize);

	//To fetch data from size with price Product_price model [Start]
	$Product_price= new Product_price;
	$productID=$data['qGetProductResult'][0]->productID;
	$sizeData=array('productID'=>$productID,
					 'isActive'=>1,
					 'orderBy'=>'product_size.eventType',
					 'order'=>'DESC'
					);
	$resultSize=$Product_price->getByAttributesQuery($sizeData);
	$data['qGetSize']=$resultSize['data'];
	$data['sizeCount']=$resultSize['recordCount'];



	////To fetch data from images model Start
//	$Images= new Images;
//	$productID=$data['qGetProductResult'][0]->productID;
//	$imageData=array('itemID'=>$productID,
//					 'imagesTypeID'=>Config::get('config.portfolioImageTypeID','3'),
//					 'isActive'=>1,
//					 'orderBy'=>'displayOrder'
//	);
//	$resultImages=$Images->getByAttributesQuery($imageData);
//	$data['qGetImages']=$resultImages['data'];
//	$data['imageCount']=$resultImages['recordCount'];
	
	if($productResult['recordCount']==0 ){
		return Redirect::fun_redirect(url('/'));
	}
?>