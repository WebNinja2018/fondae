<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Faq extends Model
{
	protected $table = "faq";
	protected $primaryKey = "faqID";
	protected $fillable = array('faqID','question','answer','displayOrder', 'isActive', 'createdBy','site_url');
	
	public function getAllFaq()
	{
		$question=Input::get('srach_question')?Input::get('srach_question'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		
		$query = DB::table('faq');
		if( strlen($question) )
		{
			$query->where('question','LIKE','%'.trim($question).'%');
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
			$query->orderBy('faqID', 'DESC');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
	
		$getAllFaq=$query->paginate(10);  //With Pagination
		//$getAllFaq=$query->get();      //Without Pagination
	    //echo $getAllFaq=$query->toSql();	 //For Query print
		
		$result['data']=$getAllFaq;
		$result['rows']=count($getAllFaq);
		return $result;
	}

	function getByAttributesQuery($data)
    {
        
		$query = DB::table('faq');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('faq.*');
		}
        if(isset($data['faqID']) && strlen(trim($data['faqID'])) > 0)
        {
            $query->where('faq.faqID',intval($data['faqID']));
        }
        if(isset($data['question']) && strlen(trim($data['question'])) > 0)
        {
			$query->where('faq.question',trim($data['question']));
        }
        if(isset($data['answer']) && strlen(trim($data['answer'])) > 0)
        {
			$query->where('faq.answer',trim($data['answer']));
        }
        if(isset($data['isActive']) && strlen($data['isActive']) > 0)
        {
            $query->where('faq.isActive',intval($data['isActive']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('faq.displayOrder',intval($data['displayOrder']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('faq.createdBy',intval($data['createdBy']));
        }
        if(isset($data['site_url']) && strlen(trim($data['site_url'])) > 0)
        {
           $query->where('faq.site_url',trim($data['site_url']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('faq.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('faq.updated_at',$data['updated_at']);
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
