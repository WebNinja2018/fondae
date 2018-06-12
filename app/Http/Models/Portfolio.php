<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Portfolio extends Model
{
	protected $table = "portfolio";
	protected $primaryKey = "portfolioID";
	protected $fillable = array('categoryID','portfolioTitle','body','imgFileName_portfolio', 'pageTitle', 'metaKeyword', 'description', 'featured', 'isActive', 'displayOrder', 'display', 'createdBy', 'url_title');
	
	public function getAllPortfolio()
	{
		$portfolioTitle=Input::get('srach_portfolioTitle')?Input::get('srach_portfolioTitle'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('portfolio');
		if( strlen($portfolioTitle) )
		{
			$query->where('portfolioTitle','LIKE',trim($portfolioTitle).'%');
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('created_at', array($startDate,$endDate));
		}
		if(strlen($srch_status)>0)
		{
			$query->where('isActive',$srch_status);
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('created_at', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllPortfolio=$query->paginate(10);  //With Pagination
		//$getAllPortfolio=$query->get();      //Without Pagination
	    //echo $getAllPortfolio=$query->toSql();	 //For Query print
		
		$result['data']=$getAllPortfolio;
		$result['rows']=count($getAllPortfolio);
		return $result;
	}
	function getByAttributesQuery($data)
    {
        
		$query = DB::table('portfolio');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('portfolio.*','category.urlName','category.categoryID','category.categoryName');
		}
        if(isset($data['portfolioID']) && strlen(trim($data['portfolioID'])) > 0)
        {
            $query->where('portfolio.portfolioID',intval($data['portfolioID']));
        }
        if(isset($data['portfolioTitle']) && strlen(trim($data['portfolioTitle'])) > 0)
        {
			$query->where('portfolio.portfolioTitle',trim($data['portfolioTitle']));
        }
        if(isset($data['body']) && strlen(trim($data['body'])) > 0)
        {
			$query->where('portfolio.body',trim($data['body']));
        }
        if(isset($data['pageTitle']) && strlen(trim($data['pageTitle'])) > 0)
        {
            $query->where('portfolio.pageTitle',trim($data['pageTitle']));
        }
        if(isset($data['description']) && strlen(trim($data['description'])) > 0)
        {
            $query->where('portfolio.description',trim($data['description']));
        }
        if(isset($data['metaKeyword']) && strlen(trim($data['metaKeyword'])) > 0)
        {
            $query->where('portfolio.metaKeyword',trim($data['metaKeyword']));
        }
        if(isset($data['imgFileName_portfolio']) && strlen(trim($data['imgFileName_portfolio'])) > 0)
        {
            $query->where('portfolio.imgFileName_portfolio',trim($data['imgFileName_portfolio']));
        }
        if(isset($data['featured']) && strlen($data['featured']) > 0)
        {
             $query->where('portfolio.featured',intval($data['featured']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('portfolio.isActive',intval($data['isActive']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('portfolio.displayOrder',intval($data['displayOrder']));
        }
        if(isset($data['display']) && strlen($data['display']) > 0)
        {
            $query->where('portfolio.display',intval($data['display']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('portfolio.createdBy',intval($data['createdBy']));
        }
        if(isset($data['url_title']) && strlen(trim($data['url_title'])) > 0)
        {
           $query->where('portfolio.url_title',trim($data['url_title']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('portfolio.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('portfolio.updated_at',$data['updated_at']);
        }
		if(isset($data['categoryisActive']) && strlen(trim($data['categoryisActive'])) > 0)
		{
			$query->where('category.isActive',$data['categoryisActive']);
		}
        if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
        {
			if(isset($data['order']) && strlen(trim($data['order'])) > 0)
			{
           		$query->orderBy($data['orderBy'],$data['order']);
        	}else{
				$query->orderBy($data['orderBy']);
			}
		}
        if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
        {
            $query->groupBy($data['groupBy']);
        }
		if(isset($data['portfolioCategoryUrlName']) && strlen(trim($data['portfolioCategoryUrlName'])) > 0)
		{
			$query->where('category.urlName',$data['portfolioCategoryUrlName']);
		}
		$query->join('portfoliocategory','portfolio.portfolioID','=','portfoliocategory.portfolioID');
		$query->leftJoin('category','category.categoryID','=','portfoliocategory.categoryID');
		
		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }
		
		$result['recordCount'] = count($result['data']);
        return $result;
    }
	
	
}
