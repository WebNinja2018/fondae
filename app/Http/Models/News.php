<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class News extends Model
{
	protected $table = "news";
	protected $primaryKey = "newsID";
	protected $fillable = array('newsID','categoryID','newsTitle','newsDate','author','summary','body','imgFileName_news', 'weblink', 'pageTitle', 'metaKeyword', 'description', 'featured', 'isActive', 'displayOrder', 'display', 'createdBy', 'url_title');
	
	public function getAllNews()
	{
		$newsTitle=Input::get('srach_newsTitle')?Input::get('srach_newsTitle'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('news');
		if( strlen($newsTitle) )
		{
			$query->where('newsTitle','LIKE',trim($newsTitle).'%');
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
		
		$getAllNews=$query->paginate(10);  //With Pagination
		//$getAllNews=$query->get();      //Without Pagination
	    //echo $getAllNews=$query->toSql();	 //For Query print
		
		$result['data']=$getAllNews;
		$result['rows']=count($getAllNews);
		return $result;
	}

	function getByAttributesQuery($data)
    {
        
		$query = DB::table('news');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('news.*','category.urlName','category.categoryName');
		}
        if(isset($data['newsID']) && strlen(trim($data['newsID'])) > 0)
        {
            $query->where('news.newsID',intval($data['newsID']));
        }
		if(isset($data['categoryID']) && strlen(trim($data['categoryID'])) > 0)
        {
            $query->where('news.categoryID',intval($data['categoryID']));
        }
        if(isset($data['newsTitle']) && strlen(trim($data['newsTitle'])) > 0)
        {
			$query->where('news.newsTitle',trim($data['newsTitle']));
        }
        if(isset($data['newsDate']) && strlen(trim($data['newsDate'])) > 0)
        {
			$query->where('news.newsDate',trim($data['newsDate']));
        }
        if(isset($data['author']) && strlen(trim($data['author'])) > 0)
        {
            $query->where('news.author',trim($data['author']));
        }
        if(isset($data['summary']) && strlen(trim($data['summary'])) > 0)
        {
            $query->where('news.summary',trim($data['summary']));
        }
        if(isset($data['body']) && strlen(trim($data['body'])) > 0)
        {
            $query->where('news.body',trim($data['body']));
        }
        if(isset($data['imgFileName_news']) && strlen(trim($data['imgFileName_news'])) > 0)
        {
            $query->where('news.imgFileName_news',trim($data['imgFileName_news']));
        }
		if(isset($data['weblink']) && strlen(trim($data['weblink'])) > 0)
        {
            $query->where('news.weblink',trim($data['weblink']));
        }
		if(isset($data['pageTitle']) && strlen(trim($data['pageTitle'])) > 0)
        {
            $query->where('news.pageTitle',trim($data['pageTitle']));
        }
		if(isset($data['metaKeyword']) && strlen(trim($data['metaKeyword'])) > 0)
        {
            $query->where('news.metaKeyword',trim($data['metaKeyword']));
        }
		if(isset($data['description']) && strlen(trim($data['description'])) > 0)
        {
            $query->where('news.description',trim($data['description']));
        }
        if(isset($data['featured']) && strlen($data['featured']) > 0)
        {
             $query->where('news.featured',intval($data['featured']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('news.isActive',intval($data['isActive']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('news.displayOrder',intval($data['displayOrder']));
        }
        if(isset($data['display']) && strlen($data['display']) > 0)
        {
            $query->where('news.display',intval($data['display']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('news.createdBy',intval($data['createdBy']));
        }
        if(isset($data['url_title']) && strlen(trim($data['url_title'])) > 0)
        {
           $query->where('news.url_title',trim($data['url_title']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('news.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('news.updated_at',$data['updated_at']);
        }
		if(isset($data['newsCategoryUrlName']) && strlen(trim($data['newsCategoryUrlName'])) > 0)
		{
			$query->where('category.urlName',$data['newsCategoryUrlName']);
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
		$query->join('newscategory','news.newsID','=','newscategory.newsID');
		$query->leftJoin('category','category.categoryID','=','newscategory.categoryID');	
		
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
