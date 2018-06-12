<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = "user";
	protected $primaryKey = 'userID';
    //protected $fillable = [
//        'name', 'email', 'password',
//    ];
	protected $fillable = array('roleID','firstName','lastName','phoneNo','email','password','isActive','createdBy','reset_pass');


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function getAllUser()
	{
		$firstName=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
		$startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
		$endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
		$srch_status=Input::get('srch_status');
		
		$fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
		$order=Input::get('order')?Input::get('order'):'';
		$query = DB::table('user');
		
		$query->select('user.*','role.name');
		$query->join('role', 'role.roleID', '=', 'user.roleID');
		if( strlen($firstName) )
		{
			$query->where('user.firstName','LIKE',trim($firstName).'%');
		}
		if( strlen($startDate)>0 && strlen($endDate)>0)
		{
			$query->whereBetween('user.created_at', array($startDate,$endDate));
		}
		if(strlen($srch_status)>0)
		{
			$query->where('user.isActive',$srch_status);
		}
		if($fieldname=='' || $order==''){
			$query->orderBy('userID', 'asc');				
		}
		else
		{
			$query->orderBy($fieldname, $order);
		}
		
		
		
		$getAllUser=$query->paginate(2);  //With Pagination
		//$getAllUser=$query->get();      //Without Pagination
	    //echo $getAllUser=$query->toSql();	 //For Query print
		
		$result['rows']=count($getAllUser);
		$result['data']=$getAllUser;
		
		return $result;
	}
	
	function getByAttributesQuery($data)
	{
		$query = DB::table('user');
		if(isset($data['fieldList']))
		{
			$query->select($data['fieldList']);
		}else{
			$query->select('user.*');
		}

		if(isset($data['userID']) && strlen(trim($data['userID'])) > 0)
		{
			$query->where('user.userID',$data['userID']);
		}
		if(isset($data['md5(userID)']) && strlen(trim($data['md5(userID)'])) > 0)
		{
			$query->whereRaw('md5(`userID`) = "'.$data['md5(userID)'].'"');
		}
		if(isset($data['firstName']) && strlen(trim($data['firstName'])) > 0)
		{
			$query->where('user.firstName',$data['firstName']);
		}
		if(isset($data['lastName']) && strlen(trim($data['lastName'])) > 0)
		{
			$query->where('user.lastName',$data['lastName']);
		}
		if(isset($data['email']) && strlen(trim($data['email'])) > 0)
		{
			$query->where('user.email',$data['email']);
		}
		if(isset($data['password']) && strlen(trim($data['password'])) > 0)
		{
			$query->where('user.password',$data['password']);
		}
		if(isset($data['isActive']) && strlen(trim($data['isActive'])) > 0)
		{
			$query->where('user.isActive',$data['isActive']);
		}
		if(isset($data['ip']) && strlen(trim($data['ip'])) > 0)
		{
			$query->where('user.ip',$data['ip']);
		}
		if(isset($data['MacID']) && strlen(trim($data['MacID'])) > 0)
		{
			$query->where('user.MacID',$data['MacID']);
		}
		if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
        {
			if(isset($data['order']) && strlen(trim($data['order'])) > 0)
			{
           		$query->orderBy($data['orderBy'],$data['order']);
        	}else{
				$query->orderBy($data['orderBy']);
			}
		}
		if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
		{
			$query->groupBy($data['groupBy']);
		}
		//$query->leftJoin('usercategory','user.userID','=','usercategory.userID');
		//$query->leftJoin('category','category.categoryID','=','usercategory.categoryID');

		if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
			$result['data']=$query->paginate(intval($data['paginate']));
		}else{
			$result['data']=$query->get();
        }
		$result['recordCount'] = count($result['data']);
        return $result;
	}

	public function checkLogin()
	{
		//redirect()->intended('login');
		//return Redirect::away('http://phpserver5/projects/laraveldemo/adminarea')->send();
	}
}

