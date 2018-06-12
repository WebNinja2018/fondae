@extends('adminarea.home')
@section('content')
@include('adminarea.links.links-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#link_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>

<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

<?php use App\Http\Models\Links;
$linksID=Input::get('linksID')?Input::get('linksID'):'0';
if($linksID==0){
	$linksID=old('linksID')?old('linksID'):'';	
}
$categoryID=old('categoryID[]')?old('categoryID[]'):'';
$name=old('name')?old('name'):'';
$description=old('description')?old('description'):'';
$altTag=old('altTag')?old('altTag'):'';
$weblink=old('weblink')?old('weblink'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isFeature=old('isFeature')?old('isFeature'):'';
$isActive=old('isActive')?old('isActive'):1;
$linksImage=old('linksImage')?old('linksImage'):'';

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($linksID != NULL && $linksID >0)
{
	if(isset($getsinglelinks))
	{
		$name=$getsinglelinks->name;
		$description=$getsinglelinks->description;
		$altTag=$getsinglelinks->altTag;
		$weblink=$getsinglelinks->weblink;
		$displayOrder=$getsinglelinks->displayOrder;
		$isFeature=$getsinglelinks->isFeature;
		$isActive=$getsinglelinks->isActive;
		$linksImage=$getsinglelinks->linksImage;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/links">Links Management</a></li>
        <li class="active">@if($linksID != NULL && $linksID >0) Edit @else Add @endif Links </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_links_addedit" id="frm_links_addedit"  action="{{ url('/') }}/adminarea/links/savelinks" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="linksID" id="linksID" value="{{ $linksID }}">
        <input type="hidden" name="srach_name" id="srach_name" value="{{ $srach_name }}" >
        <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status }}" >
        <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}" >
        <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}" >
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
        <!--start add user -->
        <section class="content-header top_header_content">
        	<div class="box">
                <div class="property_add">
                    <!-- strat box header-->
                    <div class="box-title with-border">
                        <h2>@if($linksID != NULL && $linksID >0) Edit @else Add @endif Links</h2>
                    </div>
                    <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group-main">
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Links Category <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-8 col-md-8 col-xs-9">
                                                    <?php 
                                                        if(isset($qGetCheckedCategory))
                                                         {
                                                             $array_qGetCheckedCategory='';
                                                             foreach($qGetCheckedCategory as $qGetCheckedCategory)
                                                             {
                                                                $array_qGetCheckedCategory[] = $qGetCheckedCategory->categoryID;
                                                             }
                                                            $array = array($qGetCheckedCategory);
                                                            
                                                         }
                                                         
                                                     ?>
                                                     
                                                     @foreach($qGetAllCategory as $GetAllCategory)
                                                     <label class="checkbox-inline">
                                                        <input type="checkbox" name="categoryID[]" value="{{ $GetAllCategory->categoryID }}" 
                                                            @if(count($qGetCheckedCategory)>0)
                                                                @for($i=0;$i<count($array_qGetCheckedCategory);$i++)
                                                                    @if($array_qGetCheckedCategory[$i]==$GetAllCategory->categoryID)
                                                                        checked="checked"
                                                                    @endif
                                                                @endfor
                                                            @endif
                                                         />{{ $GetAllCategory->categoryname }}
                                                       </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Name <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="name" maxlength="100" id="name" value="{{ $name }}" placeholder=" Link Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Image <span class="mandatory_field">*</span></label>
                                                <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input class="form-control" name="linksImage" maxlength="200" id="linksImage" type="file" value="" />
                                                    <input type="hidden" name="linksImage_old" value="{{ $linksImage}}" />
                                                     @if(strlen($linksImage)>0)
                                                        <span id="image"><a href="javascript:fun_remove_thumb({{ $linksID }},'{{ $linksImage }}');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                            <img src="{{ url('/') }}/upload/links/{{ $linksImage }}" height="180" width="180" />
                                                        </span>
                                                     @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Alt Tag for Image</label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="altTag" maxlength="100" id="altTag" placeholder="Alt Tag for Image" value="{{ $altTag }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Web Link</label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="weblink" maxlength="200" id="weblink" placeholder="http://" value="{{ $weblink }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Display Order <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left"></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left"></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isFeature==1) checked='checked' @endif name="isFeature">IsFeature?</label>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                 </div>
                            </div>
                      </div>
                        <!-- end general & seo tab-->
                    <!-- end box-body area-->
                 </div>
                <!-- strat box footer area-->
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
       </section>
       <!-- end add pages--> 
    </form>
@endsection
