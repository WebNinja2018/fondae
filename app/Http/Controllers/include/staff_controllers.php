<?php 

	use App\Http\Models\Category_model;
	use App\Http\Models\Staff;
	use App\Http\Models\Product_staff;
	
	$Category= new Category_model;
	$staffCategoryUrlName = $urlName; 
	$staffCategoryData=array(
		'categorytypeID'=>Config::get('config.staffCategorytypeID','10'),
		'isActive'=>1,
		'orderBy'=>'displayOrder',
		);
	$resultStaffCategory=$Category->getByAttributesQuery($staffCategoryData);    
	$data['staffCategoryRecordCount']=$resultStaffCategory['recordCount'];				
	$data['qGetStaffCategoryData']=$resultStaffCategory['data'];	
	
	//Get Staff Result
	$Staff= new Staff;
	$staffData=array(
		'isActive'=>1,
		'staffCategoryUrlName'=>$staffCategoryUrlName,
		'groupBy'=>'staff.staffID',
		'orderBy'=>'staff.displayOrder',
		'categoryisActive'=>1,
		'paginate'=>12
	); 
	$resultStaff=$Staff->getByAttributesQuery($staffData);
	$data['staffRecordCount']=$resultStaff['recordCount'];					//Staff Record with LIMIT Query.
	$data['qGetStaffData']=$resultStaff['data'];	
	$data['staffCategory']=$staffCategoryUrlName;

?>