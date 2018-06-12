<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Staffcategory extends Model
{
	protected $table = "staffcategory";
	protected $primaryKey = "staffCategoryID";
	protected $fillable = array('staffID','categoryID');
	
	public function getAllStaffcategory()
	{
		
	}
}
