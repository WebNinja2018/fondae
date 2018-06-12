<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;


class Categorytype extends Model
{
	protected $table = "categorytype";
	protected $primaryKey = 'categorytypeID';
    protected $fillable = array('categorytype','createdby','isactive','isMultipleCategory','isCategoryName','isDisplayOrder','isFeatured','isPageTitle','isPageMetaKeyword','isPageDescription','isContentEditorText','isImage','explore_page');
	
	public function getAllCategorytype()
	{
		
		
	}
	
}
