<?php 

	use Illuminate\Http\Request;
	use Illuminate\Foundation\Bus\DispatchesJobs;
	use Illuminate\Routing\Controller as BaseController;
	use Illuminate\Foundation\Validation\ValidatesRequests;
	use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
	use Illuminate\Foundation\Auth\Access\AuthorizesResources;
	use Illuminate\Support\Facades\Redirect;
	use Session;
	use DB;
	use App\Http\Models\Pages;
	use App\Http\Models\Slideshow;
	use App\Http\Models\Category_model;
	use App\Http\Models\Categorytype;
	use App\Http\Models\Product;
	


	/*======================================*/
	//  for slideshow  [START]	    //
	/*======================================*/
	$Slideshow= new Slideshow;
	$slideshowData=array(
						'isActive'=>1,
						'orderBy'=>'displayOrder'
						);
	$slideshowResult=$Slideshow->getByAttributesQuery($slideshowData);
	$data['qGetSlideshowResult'] = $slideshowResult['data'];
	$data['SlideshowRecordCount'] = $slideshowResult['recordCount'];
	/*======================================*/
	//  for slideshow  [END]	    //
	/*======================================*/
	
	/*======================================*/
	//  for Product Category  [START]	    //
	/*======================================*/
	$Category= new Category_model;
	$productCategoryData=array(
						'categorytypeID'=>Config::get('config.productCategorytypeID','3'),
						'isFeatured'=>1,
						'isActive'=>1,
						'orderBy'=>'displayOrder'
						);

	$productCategoryResult=$Category->getByAttributesQuery($productCategoryData);
	////dd($productCategoryResult);
	$data['qGetProductCategoryResult'] = $productCategoryResult['data'];
	$data['ProductCategoryRecordCount'] = $productCategoryResult['recordCount'];
	/*======================================*/
	//  for Product Category  [END]	    //
	/*======================================*/

	/*======================================*/
	//  for Product  [START]	    //
	/*======================================*/
	$Product= new Product;
	$productData=array( 'isFeatured'=>1,
						'isActive'=>1,
						'orderBy'=>'displayOrder'
						);

	$productResult=$Product->getByAttributesQuery($productData);
	$data['qGetProductResult'] = $productResult['data'];
	$data['ProductRecordCount'] = $productResult['recordCount'];

	/*======================================*/
	//  for Product [END]	    //
	/*======================================*/

	
	
?>