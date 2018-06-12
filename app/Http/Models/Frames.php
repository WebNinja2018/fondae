<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Frames extends Model
{
	protected $table = "frames";
	protected $primaryKey = "framesID";
	protected $fillable = array('frameName','description','isActive');
	
	public function getAllFrames()
	{
		
	}
}
