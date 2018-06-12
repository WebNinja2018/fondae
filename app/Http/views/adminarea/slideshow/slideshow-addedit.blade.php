@extends('adminarea.home')
@section('content')
@include('adminarea.slideshow.slideshow-js')

<?php use App\Http\Models\Slideshow;
$slideshowID=Input::get('slideshowID')?Input::get('slideshowID'):'0';
if($slideshowID==0){
	$slideshowID=old('slideshowID')?old('slideshowID'):'';	
}
$imagesName=old('imagesName')?old('imagesName'):'';
$slideshowTitle=old('slideshowTitle')?old('slideshowTitle'):'';
$caption1=old('caption1')?old('caption1'):'';
$caption2=old('caption2')?old('caption2'):'';
$weblink=old('weblink')?old('weblink'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;

$srach_title=Input::get('srach_title')?Input::get('srach_title'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($slideshowID != NULL && $slideshowID >0)
{
	if(isset($getsingleslideshow))
	{
		$slideshowTitle=$getsingleslideshow->slideshowTitle;
		$caption1=$getsingleslideshow->caption1;
		$caption2=$getsingleslideshow->caption2;
		$weblink=$getsingleslideshow->weblink;
		$displayOrder=$getsingleslideshow->displayOrder;
		$isActive=$getsingleslideshow->isActive;
		$imagesName=$getsingleslideshow->imagesName;
	}
}
?>
<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/slideshow">Slideshow Management</a></li>
        <li class="active">@if($slideshowID != NULL && $slideshowID >0) Edit @else Add @endif Slideshow </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_slideshow_addedit" id="frm_slideshow_addedit"  action="{{ url('/') }}/adminarea/slideshow/saveslideshow" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="slideshowID" id="slideshowID" value="{{ $slideshowID }}">
        <input type="hidden" name="srach_title" id="srach_title" value="{{ $srach_title }}" >
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
                        <h2>@if($slideshowID != NULL && $slideshowID >0) Edit @else Add @endif Slideshow</h2>
                    </div>
                    <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Slideshow Title<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="slideshowTitle" maxlength="100" id="slideshowTitle" value="{{ $slideshowTitle }}" placeholder="Slideshow Title">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image Caption 1<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="caption1" maxlength="200" id="caption1" value="{{ $caption1 }}" placeholder="Image Caption 1">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image Caption 2</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="caption2" maxlength="200" id="caption2" value="{{ $caption2 }}" placeholder="Image Caption 2">
											</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image <span class="mandatory_field">*</span></label>
                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 1686*450">
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input class="form-control" name="imagesName" maxlength="200" id="imagesName" type="file" value="" />
                                          		<input type="hidden" name="imagesName_old" value="{{ $imagesName}}" />
												 @if(strlen($imagesName)>0)
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $slideshowID }},'{{ $imagesName }}');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        <img src="{{ url('/') }}/upload/slideshow/{{ $imagesName }}" height="180" width="180" />
                                                    </span>
                                                 @endif
                                            </div>
                                        </div>
                                        
                                        <?php /*?><div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Web Link</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="weblink" maxlength="200" id="weblink" placeholder="http://" value="{{ $weblink }}">
                                            </div>
                                        </div><?php */?>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right"></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
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
           </div>
       </section>
       <!-- end add pages--> 
    </form>
<script type="text/javascript">

$('input[id=weblink]').blur(function(){
    if( this.value.indexOf('http://') !== 0 && this.value.indexOf('https://') !== 0 ){
        this.value = 'http://' + this.value;
    }
});

</script> 
@endsection
