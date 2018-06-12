<?php 

	use App\Http\Models\Staff;
	use App\Http\Models\Product_staff;
	
	$Staff= new Staff;
	$staffData=array('url_title'=>$urlName,'isActive'=>1);
	$resultStaff=$Staff->getByAttributesQuery($staffData); 
	
	$data['qGetStaffDetail']=$resultStaff['data'];	
	$data['recordCount']=$resultStaff['recordCount'];	
	$staffID=$data['qGetStaffDetail'][0]->staffID;
	if($resultStaff['recordCount']==0){
		return Redirect::fun_redirect(url('/'));
	}	
	
	//Get Product Staff Result
	$Product_staff= new Product_staff;
	$productData=array(
		'staffID'=>$staffID,
		'isActive'=>1,
		'orderBy'=>'product.displayOrder',
		'paginate'=>2
	); 
	$resultProduct=$Product_staff->getByAttributesQuery($productData);
	$data['productRecordCount']=$resultProduct['recordCount'];
	$data['qGetProductData']=$resultProduct['data'];	

?>