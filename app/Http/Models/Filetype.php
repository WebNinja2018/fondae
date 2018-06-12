<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Filetype extends Model
{
	protected $table = "filetype";
	protected $primaryKey = "fileTypeID";
	protected $fillable = array('fileTypeID','fileType','isActive','isFile','isCaption', 'isDisplayOrder',
								'isTitle','isWeblink','isDescription','createdBy');
	
	public function getAllFiletype()
	{
		
	}
}
