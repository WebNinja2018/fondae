@extends('adminarea.home')
@section('content')
@include('adminarea.coupon.coupon-js')

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

<?php use App\Http\Models\Coupon;
$couponID=Input::get('couponID')?Input::get('couponID'):'0';
if($couponID==0){
	$couponID=old('couponID')?old('couponID'):'';	
}
$couponName=old('couponName')?old('couponName'):'';
$couponCode=old('couponCode')?old('couponCode'):'';
$couponStartDate=old('couponStartDate')?old('couponStartDate'):date('m/d/Y');
$couponEndDate=old('couponEndDate')?old('couponEndDate'):date('m/d/Y');
$discountType=old('discountType')?old('discountType'):1;
$discountRate=old('discountRate')?old('discountRate'):'';
$isActive=old('isActive')?old('isActive'):1;
$useLimit=old('useLimit')?old('useLimit'):'';

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($couponID != NULL && $couponID >0)
{
	if(isset($getsinglecoupon))
	{
		$couponName=$getsinglecoupon->couponName;
		$couponCode=$getsinglecoupon->couponCode;
		$couponStartDate=date('m/d/Y',strtotime($getsinglecoupon->couponStartDate));
		$couponEndDate=date('m/d/Y',strtotime($getsinglecoupon->couponEndDate));
		$isActive=$getsinglecoupon->isActive;
		$discountType=$getsinglecoupon->discountType;
		$discountRate=$getsinglecoupon->discountRate;
		$useLimit=$getsinglecoupon->useLimit;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/coupon">Coupon Management</a></li>
        <li class="active">@if($couponID != NULL && $couponID >0) Edit @else Add @endif Coupon </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_coupon_addedit" id="frm_coupon_addedit"  action="{{ url('/') }}/adminarea/coupon/savecoupon" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="couponID" id="couponID" value="{{ $couponID }}">
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
                        <h2>@if($couponID != NULL && $couponID >0) Edit @else Add @endif Coupon</h2>
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
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Coupon Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="couponName" id="couponName" maxlength="50" value="{{ $couponName}}" placeholder="Coupon Name">
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Coupon Code <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="couponCode" id="couponCode" maxlength="50" value="{{ $couponCode}}" placeholder="Coupon Code">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Coupon Start Date</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <div class="input-group">
                                                    <div id="sandbox-container">
                                                        <input type="text" name="couponStartDate" id="couponStartDate" class="form-control" maxlength="20" placeholder="Start Date" value="{{ date('m/d/Y',strtotime($couponStartDate))}}">
                                                    </div>
                                                      <script type="text/javascript">
															$('#sandbox-container input').datepicker({
															multidateSeparator: "dd-mm-yyyy",
															keyboardNavigation: false,
															forceParse: false
															});
														</script>
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Coupon End Date</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <div class="input-group">
                                                    <div id="sandbox-container">
                                                        <input type="text" name="couponEndDate" id="couponEndDate" class="form-control" maxlength="20" placeholder="End Date" value="{{ date('m/d/Y',strtotime($couponEndDate))}}">
                                                    </div>
                                                      <script type="text/javascript">
															$('#sandbox-container input').datepicker({
															multidateSeparator: "dd-mm-yyyy",
															keyboardNavigation: false,
															forceParse: false
															});
														</script>
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Coupon Use Limit <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="useLimit" id="useLimit" maxlength="100" value="{{ $useLimit}}" placeholder="Coupon Use Limit">
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Dscount Type </label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label class="radio-inline">
													<input type="radio" value="1"  @if($discountType==1) checked='checked' @endif name="discountType">&nbsp;Percentage
												</label>
												<label class="radio-inline">
													<input type="radio" value="2" @if($discountType==2) checked='checked' @endif name="discountType">&nbsp;Flat Rate
												</label>
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Discount Rate <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="discountRate" maxlength="100" id="discountRate" placeholder="Discount Rate" value="{{ $discountRate }}" />
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
