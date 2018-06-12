<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Portfoliocategory extends Model
{
	protected $table = "portfoliocategory";
	protected $primaryKey = "portfolioCategoryID";
	protected $fillable = array('portfolioID','categoryID');
	
	public function getAllPortfoliocategory()
	{
		
	}
}
