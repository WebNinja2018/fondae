<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Orderstatus extends Model
{
	protected $table = "orderstatus";
	protected $primaryKey = "orderstatusID";
	protected $fillable = array('orderName');
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('orderstatus');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('orderstatus.*');
		}

		if(isset($data['orderstatusID']) && strlen(trim($data['orderstatusID'])) > 0)
		{
			$query->where('orderstatus.orderstatusID',$data['orderstatusID']);
		}
		if(isset($data['orderName']) && strlen(trim($data['orderName'])) > 0)
		{
			$query->where('orderstatus.orderName',$data['orderName']);
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
