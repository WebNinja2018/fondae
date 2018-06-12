@extends('adminarea.home')
@section('content')
@include('adminarea.gallery.gallery-js')

<script src="{{ url('/') }}/components/js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/components/css/uploadify.css">
<script type="text/javascript" src="{{ url('/') }}/components/js/jquery-ui_drop.js"></script>

<script>
	$(function() {
		  $('.submitbuttonSave').click(function()
		  {
			  var h = [];
			  $(".innerproduct_order_col").each(function() {  h.push($(this).attr('id').substr(9));  });
					
			  $.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/gallery/saveimageorder",
				data: 'item='+h,
				success: function(data)
				{
					window.location.reload();
				}
				});
				setTimeout(function(){
				  $(".flash").slideUp("slow", function () {
				  $(".flash").hide();
				}); }, 3000);
			});
		  
			$( "#sortable" ).sortable({
			revert: true
			});
			$( "ul, li" ).disableSelection();
		});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php use App\Http\Models\Gallery;
$galleryID=Input::get('galleryID')?Input::get('galleryID'):'0';
if($galleryID==0){
	$galleryID=old('galleryID')?old('galleryID'):'';	
}
$galleryMainImage=old('galleryMainImage')?old('galleryMainImage'):'';
$galleryTitle=old('galleryTitle')?old('galleryTitle'):'';
$weblink=old('weblink')?old('weblink'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;
$featured=old('featured')?old('featured'):'';

$srach_title=Input::get('srach_title')?Input::get('srach_title'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($galleryID != NULL && $galleryID >0)
{
	if(isset($getsinglegallery))
	{
		$galleryTitle=$getsinglegallery->galleryTitle;
		$weblink=$getsinglegallery->weblink;
		$displayOrder=$getsinglegallery->displayOrder;
		$isActive=$getsinglegallery->isActive;
		$featured=$getsinglegallery->featured;
		$galleryMainImage=$getsinglegallery->galleryMainImage;
		$imagesTypeID=$getsinglegallery->imagesTypeID;
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
        <li><a href="{{ url('/') }}/adminarea/gallery">Gallery Management</a></li>
        <li class="active">@if($galleryID != NULL && $galleryID >0) Edit @else Add @endif Gallery </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_gallery_addedit" id="frm_gallery_addedit"  action="{{ url('/') }}/adminarea/gallery/savegallery" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="galleryID" id="galleryID" value="{{ $galleryID }}">
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
                        <h2>@if($galleryID != NULL && $galleryID >0) Edit @else Add @endif Gallery</h2>
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
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Gallery Title<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="galleryTitle" maxlength="100" id="galleryTitle" value="{{ $galleryTitle }}" placeholder="Gallery Title">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Gallery Image <span class="mandatory_field">*</span></label>
                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input class="form-control" name="galleryMainImage" maxlength="200" id="galleryMainImage" type="file" value="" />
                                          		<input type="hidden" name="galleryMainImage_old" value="{{ $galleryMainImage}}" />
												 @if(strlen($galleryMainImage)>0)
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $galleryID }},'{{ $galleryMainImage }}');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        <img src="{{ url('/') }}/upload/gallery/{{ $galleryMainImage }}" height="180" width="180" />
                                                    </span>
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Web Link</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="weblink" maxlength="200" id="weblink" placeholder="http://" value="{{ $weblink }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right"></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($featured==1) checked='checked' @endif name="featured">Featured?</label>
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
                            <button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_backGallery()">Back</button>
                         </div>
                    </div>
                  </div>
                <!-- end box-footer area-->
            </div>
           </div>
       </section>
       <!-- end add pages--> 
    </form>
	@if(($galleryID)>0)
		<!---Image Tab[Start]--->
            <div>
            <?php $data['itemID'] = $galleryID;
                  $data['imagesTypeID'] = 6;
                  //view('adminarea.images.images',$data);
                  //echo View::make('adminarea.images.images', $data);
                  echo view('adminarea.images.images',$data)->render(); 
            ?>
            </div>      
    	<!---Image Tab[end]--->
	@endif
<script type="text/javascript">

$('input[id=weblink]').blur(function(){
    if( this.value.indexOf('http://') !== 0 && this.value.indexOf('https://') !== 0 ){
        this.value = 'http://' + this.value;
    }
});

</script> 
@endsection
