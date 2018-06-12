<?php

	use App\Http\Models\Category_model;
	use App\Http\Models\Portfolio;

	//portfolio-category start 
	$Category= new Category_model;
	$portfolioCategoryUrlName = $urlName;
	$portfoliocategoryData=array(
		'categorytypeID'=>Config::get('config.portfolioCategorytypeID','5'),
		'isActive'=>1,
		);	
	$resultPortfolioCategory=$Category->getByAttributesQuery($portfoliocategoryData);       
	$data['portfolioCategoryRecordCount']=$resultPortfolioCategory['recordCount'];				
	$data['qGetPortfolioCategoryData']=$resultPortfolioCategory['data'];	
	//portfolio-category end 
	
	//Get Portfolio Result start 
	$Portfolio= new Portfolio;
	$portfolioData=array(
						'isActive'=>1,
						'portfolioCategoryUrlName'=>$portfolioCategoryUrlName,
						'orderBy'=>'portfolio.displayorder',
						'groupBy'=>'portfolio.portfolioID',
						'categoryisActive'=>1,
						'paginate'=>12,
						); 

	$resultPortfolio=$Portfolio->getByAttributesQuery($portfolioData);
	$data['qGetAllPortfolio']=$resultPortfolio['data'];
	$data['portfolioRecordCount']=$resultPortfolio['recordCount'];
	$data['portfolioCategory']=$portfolioCategoryUrlName;
	//Get Portfolio Result End 
?>