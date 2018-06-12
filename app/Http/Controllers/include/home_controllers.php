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
	
	use App\Http\Models\Portfolio;
	


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
	$ip = $_SERVER['REMOTE_ADDR'];
	$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
	if(strlen($details->city)>0){$city=$details->city;}else{$city='';}
	/*======================================*/
	//  for Near Product  [START]	    //
	/*======================================*/
	$Product= new Product;
	//echo $city;
	$nearproductData=array( 
						//'city'=>$city,
						'isActive'=>1,
						'featured_page'=>'1',
						);

	$nearproductResult=$Product->getByAttributesQuery($nearproductData);
	$data['qGetnearProductResult'] = $nearproductResult['data'];
	$data['nearProductRecordCount'] = $nearproductResult['recordCount'];

	/*======================================*/
	//  for Near Product [END]	    //
	/*======================================*/
	
	/*======================================*/
	//  for Featured Product  [START]	    //
	/*======================================*/
	$Product= new Product;
	//echo $city;
	$nearproductData=array( 
						//'city'=>$city,
						'isActive'=>1,
						'paginate'=>3,
						'staff_pics_page'=>'1',
						);

	$nearproductResult=$Product->getByAttributesQuery($nearproductData);
	$data['staffpicsProductResult'] = $nearproductResult['data'];
	$data['staffpicsProductRecordCount'] = $nearproductResult['recordCount'];

	/*======================================*/
	//  for what is popular sections	    //
	/*======================================*/
	$Product= new Product;
	
	$nearproductData=array( 
						//'city'=>$city,
						'isActive'=>1,
						'paginate'=>3,
						'popular_page'=>'1',
						);

	$nearproductResult=$Product->getByAttributesQuery($nearproductData);
	$data['popularProductResult'] = $nearproductResult['data'];
	$data['popularProductRecordCount'] = $nearproductResult['recordCount'];
	
?>