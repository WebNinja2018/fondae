<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Pages extends Model
{
	protected $table = "pages";
	protected $primaryKey = "pageID";
	protected $fillable = array('parentID','pageName','displayOrder','isActive','pageFileName','pageContentType','pageContent', 'pageTitle', 'pageMetaKeywords', 'pageMetaDescription' ,'pageSiteMap', 'createdBy', 'pageImage','customlink', 'pageImage' , 'pageType', 'pageLongDescription','frameID','targetType');
	
	public function getAllPages()
	{
		$srch_name=Input::get('srch_name')?Input::get('srch_name'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		$srch_pageID=Input::get('srch_pageID')?Input::get('srch_pageID'):'';
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('pages');
		if( strlen($srch_name) )
		{
			$query->where('pageName','LIKE',trim($srch_name).'%');
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('created_at', array($startDate,$endDate));
		}
		if(strlen($srch_pageID)>0)
		{
			$query->where('parentID',$srch_pageID);
		}
		if(strlen($srch_status)>0)
		{
			$query->where('isActive',$srch_status);
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('pageID', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		$getAllPages=$query->paginate(25);  //With Pagination
		//$getAllPages=$query->get();      //Without Pagination
	    //echo $getAllPages=$query->toSql();	 //For Query print
		
		$result['data']=$getAllPages;
		$result['rows']=count($getAllPages);
		return $result;
	}
	
	public function getByAttributesQuery($data){

		$query = DB::table('pages');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('pages.*', 'frames.frameName');
		}
		if(isset($data['pageID']) && strlen($data['pageID']) > 0)
		{
			$query->where('pages.pageID',intval($data['pageID']));
		}
		if(isset($data['parentID']) && strlen($data['parentID']) > 0)
		{
			$query->where('pages.parentID',intval($data['parentID']));
		}
		if(isset($data['pageName']) && strlen($data['pageName']) > 0)
		{
			$query->where('pages.pageName',trim($data['pageName']));
		}
		if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
		{
			$query->where('pages.displayOrder',intval($data['displayOrder']));
		}
		if(isset($data['isActive']) && strlen($data['isActive']) > 0)
		{
			$query->where('pages.isActive',intval($data['isActive']));
		}
		if(isset($data['pageFileName']) && strlen($data['pageFileName']) > 0)
		{
			$query->where('pages.pageFileName',trim($data['pageFileName']));
		}
		if(isset($data['pageContentType']) && strlen($data['pageContentType']) > 0)
		{
			$query->where('pages.pageContentType',intval($data['pageContentType']));
		}
		if(isset($data['pageContent']) && strlen($data['pageContent']) > 0)
		{
			$query->where('pages.pageContent',trim($data['pageContent']));
		}
		if(isset($data['pageTitle']) && strlen($data['pageTitle']) > 0)
		{
			$query->where('pages.pageTitle',trim($data['pageTitle']));
		}
		if(isset($data['pageMetaKeywords']) && strlen($data['pageMetaKeywords']) > 0)
		{
			$query->where('pages.pageMetaKeywords',trim($data['pageMetaKeywords']));
		}
		if(isset($data['pageMetaDescription']) && strlen($data['pageMetaDescription']) > 0)
		{
			$query->where('pages.pageMetaDescription',trim($data['pageMetaDescription']));
		}
		if(isset($data['pageSiteMap']) && strlen($data['pageSiteMap']) > 0)
		{
			$query->where('pages.pageSiteMap',trim($data['pageSiteMap']));
		}
		if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
		{
			$query->where('pages.createdBy',intval($data['createdBy']));
		}
		if(isset($data['pageImage']) && strlen($data['pageImage']) > 0)
		{
			$query->where('pages.pageImage',trim($data['pageImage']));
		}
		if(isset($data['pageType']) && strlen($data['pageType']) > 0)
		{
			$query->where('pages.pageType',intval($data['pageType']));
		}
		if(isset($data['customlink']) && strlen($data['customlink']) > 0)
		{
			$query->where('pages.customlink',trim($data['customlink']));
		}
		if(isset($data['pageLongDescription']) && strlen($data['pageLongDescription']) > 0)
		{
			$query->where('pages.pageLongDescription',trim($data['pageLongDescription']));
		}
		if(isset($data['isMainMenu']) && strlen($data['isMainMenu']) > 0)
		{
			$query->where('pages.isMainMenu',intval($data['isMainMenu']));
		}
		if(isset($data['frameID']) && strlen($data['frameID']) > 0)
		{
			$query->where('pages.frameID',intval($data['frameID']));
		}
		
		if(isset($data['targetType']) && strlen($data['targetType']) > 0)
		{
			$query->where('pages.targetType',intval($data['targetType']));
		}
		if(isset($data['created_at']) && strlen($data['created_at']) > 0)
		{
			$query->where('pages.created_at',trim($data['created_at']));
		}
		if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
		{
			$query->where('pages.updated_at',trim($data['updated_at']));
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
		$query->join('frames', 'pages.frameID', '=', 'frames.frameID');
		
		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }
		$result['recordCount']=count($result['data']);
		return $result;
	}
}
