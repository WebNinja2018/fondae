<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Adminmenu extends Model
{
	protected $table = "adminmenu";
	protected $primaryKey = "menuID";
    protected $fillable = array('menuParentID','menuName','menuLink', 'displayOrder', 'isActive','createdBy','classname');

	
	public function getAllAdminmenu()
	{
		$menuName=Input::get('srach_menuName')?Input::get('srach_menuName'):'';
		$srch_menuParentID=Input::get('srch_menuParentID')?Input::get('srch_menuParentID'):'';
		$srch_status=Input::get('srch_status');
									 
		$query = DB::table('adminmenu');
		if( strlen($menuName) )
		{
			$query->where('menuName','LIKE',"{$menuName}%");
		}
		if( strlen($srch_menuParentID) )
		{
			$query->where('menuParentID',$srch_menuParentID);
		}
		else
		{
			$query->where('menuParentID','0');
		}
		if($srch_status)
		{
			$query->where('isActive',$srch_status);
		}									  
		$query->orderBy('displayOrder', 'ASC');
		//$getAllAdminmenu=$query->paginate(10);  //With Pagination
		$getAllAdminmenu=$query->get();      //Without Pagination
	    //echo $getAllAdminmenu=$query->toSql();	 //For Query print
		
		$result['data']=$getAllAdminmenu;
		$result['rows']=count($getAllAdminmenu);
		return $result;
	}
	public function getCheckAssignMenu($roleID,$uri_string)
	{
		$qGetCheckAssignMenu=Adminmenu::join('menurole', 'menurole.menuID', '=', 'adminmenu.menuID')
					->where('adminmenu.isActive',1)
					->where('adminmenu.menuLink',$uri_string)
					->where('menurole.roleID',$roleID)
					->get();
					//->toSql();	
		$result['data']=$qGetCheckAssignMenu;
		$result['rows']=count($qGetCheckAssignMenu);
		return $result;
	}
	
	public function getAllParent($menuParentID,$isActive='',$roleID='')
	{
	  $qGetAllParent = Adminmenu::join('menurole', 'menurole.menuID', '=', 'adminmenu.menuID')
					  ->where('menuParentID', $menuParentID)
					  ->where(function($query) use ($isActive, $roleID) {
							if( strlen($isActive)>0 )
								$query->where('adminmenu.isActive',$isActive);
							
							if( strlen($roleID)>0 )
								$query->where('menurole.roleID',$roleID);
						 })
					  ->orderBy('displayOrder', 'ASC')
					  ->groupBy('adminmenu.menuID')
					  ->get();
					  //->toSql();	
	  $result['data']=$qGetAllParent;
	  $result['rows']=count($qGetAllParent);
	  return $result;
	}
	
	
	
	function funGetReorder()
	{
		$menuID=Input::get('menuID');
		$menuParentID=Input::get('menuParentID');
		$direction=Input::get('direction');
		
		$this->db->where('menuParentID',$menuParentID);
		$this->db->order_by('displayOrder','ASC');
		$query=$this->db->get('adminmenu');
		$result['data']=$query->result();
		$i=1;

		foreach( $result['data'] as $res )
		{
			if( isset($position) )
			{
				$next = $res->menuID;
				break;
			}
			if( !isset($position) && $res->menuID == $menuID )
			{
				$position = $i;
			}
			if( $res->menuID != $menuID )
			{
				$pre = $res->menuID;
			}
			
			$i++;
		}
		if( $direction=='down' && $position < count($result['data']) )
		{
			$n = $position+1;
			mysql_query("UPDATE adminmenu SET displayOrder=".$n." WHERE menuID=".$menuID);
			mysql_query("UPDATE adminmenu SET displayOrder=".$position." WHERE menuID=".$next);
		}
		if( $direction=='up' && $position > 1 )
		{
			$n = $position-1;
			mysql_query("UPDATE adminmenu SET displayOrder=".$n." WHERE menuID=".$menuID);
			mysql_query("UPDATE adminmenu SET displayOrder=".$position." WHERE menuID=".$pre);
		}
	}
	
	
}
