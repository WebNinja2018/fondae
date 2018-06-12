<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Menurole extends Model
{
	protected $table = "menurole";
	protected $primaryKey = 'menuRoleID';
	protected $fillable = array('menuRoleID','roleID','menuID');
	
	public function getCheckMenuRole($menuID,$roleID)
	{
		$qGetCheckAssignMenu=Menurole::where('menuID',$menuID)
							          ->where('roleID',$roleID)
									  ->get();
		$result['rows']=count($qGetCheckAssignMenu);
		return $result;
	}
}
