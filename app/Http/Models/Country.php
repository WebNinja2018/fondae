<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Country extends Model
{
	protected $table = "country";
	protected $primaryKey = "country_id";
	protected $fillable = array('country_name','sortName');
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('country');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('country.*');
		}

		if(isset($data['country_id']) && strlen(trim($data['country_id'])) > 0)
		{
			$query->where('country.country_id',$data['country_id']);
		}
		if(isset($data['country_name']) && strlen(trim($data['country_name'])) > 0)
		{
			$query->where('country.country_name',$data['country_name']);
		}
		if(isset($data['sortName']) && strlen(trim($data['sortName'])) > 0)
		{
			$query->where('country.sortName',$data['sortName']);
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
		//$query->leftJoin('countrycategory','country.countryID','=','countrycategory.countryID');
		//$query->leftJoin('category','category.categoryID','=','countrycategory.categoryID');

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
