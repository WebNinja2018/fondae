<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Linkscategory extends Model
{
	protected $table = "linkscategory";
	protected $primaryKey = "linksCategoryID";
	protected $fillable = array('linksID','categoryID');
	
	public function getAllLinkscategory()
	{
		
	}
}
