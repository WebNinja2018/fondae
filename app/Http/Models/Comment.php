<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;


class Comment extends Model
{
	protected $table = "comment";
	protected $primaryKey = 'id';
    protected $fillable = array( 'order_id','comment', 'display_name','display_amount');
	
}
