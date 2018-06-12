@extends('adminarea.home')
@section('content')
@include('adminarea.pages.pages-js')
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('.page_details').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php use App\Http\Models\Pages;
$pageID=Input::get('pageID')?Input::get('pageID'):'0';
if($pageID==0){
	$pageID=old('pageID')?old('pageID'):'';	
}
$parentID=old('parentID')?old('parentID'):'';
$pageName=old('pageName')?old('pageName'):'';
$pageFileName=old('pageFileName')?old('pageFileName'):'';
$pageContentType=old('pageContentType')?old('pageContentType'):'1';
$pageContent=old('pageContent')?old('pageContent'):'';
$pageLongDescription=old('pageLongDescription')?old('pageLongDescription'):'';
$pageTitle=old('pageTitle')?old('pageTitle'):'';
$pageMetaDescription=old('pageMetaDescription')?old('pageMetaDescription'):'';
$pageMetaKeywords=old('pageMetaKeywords')?old('pageMetaKeywords'):0;
$isActive=old('isActive')?old('isActive'):1;
$pageSiteMap=old('pageSiteMap')?old('pageSiteMap'):'';
$pageType=old('pageType')?old('pageType'):'';
$customlink=old('customlink')?old('customlink'):'';
$targetType=old('targetType')?old('targetType'):'';
$pageImage=old('pageImage')?old('pageImage'):'';

$frameID=old('frameID')?old('frameID'):'';
$tmp = "";

$srach_name=old('srach_name')?old('srach_name'):'';
$startDate=old('startDate')? date('m/d/Y',strtotime(old('startDate'))):'';
$endDate=old('endDate')? date('m/d/Y',strtotime(old('endDate'))):'';
$srch_status=old('srch_status')?old('srch_status'):'';

