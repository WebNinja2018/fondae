@extends('adminarea.home')
@section('content')
@include('adminarea.role.role-js')

<?php use App\Http\Models\Role;
$roleID=Input::get('roleID')?Input::get('roleID'):'0';
if($roleID==0){
	$roleID=old('roleID')?old('roleID'):'';	
}
$name=old('name')?old('name'):'';
$isActive=old('isActive')?old('isActive'):1;

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($roleID != NULL && $roleID >0)
{
	if(isset($getsingleRole))
	{
		$name=$getsingleRole->name;
		$isActive=$getsingleRole->isActive;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/role">Role Management</a></li>
        <li class="active">@if($roleID != NULL && $roleID >0) Edit @else Add @endif Role </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_role_addedit" id="frm_role_addedit"  action="{{ url('/') }}/adminarea/role/saverole" method="post" class="form-horizontal" >
        <input type="hidden" class="form-control" name="roleID" id="roleID" value="{{ $roleID }}">
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
                        <h2>@if($roleID != NULL && $roleID >0) Edit @else Add @endif Role</h2>
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
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Role <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="name" id="name" maxlength="50" value="{{ $name }}" placeholder="Role Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left"></label>
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
@endsection
