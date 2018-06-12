<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Adminemail extends Model
{
	protected $table = "adminemail";
	protected $primaryKey = "adminemailID";
	protected $fillable = array('formID','adminsubject','adminemail');
	
	public function getAllAdminemail()
	{
		
	}
	
	public function getByAttributesQuery($data){

		$query = DB::table('adminemail');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('adminemail.*');
		}
		if(isset($data['adminemailID']) && strlen($data['adminemailID']) > 0)
		{
			$query->where('adminemail.adminemailID',intval($data['adminemailID']));
		}
		if(isset($data['formID']) && strlen($data['formID']) > 0)
		{
			$query->where('adminemail.formID',intval($data['formID']));
		}
		if(isset($data['adminsubject']) && strlen($data['adminsubject']) > 0)
		{
			$query->where('adminemail.adminsubject',trim($data['adminsubject']));
		}
		if(isset($data['adminemail']) && strlen($data['adminemail']) > 0)
		{
			$query->where('adminemail.adminemail',trim($data['adminemail']));
		}
		if(isset($data['created_at']) && strlen($data['created_at']) > 0)
		{
			$query->where('adminemail.created_at',trim($data['created_at']));
		}
		if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
		{
			$query->where('adminemail.updated_at',trim($data['updated_at']));
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
