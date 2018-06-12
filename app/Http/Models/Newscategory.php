<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Newscategory extends Model
{
	protected $table = "newscategory";
	protected $primaryKey = "newsCategoryID";
	protected $fillable = array('newsID','categoryID');
	
	public function getAllNewscategory()
	{
		
	}
}
