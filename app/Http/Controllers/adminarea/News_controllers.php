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
use App\Http\Models\News;
use App\Http\Models\Newscategory;
use App\Http\Models\Category_model;
use App\Http\Models\Categorytype;

class News_controllers extends Controller
{
	public function index(Request $request)
	{
		
		$news= new News;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $newsID)
				{
					$query = News::where('newsID', $newsID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $newsID)
				{
					News::destroy($newsID);
				}
			}
		}
		
		$result=$news ->getAllNews();
		$data['recordcount']=$result['rows'];
		$data['qGetAllNews']=$result['data'];
		return view('adminarea.news.news',$data);
		
		
	}
	
	public function addeditnews(Request $request)
	{	
		//Get Checked News Category
		$newsID=$request->newsID;
		$CheckedCategory = Newscategory::where('newsID', $newsID)->get();
		
		$data['qGetCheckedCategory']=$CheckedCategory;
		
		//Get Single News
		$data['getsinglenews'] = News::find($newsID);
		
		//Get All News Caregory
		$Category= new Category_model;
		$info = array('categorytypeID'=>1,'isActive'=>1);
		$result = Category_model::where($info)->get();
		$data['qGetAllCategory']=$result;
		return view('adminarea.news.news-addedit',$data);
	}

	public function savenews(Request $request)
	{	
	
		if ($request->newsID!= NULL && $request->newsID > 0) 
		{
			$this->validate($request,array('categoryID'=>'required','newsTitle'=>'required','author'=>'required','imgFileName_news' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048','newsDate'=>'required|date|before:tomorrow'));
		}else{
			$this->validate($request,array('categoryID'=>'required','newsTitle'=>'required|unique:news,newsTitle','author'=>'required','imgFileName_news' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048','newsDate'=>'required|date|before:tomorrow'));
		}
		
		
		$image = $request->file('imgFileName_news');
		
		if($image){
			
			//$input['imagename'] = $request->newsImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/news');
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
			$news_img=$input['imagename'];
			
		}else{
			$news_img=$request->newsImage_old;
		}
			
		$weblink=$request->weblink;
		if($weblink=='http://'){$weblink='';}
		
		$isActive=$request->isActive?$request->isActive:'0';
		$isFeature=$request->isFeature?$request->isFeature:'0';
		
		$record = array(
						'newsTitle'=>ucwords(trim($request->newsTitle)),
						'newsDate'=>date('Y-m-d H:i:s',strtotime($request->newsDate)),
						'author'=>ucwords(trim($request->author)),
						'summary'=>trim($request->summary),
						'body'=>$request->body,
						'weblink'=>trim($weblink),
						'featured'=>$request->featured,
						'displayOrder'=>$request->displayOrder,
						'isActive'=>$isActive,
						'imgFileName_news'=>$news_img
						);

		if ($request->newsID!= NULL && $request->newsID > 0) 
		{
			$news= new News;
			$newsID=$request->newsID;
			$query = $news->where('newsID', $newsID)
                				->update($record);
			
			Newscategory::where('newsID', '=', $newsID)->delete();
				
			$categoryID=$request->categoryID;
			
			for($i=0;$i<count($categoryID);$i++)
			{
				$info = array('newsID'=>$newsID,'categoryID'=>$categoryID[$i]);
				$newscategory= new Newscategory($info);
				$newscategory->save();
			}
		}
		else
		{
			$url_title=preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower(trim($request->newsTitle)));
			$checkUrltitle=count(News::where('url_title', $url_title)->get());

			$news= new News($record);
			$news->save();
			$newsID = $news->newsID;
			
			if($checkUrltitle>0){$url_title=$url_title.'-'.$newsID;}
			$recordUrltitle=array('url_title'=>$url_title);
			$query = $news->where('newsID', $newsID)
                				->update($recordUrltitle);

			$categoryID=$request->categoryID;
			for($i=0;$i<count($categoryID);$i++)
			{
				$info1 = array("newsID"=>$newsID,	
							   "categoryID"=>$categoryID[$i]);
				$newscategory= new Newscategory($info1);
				$newscategory->save();
			}
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'News successfully added'));
	}
	
	public function saveMetaKeyword(Request $request)
	{
		$this->validate($request,array('pageTitle'=>'required'));
		$record = array(
						'pageTitle'=>$request->pageTitle,
						'metaKeyword'=>$request->metaKeyword,
						'description'=>$request->description,
						);
		if ($request->newsID!= NULL && $request->newsID > 0) 
		{
			$news= new News;
			$newsID=$request->newsID;
			$query = $news->where('newsID', $newsID)
                				->update($record);
			
		}
		return Redirect::fun_redirect(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'News successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->newsID;
		News::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$newsID =$request->newsID;
		$news=News::find($newsID);
		$isActive = $news->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = News::where('newsID', $newsID)
                				->update($data);
		echo $isActive;
	}
	
	public function newscategory(Request $request)
	{
		$data['categorytypeID']=1;
		$data['categorytypePath']="adminarea/news/newscategory";
		$data['addcategorytypePath']="adminarea/news/addeditnewscategory";
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
	
	public function addeditnewscategory(Request $request)
	{	
		$categoryID=$request->categoryID;
		$data['categorytypeID']=1;
		$data['categorytypePath']="adminarea/news/newscategory";
		$data['addcategorytypePath']="adminarea/news/addeditnewscategory";
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
		$newsID =$request->newsID;
		$imagename = $request->imagename;
		
		$newsImage = array('imgFileName_news'=>'');
		$query = News::where('newsID', $newsID)
									->update($newsImage);
				
		@unlink(public_path('upload/news/'.$imagename));
		@unlink(public_path('upload/news/th_'.$imagename));
		@unlink(public_path('upload/news/mi_'.$imagename));
	}

	public function newsorder(Request $request)
	{
		$result = News::orderBy('displayOrder', 'asc')->get();
		$data['recordcount']=count($result);
		$data['qGetAllNews']=$result;
		return view('adminarea.news.newsorder',$data);
	}
	public function saveorder(Request $request)
	{
		$item = explode(',',$request->item);
		for( $i=0 ; $i<count($item) ; $i++ )
		{
			$j = $i+1;
			$data = array('displayOrder'=>$j);
			$query = News::where('newsID', $item[$i])
									->update($data);
		}
	}
}
