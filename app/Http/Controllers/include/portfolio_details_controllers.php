<?php

	use App\Http\Models\Portfolio;
	use App\Http\Models\Images;

	//Get Portfolio Result start 
	$Portfolio= new Portfolio;
	$portfolioData=array('url_title'=>$urlName,'isActive'=>1);
	$resultPortfolio=$Portfolio->getByAttributesQuery($portfolioData); 
	$data['qGetPortfolioDetail']=$resultPortfolio['data'];	
	
	if($resultPortfolio['recordCount']==0){
		return Redirect::fun_redirect(url('/'));
	}
		
	//To fetch data from images model Start
	$Images= new Images;
	$portfolioID=$data['qGetPortfolioDetail'][0]->portfolioID;
	$imageData=array('itemID'=>$portfolioID,
					 'imagesTypeID'=>Config::get('config.portfolioImageTypeID','3'),
					 'isActive'=>1,
					 'orderBy'=>'displayOrder'
	);
	$resultImages=$Images->getByAttributesQuery($imageData);
	$data['qGetImages']=$resultImages['data'];
	$data['imageCount']=$resultImages['recordCount'];

?>