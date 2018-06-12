<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Product_category extends Model
{
	protected $table = "product_category";
	protected $primaryKey = "productCategoryID";
	protected $fillable = array('productID','categoryID');
	
	public function getAllProductcategory()
	{
		
	}
}
