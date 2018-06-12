<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class States extends Model
{
	protected $table = "states";
	protected $primaryKey = "stateID";
	protected $fillable = array('stateName','country_id');
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('states');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('states.*');
		}

		if(isset($data['stateID']) && strlen(trim($data['stateID'])) > 0)
		{
			$query->where('states.stateID',$data['stateID']);
		}
		if(isset($data['stateName']) && strlen(trim($data['stateName'])) > 0)
		{
			$query->where('states.stateName',$data['stateName']);
		}
		if(isset($data['country_id']) && strlen(trim($data['country_id'])) > 0)
		{
			$query->where('states.country_id',$data['country_id']);
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
		//$query->leftJoin('statescategory','states.statesID','=','statescategory.statesID');
		//$query->leftJoin('category','category.categoryID','=','statescategory.categoryID');

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
