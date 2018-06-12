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
use App\Http\Models\Pages;
use App\Http\Models\Frames;

class Pages_controllers extends Controller
{
	public function index(Request $request)
	{
		$pages= new Pages;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $pageID)
				{
					$query = Pages::where('pageID', $pageID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $pageID)
				{
					Pages::destroy($pageID);
				}
			}
		}
		
		$result=$pages ->getAllPages();
		$data['recordcount']=$result['rows'];
		$data['qGetAllPages']=$result['data'];
		return view('adminarea.pages.pages',$data);
		
	}
	
	public function addeditpages(Request $request)
	{	
		$pageID=$request->pageID;
		$data["srch_pageID"] = $request->srch_pageID?$request->srch_pageID:'';
	
		$result = Pages::where('parentID',0)->orderBy('displayOrder', 'asc')->get();
		$data['MainPagesrecord']=count($result);
		$data['qGetAllMainPages']=$result;
		
		$getFrames = Frames::where('isActive',1)->get();
		$data['getFrames'] = $getFrames;

		$data['getsinglepages'] = Pages::find($pageID);
		
		return view('adminarea.pages.pages-addedit',$data);
	}

	public function getChildPages(Request $request)
	{
		$obj = $request->obj?$request->obj:'1';
		$obj++;
		$checked  = $request->checked?$request->checked:0;
		$parentID = $request->parentID?$request->parentID:'0';

		$data = array('parentID'=>$parentID);
		$result = Pages::where($data)->orderBy('displayOrder', 'asc')->get();

		$MainPagesrecord=count($result);
		$qGetAllMainPages=$result;
		$str = '';
		if($MainPagesrecord>0)
		{
			$str .= '<select class="form-control" id="parentID_'.$obj.'" onchange="funGetChild(this.value,0,'.$obj.')" style="margin-top:5px;">';
			$str .= '<option value="">Select</option>';
			foreach($qGetAllMainPages as $ResAllMainPages)
			{
				$str .= '<option value="'.$ResAllMainPages->pageID.'"';
				if($checked == $ResAllMainPages->pageID)
				{
				 $str .= ' selected="selected"';
				}
				$str .= '>'.$ResAllMainPages->pageName.'</option>';
			}
			$str .= '</select>';
		}
		echo $str;
	}

	public function savepages(Request $request)
	{	
	
		if ($request->pageID!= NULL && $request->pageID > 0) 
		{
			$this->validate($request,array('pageName'=>'required','imgFileName_pages' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}else{
			$this->validate($request,array('pageName'=>'required|unique:pages,pageName','imgFileName_pages' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'));
		}
		
		
		$image = $request->file('pageImage');
		
		if($image){
			
			//$input['imagename'] = $request->pagesImage;;	
			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
			
			$destinationPath = public_path('/upload/pages');
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
			$pageImage=$input['imagename'];
			
		}else{
			$pageImage=$request->pageImage_old;
		}
		
		if ($request->customlink!="" && strpos($request->customlink,'http://') === false && strpos($request->customlink,'https://') === false){$request->customlink = 'http://'.$request->customlink;}

		$record = array(
						'parentID'=>$request->parentID,
						'pageName'=>ucwords(trim($request->pageName)),
						'pageFileName'=>strtolower(trim($request->pageFileName)),
						'pageContentType'=>$request->pageContentType,
						'pageContent'=>$request->pageContent,
						'pageLongDescription'=>$request->pageLongDescription,
						'pageTitle'=>trim($request->pageTitle),
						'pageMetaKeywords'=>$request->pageMetaKeywords,
						'pageMetaDescription'=>$request->pageMetaDescription,
						'isActive'=>$request->isActive,
						'pageSiteMap'=>$request->pageSiteMap,
						'createdBy'=>Session::get('admin_user'),
						'pageType'=>$request->pageType,
						'pageImage'=>$pageImage,
						'frameID'=>$request->frameID,
						'customlink'=>trim($request->customlink),
						'targetType'=>$request->targetType
						);
		
		if ($request->pageID!= NULL && $request->pageID > 0) 
		{
			$pages= new Pages;
			$pageID=$request->pageID;
			$query = $pages->where('pageID', $pageID)
                				->update($record);
			
		}
		else
		{
			$displayOrder=DB::table('pages')->max('displayOrder');
			$record = array_merge($record, array('displayOrder'=>$displayOrder ));
			
			$pages= new Pages($record);
			$pages->save();
			$pageID = $pages->pageID;
		}
		return Redirect::to(Input::get('redirects_to'))->withInput()->with(array('flash_message' => 'Pages successfully added'));
	}
	
	public function singledelete(Request $request)
	{
		$menuID =$request->pageID;
		Pages::destroy($menuID);
	}
	
	public function singlestatus(Request $request)
	{
		$pageID =$request->pageID;
		$pages=Pages::find($pageID);
		$isActive = $pages->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Pages::where('pageID', $pageID)
                				->update($data);
		echo $isActive;
	}
	
	public function imagedelete(Request $request)
	{
		$pageID =$request->pageID;
		$imagename = $request->imagename;
		
		$pagesImage = array('imgFileName_pages'=>'');
		$query = Pages::where('pageID', $pageID)
									->update($pagesImage);
				
		@unlink(public_path('upload/pages/'.$imagename));
		@unlink(public_path('upload/pages/th_'.$imagename));
		@unlink(public_path('upload/pages/mi_'.$imagename));
	}
}
