<?php
	
	use App\Http\Models\Category_model;
	use App\Http\Models\News;

	//News-category start 
	
	$newsCategoryData=array(
		'categorytypeID'=>Config::get('config.newsCategorytypeID','1'),
		'isActive'=>1
		);	
	$Category= new Category_model;
	$resultNewsCategory=$Category->getByAttributesQuery($newsCategoryData);       
	$data['newsCategoryRecordCount']=$resultNewsCategory['recordCount'];				
	$data['qGetNewsCategoryData']=$resultNewsCategory['data'];	
	//News-category end 	
	
	//Get News Result Start 
	$News= new News;
	$newsData=array(
			'newsCategoryUrlName'=>$urlName,
			'isActive'=>1,
			'groupBy'=>'news.newsID',
			'orderBy'=>'news.newsDate',
			'order'=>'DESC',
			'categoryisActive'=>1,
			'paginate'=>12 
		); 
	$resultNews=$News->getByAttributesQuery($newsData);   
	$data['newsTotalCount']=$resultNews['recordCount'];				
	$data['qGetNewsData']=$resultNews['data'];
	$data['newsCategory']=$urlName;
	//Get News Result End 
?>