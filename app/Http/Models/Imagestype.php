<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Imagestype extends Model
{
	protected $table = "imagestype";
	protected $primaryKey = "imagesTypeID";
	protected $fillable = array('imagesTypeID','imagesType','isActive','isImage','isCaption', 'isDisplayOrder',
								'isTitle','isWeblink','isDescription','createdBy');
	
	public function getAllImagestype()
	{
		
	}
}
