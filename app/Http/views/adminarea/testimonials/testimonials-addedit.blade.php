@extends('adminarea.home')
@section('content')
@include('adminarea.testimonials.testimonials-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#details_content').redactor({
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php use App\Http\Models\Testimonials;
$testimonialsID=Input::get('testimonialsID')?Input::get('testimonialsID'):'0';
if($testimonialsID==0){
	$testimonialsID=old('testimonialsID')?old('testimonialsID'):'';	
}
$clientName=old('clientName')?old('clientName'):'';
$designation=old('designation')?old('designation'):'';
$details=old('details')?old('details'):'';
$testimonial_img=old('testimonial_img')?old('testimonial_img'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;
$featured=old('featured')?old('featured'):0;

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($testimonialsID != NULL && $testimonialsID >0)
{
	if(isset($getsingletestimonials))
	{
		$testimonialsID=$getsingletestimonials->testimonialsID;
		$clientName=$getsingletestimonials->clientName;
		$designation=$getsingletestimonials->designation;
		$details=$getsingletestimonials->details;
		$testimonial_img=$getsingletestimonials->testimonial_img;
		$displayOrder=$getsingletestimonials->displayOrder;
		$isActive=$getsingletestimonials->isActive;
		$featured=$getsingletestimonials->featured;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/testimonials">Testimonials Management</a></li>
        <li class="active">@if($testimonialsID != NULL && $testimonialsID >0) Edit @else Add @endif Testimonials </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_testimonials_addedit" id="frm_testimonials_addedit"  action="{{ url('/') }}/adminarea/testimonials/savetestimonials" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="testimonialsID" id="testimonialsID" value="{{ $testimonialsID }}">
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
                        <h2>@if($testimonialsID != NULL && $testimonialsID >0) Edit @else Add @endif Testimonials</h2>
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
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Client Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="clientName" id="clientName" maxlength="50" value="{{ $clientName}}" placeholder="Client Name">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Designation <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="designation" id="designation" maxlength="50" value="{{ $designation}}" placeholder="Designation">
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Detail <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea id="details_content" name="details">{{ $details }}</textarea>
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image <span class="mandatory_field">*</span></label>
                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input class="form-control" name="testimonial_img" maxlength="200" id="testimonial_img" type="file" value="" />
                                          		<input type="hidden" name="testimonial_img_old" value="{{ $testimonial_img}}" />
												 @if(strlen($testimonial_img)>0)
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $testimonialsID }},'{{ $testimonial_img }}');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        <img src="{{ url('/') }}/upload/testimonials/{{ $testimonial_img }}" height="180" width="180" />
                                                    </span>
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Featured</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label class="radio-inline">
													<input type="radio" value="1"  <?php if($featured==1){ echo "checked='checked'";} ?> name="featured">&nbsp;Yes
												</label>
												<label class="radio-inline">
													<input type="radio" value="0"  <?php if($featured==0){ echo "checked='checked'";} ?> name="featured">&nbsp;No
												</label>
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
                            <button  type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back()">Back</button>
                         </div>
                    </div>
                  </div>
                <!-- end box-footer area-->
            </div>
         </div>
       </section>
       <!-- end add pages--> 
    </form>
@endsection
