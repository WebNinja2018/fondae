<?php

	use App\Http\Models\News;
	use App\Http\Models\Images;

	//Get News Result start 
	$News= new News;
	$newsData=array('url_title'=>$urlName,'isActive'=>1);
	$resultNews=$News->getByAttributesQuery($newsData);   
	$data['qGetNewsDetailData']=$resultNews['data'];
	if($resultNews['recordCount']==0){
		return Redirect::fun_redirect(url('/'));
	}

	//To fetch data from images model Start
	$Images= new Images;
	$newsID=$data['qGetNewsDetailData'][0]->newsID;
	$imageData=array('itemID'=>$newsID,
					 'imagesTypeID'=>Config::get('config.newsImageTypeID','2'),
					 'isActive'=>1,
					 'orderBy'=>'displayOrder'
					);
	$resultImages=$Images->getByAttributesQuery($imageData);
	$data['qGetImages']=$resultImages['data'];
	$data['imageCount']=$resultImages['recordCount'];
?>