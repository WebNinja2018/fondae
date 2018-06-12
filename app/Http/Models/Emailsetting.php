<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Emailsetting extends Model
{
	protected $table = "emailsetting";
	protected $primaryKey = "emailID";
	protected $fillable = array('formID','email','emailType','createdBy','isActive');
	
	public function getAllEmailsetting()
	{
		
	}
	
	public function getByAttributesQuery($data){

		$query = DB::table('emailsetting');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('emailsetting.*');
		}
		if(isset($data['emailID']) && strlen($data['emailID']) > 0)
		{
			$query->where('emailsetting.emailID',intval($data['emailID']));
		}
		if(isset($data['formID']) && strlen($data['formID']) > 0)
		{
			$query->where('emailsetting.formID',intval($data['formID']));
		}
		if(isset($data['email']) && strlen($data['email']) > 0)
		{
			$query->where('emailsetting.email',trim($data['email']));
		}
		if(isset($data['emailType']) && strlen($data['emailType']) > 0)
		{
			$query->where('emailsetting.emailType',intval($data['emailType']));
		}
		if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
		{
			$query->where('emailsetting.createdBy',intval($data['createdBy']));
		}
		if(isset($data['isActive']) && strlen($data['isActive']) > 0)
		{
			$query->where('emailsetting.isActive',intval($data['isActive']));
		}
		if(isset($data['created_at']) && strlen($data['created_at']) > 0)
		{
			$query->where('emailsetting.created_at',trim($data['created_at']));
		}
		if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
		{
			$query->where('emailsetting.updated_at',trim($data['updated_at']));
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
		$result['recordCount']=count($result['data']);
		return $result;
	}
}
