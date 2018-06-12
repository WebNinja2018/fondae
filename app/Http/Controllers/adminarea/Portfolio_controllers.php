<?php

namespace App\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Image;
use Session;
use DB;

//Load Models
use App\Http\Models\Portfolio;
use App\Http\Models\Portfoliocategory;
use App\Http\Models\Category_model;
use App\Http\Models\Categorytype;

class Portfolio_controllers extends Controller
{
	public function index(Request $request)
	{
		$portfolio= new Portfolio;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $portfolioID)
				{
					$query = Portfolio::where('portfolioID', $portfolioID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $portfolioID)
				{
					Portfolio::destroy($portfolioID);
				}
			}
		}
		
		$result=$portfolio ->getAllPortfolio();
		$data['recordcount']=$result['rows'];
		$data['qGetAllPortfolio']=$result['data'];
		return view('adminarea.portfolio.portfolio',$data);
		
	}
	
	public function addeditportfolio(Request $request)
	{	
		//Get Checked Portfolio Category
		$portfolioID=$request->portfolioID;
		$CheckedCategory = Portfoliocategory::where('portfolioID', $portfolioID)->get();
		
		$data['qGetCheckedCategory']=$CheckedCategory;
		
		//Get Single Portfolio
		$data['getsingleportfolio'] = Portfolio::find($portfolioID);
		
		//Get All Portfolio Caregory
		$Category= new Category_model;
		$info = array('categorytypeID'=>5,'isActive'=>1);
		$result = Category_model::where($info)->get();
		$data['qGetAllCategory']=$result;
		return view('adminarea.portfolio.portfolio-addedit',$data);
	}

	public function saveportfolio(Request $request)
	{	
	
		if ($request->portfolioID!= NULL && $request->portfolioID > 0) 
		{
			$this->validate($request,array('categoryID'=>'required','portfolioTitle'=>'required','imgFileName_portfolio' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}else{
			$this->validate($request,array('categoryID'=>'required','portfolioTitle'=>'required|unique:portfolio,portfolioTitle','imgFileName_portfolio' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}
		
		
		$image = $request->file('imgFileName_portfolio');
		
		if($image){
			
			//$input['imagename'] = $request->portfolioImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/portfolio');
			$img = Image::make($image->getRealPath());
			
			//Start Resize image creat
			$img->resize(200, 200, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/th_'.$input['imagename']);
			
			$img->resize(458, 1024, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.'/mi_'.$input['imagename']);
			//End Resize image creat
			
			$image->move($destinationPath, $input['imagename']);
			$portfolio_img=$input['imagename'];
			
		}else{
			$portfolio_img=$request->portfolioImage_old;
		}
		
		
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$isFeature=$request->isFeature?$request->isFeature:'0';
		
		$record = array(
						'portfolioTitle'=>ucwords(trim($request->portfolioTitle)),
						'body'=>$request->body,
						'featured'=>$request->featured,
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'imgFileName_portfolio'=>$portfolio_img
						);

		if ($request->portfolioID!= NULL && $request->portfolioID > 0) 
		{
			$portfolio= new Portfolio;
			$portfolioID=$request->portfolioID;
			$query = $portfolio->where('portfolioID', $portfolioID)
                				->update($record);
			
			Portfoliocategory::where('portfolioID', '=', $portfolioID)->delete();
				
			$categoryID=$request->categoryID;
			
			for($i=0;$i<count($categoryID);$i++)
			{
				$info = array('portfolioID'=>$portfolioID,'categoryID'=>$categoryID[$i]);
				$portfoliocategory= new Portfoliocategory($info);
				$portfoliocategory->save();
			}
		}
		else
		{
			$url_title=preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower(trim($request->portfolioTitle)));
	    	$checkUrltitle=count(Portfolio::where('url_title', $url_title)->get());

			$portfolio= new Portfolio($record);
			$portfolio->save();
			$portfolioID = $portfolio->portfolioID;
			
			if($checkUrltitle>0){$url_title=$url_title.'-'.$portfolioID;}
			$recordUrltitle=array('url_title'=>$url_title);
			$query = $portfolio->where('portfolioID', $portfolioID)
                				->update($recordUrltitle);

			$categoryID=$request->categoryID;
			for($i=0;$i<count($categoryID);$i++)
			{
				$info1 = array("portfolioID"=>$portfolioID,	
							   "categoryID"=>$categoryID[$i]);
				$portfoliocategory= new Portfoliocategory($info1);
				$portfoliocategory->save();
			}
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Portfolio successfully added'));
	}
	
	public function saveMetaKeyword(Request $request)
	{
		$record = array(
						'pageTitle'=>$request->pageTitle,
						'metaKeyword'=>$request->metaKeyword,
						'description'=>$request->description,
						);
		if ($request->portfolioID!= NULL && $request->portfolioID > 0) 
		{
			$portfolio= new Portfolio;
			$portfolioID=$request->portfolioID;
			$query = $portfolio->where('portfolioID', $portfolioID)
                				->update($record);
			
		}
		//return Redirect::to(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Portfolio successfully added'));
		return back()->withInput()->with(array('flash_message' => 'Portfolio successfully added'));
    }
	
	public function singledelete(Request $request)
	{
		$menuID =$request->portfolioID;
		Portfolio::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$portfolioID =$request->portfolioID;
		$portfolio=Portfolio::find($portfolioID);
		$isActive = $portfolio->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Portfolio::where('portfolioID', $portfolioID)
                				->update($data);
		echo $isActive;
	}
	
	public function portfoliocategory(Request $request)
	{
		$data['categorytypeID']=5;
		$data['categorytypePath']="adminarea/portfolio/portfoliocategory";
		$data['addcategorytypePath']="adminarea/portfolio/addeditportfoliocategory";
		$category= new Category_model;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $categoryID)
				{
					$query = Category_model::where('categoryID', $categoryID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $categoryID)
				{
					Category_model::destroy($categoryID);
				}
			}
		}
		$data['categoryTypes'] = Categorytype::find($data['categorytypeID']);
		$result=$category ->getAllCategory($data['categorytypeID']);
		$data['recordcount']=$result['rows'];
		$data['qGetAllCategory']=$result['data'];
		return view('adminarea.category.category',$data);
		
	}
	
	public function addeditportfoliocategory(Request $request)
	{	
		$categoryID=$request->categoryID;
		$data['categorytypeID']=5;
		$data['categorytypePath']="adminarea/portfolio/portfoliocategory";
		$data['addcategorytypePath']="adminarea/portfolio/addeditportfoliocategory";
		$data['getsingleCategory'] = Category_model::find($categoryID);
		
		$info = array('categorytypeID'=>$data['categorytypeID'],'parentCategoryID'=>0);
		$result['data'] = Category_model::where($info)->get();
		$result['rows']=count($result['data']);
		$data['getMainCategory']=$result;
		
		$data['getMainCategoryType'] = Categorytype::find($data['categorytypeID']);
		
		return view('adminarea.category.category-addedit',$data);
	}
	
	public function imagedelete(Request $request)
	{
		$portfolioID =$request->portfolioID;
		$imagename = $request->imagename;
		
		$portfolioImage = array('imgFileName_portfolio'=>'');
		$query = Portfolio::where('portfolioID', $portfolioID)
									->update($portfolioImage);
				
		@unlink(public_path('upload/portfolio/'.$imagename));
		@unlink(public_path('upload/portfolio/th_'.$imagename));
		@unlink(public_path('upload/portfolio/mi_'.$imagename));
	}

	public function portfolioorder(Request $request)
	{
		$result = Portfolio::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllPortfolio']=$result;
		return view('adminarea.portfolio.portfolioorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = Portfolio::where('portfolioID', $item[$i])
									->update($data);
		}
	}
}