if($pageID != NULL && $pageID >0)
{
	if(isset($getsinglepages))
	{
		$parentID=$getsinglepages->parentID;
		$pageName=$getsinglepages->pageName;
		$pageFileName=$getsinglepages->pageFileName;
		$pageContentType=$getsinglepages->pageContentType;
		$pageContent=$getsinglepages->pageContent;
		$pageLongDescription=$getsinglepages->pageLongDescription;
		$pageTitle=$getsinglepages->pageTitle;
		$pageImage=$getsinglepages->pageImage;
		$pageMetaDescription=$getsinglepages->pageMetaDescription;
		$pageMetaKeywords=$getsinglepages->pageMetaKeywords;
		$isActive=$getsinglepages->isActive;
		$pageSiteMap=$getsinglepages->pageSiteMap;
		$pageType=$getsinglepages->pageType;
		$customlink=$getsinglepages->customlink;
		$frameID=$getsinglepages->frameID;
		$targetType=$getsinglepages->targetType;

		function fun_getparent($id)
		{
			global $tmp;
			$q_select_row = Pages::find($id);
			$q_get_result = $q_select_row->parentID;
		
			if($q_get_result > 0)
			{
				$tmp = $q_get_result.",".$tmp;
				fun_getparent($q_get_result);
			}
			else
			{
				$_SESSION['str2']=$tmp;
				//Session::set('str2')=$tmp;
			}
		}
		
		fun_getparent($pageID);
		
		$str_str = strrev(substr(strrev($_SESSION['str2']),1));
		$str_array = explode(",",$str_str);
		
	
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/pages">Pages Management</a></li>
        <li class="active">@if($pageID != NULL && $pageID >0) Edit @else Add @endif Pages </a></li>
    </ol>
    <section class="content-header top_header_content">
    	<div class="nav-tabs-custom">
             @include('adminarea.include.message')
             <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#general_tab" role="tab" data-toggle="tab">General Tab</a></li>
            </ul>
       </div>
		<div class="tab-content">
    <!---general information[start]--->
        <div class="tab-pane active" id="general_tab">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="row">
                    <form name="frm_pages_addedit" id="frm_pages_addedit"  action="{{ url('/') }}/adminarea/pages/savepages" method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <input type="hidden" class="form-control" name="pageID" id="pageID" value="{{ $pageID}}">
                    <input type="hidden" name="srach_name" id="srach_name" value="{{ $srach_name}}" >
                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate}}" >
                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate}}" >
                    <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status}}" >
					<input type="hidden" name="redirects_to" id="redirects_to" value="{{ URL::previous()}}" >
                    <!--start add user -->
                     <div class="box">
                            <div class="property_add">
                                <!-- strat box header-->
                                <div class="box-title with-border">
                                    <h2>@if($pageID != NULL && $pageID >0) Edit @else Add @endif Pages</h2>
                                </div>
                                <!-- end box -header -->
                                 <div class="tab-content">
                                     <div class="active tab-pane">
                                        <div class="addunit_forms">
                                            <div class="box-body">
                                               <div class="form-group">
                                                   <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Pages Category <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                           <select class="form-control" id="parentID_1" onchange="funGetChild(this.value,0,1)">
                                                                   <option value="0">Parent</option>
                                                                   @foreach($qGetAllMainPages as $GetAllMainPages)
                                                                   <option value="{{ $GetAllMainPages->pageID }}" @if($GetAllMainPages->pageID==$parentID) selected="selected" @endif >{{ $GetAllMainPages->pageName }}</option>
                                                                   @endforeach
                                                           </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Pages Title <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="text" class="form-control" name="pageName" maxlength="100" id="pageName" value="{{ $pageName}}" placeholder="Enter Pages Title">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page File Name <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="text" class="form-control" name="pageFileName" id="pageFileName" maxlength="70" placeholder="Page File Name" value="{{ $pageFileName }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Frame <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <select  id="frameID" name="frameID" class="form-control">
                                                                <option value="">--Select Frame--</option>
                                                                @foreach($getFrames as $displayFrames)
                                                                    <option value="{{ $displayFrames->frameID }}" @if($displayFrames->frameID == $frameID) selected="selected" @endif >{{ $displayFrames->frameName }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Pages Image <span class="mandatory_field">*</span></label>
                                                        <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input class="form-control" name="pageImage" maxlength="200" id="pageImage" type="file" value="" />
                                                            <input type="hidden" name="pageImage_old" value="{{ $pageImage}}" />
                                                             @if(strlen($pageImage)>0)
                                                                <span id="image"><a href="javascript:fun_remove_thumb({{ $pageID }},'{{ $pageImage }}');" class="close_img_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                                    <img src="{{ url('/') }}/upload/pages/{{ $pageImage }}" height="180" width="180" />
                                                                </span>
                                                             @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Type</label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="radio" name="pageType" onclick="funPageType(1)" value="1" @if($pageType==1) checked='checked' @endif /> <span class="label_color">Page</span>&nbsp;&nbsp;
                                                            <input type="radio" name="pageType" onclick="funPageType(2)" value="2" @if($pageType==2) checked='checked' @endif/> <span class="label_color">Custom Link</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Content Type</label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="radio" name="pageContentType" onclick="funPageContent(1)" value="1" id="content" @if($pageContentType==1) checked='checked' @endif /> <span class="label_color">Content</span>&nbsp;&nbsp;
                                                            <input type="radio" name="pageContentType" onclick="funPageContent(2)" value="2" id="dynamic" @if($pageContentType==2) checked='checked' @endif/> <span class="label_color">Dynamic</span>&nbsp;&nbsp;
                                                            <input type="radio" name="pageContentType" onclick="funPageContent(3)" value="3" id="contentdynamic" @if($pageContentType==3) checked='checked' @endif/><span class="label_color"> Content With Dynamic</span><br>
                                                        </div>
                                                    </div>
                                                      
                                                    <?php /*?><div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Target</label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="radio" name="targetType" value="1" @if($targetType==1) checked='checked' @endif /> <span class="label_color">_blank</span>&nbsp;&nbsp;
                                                            <input type="radio" name="targetType" value="2" @if($targetType==2) checked='checked' @endif /> <span class="label_color">_self</span>
                                                        </div>
                                                    </div><?php */?>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Custom link <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <input type="text" class="form-control" name="customlink" id="customlink" maxlength="100" placeholder="Custom link" value="{{ $customlink }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="pageContentBox" @if($pageContentType==2 ) style="display:none" @endif>
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Content</label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <textarea class="page_details" id="page_content" name="pageContent">{{ $pageContent }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="pageContentBox">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page LongDescription</label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <textarea class="page_details" id="pageLongDescription" name="pageLongDescription">{{ $pageLongDescription }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right"></label>
                                                        <div class="col-sm-6 col-md-6 col-xs-9">
                                                            <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Title <span class="mandatory_field">*</span></label>
                                                        <div class="col-sm-4 col-md-4 col-xs-7">
                                                            <input type="text" class="form-control" name="pageTitle" id="pageTitle" maxlength="70" placeholder="Enter Pages Title" value="{{ $pageTitle }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Description</label>
                                                        <div class="col-sm-4 col-md-4 col-xs-7">
                                                            <textarea rows="3" class="form-control" placeholder="Description" maxlength="300"  name="pageMetaDescription" id="pageMetaDescription">{{ $pageMetaDescription }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Meta Keywords</label>
                                                        <div class="col-sm-4 col-md-4 col-xs-7">
                                                            <textarea rows="3" class="form-control" placeholder="Meta Keywords" maxlength="300"  name="pageMetaKeywords" id="pageMetaKeywords">{{ $pageMetaKeywords }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                             </div>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                                         <div class="col-xs-12 col-md-12 col-sm-12">
                                            <!--<button class="btn btn-warning waves-effect waves-light">Submit</button>-->
                                            <input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Submit">
                                            <button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back()">Back</button>
                                         </div>
                                    </div>
                              </div>
                            <!-- end box-footer area-->
                        </div>
                    </div>
                   <!-- end add pages--> 
                </form>
                </div>
            </div>
        </div>
    <!---general information[end]---> 
 	</div>
    </section>
<script>
	<?php if($pageID != NULL && $pageID >0)
		{

			for($k=0 ; $k<count($str_array); $k++){ 
				$j=$k+1;
				if(isset($str_array[$j])){
					$checked = $str_array[$j];
				}else{
					$checked = 0;
				}
		?>
		//setTimeout(function(){funGetChild({{$str_array[$k]}},{{$checked}},{{$j}});},100);
		funGetChild({{$str_array[$k]}},{{$checked}},{{$j}});
	<?php 
			}?>

			$('#parentID_1').val({{$str_array[0]}});
	<?php
		}
	?>
</script>
@endsection
