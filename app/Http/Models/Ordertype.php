<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Ordertype extends Model
{
	protected $table = "ordertype";
	protected $primaryKey = "orderTypeID";
	protected $fillable = array('oderType');
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('ordertype');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('ordertype.*');
		}

		if(isset($data['orderTypeID']) && strlen(trim($data['orderTypeID'])) > 0)
		{
			$query->where('ordertype.orderTypeID',$data['orderTypeID']);
		}
		if(isset($data['oderType']) && strlen(trim($data['oderType'])) > 0)
		{
			$query->where('ordertype.oderType',$data['oderType']);
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
