<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Emaiinstantresponse extends Model
{
	protected $table = "emaiinstantresponse";
	protected $primaryKey = "emailInstantID";
	protected $fillable = array('formID','messageInst');
	
	public function getAllEmaiinstantresponse()
	{
		
	}

	public function getByAttributesQuery($data){

		$query = DB::table('emailautoresponse');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('emailautoresponse.*');
		}
		if(isset($data['emailInstantID']) && strlen($data['emailInstantID']) > 0)
		{
			$query->where('emailautoresponse.emailInstantID',intval($data['emailInstantID']));
		}
		if(isset($data['formID']) && strlen($data['formID']) > 0)
		{
			$query->where('emailautoresponse.formID',intval($data['formID']));
		}
		if(isset($data['messageInst']) && strlen($data['messageInst']) > 0)
		{
			$query->where('emailautoresponse.messageInst',trim($data['messageInst']));
		}
		if(isset($data['created_at']) && strlen($data['created_at']) > 0)
		{
			$query->where('emailautoresponse.created_at',trim($data['created_at']));
		}
		if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
		{
			$query->where('emailautoresponse.updated_at',trim($data['updated_at']));
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
