@extends('adminarea.home')
@section('content')
@include('adminarea.user.user-js')

<?php use App\Http\Models\User;
$userID=Input::get('userID')?Input::get('userID'):'0';
if($userID==0){
	$userID=old('userID')?old('userID'):'';	
}
$roleID=old('roleID')?old('roleID'):'';
$firstName=old('firstName')?old('firstName'):'';
$lastName=old('lastName')?old('lastName'):'';
$email=old('email')?old('email'):'';
$password=old('password')?old('password'):'';
$isActive=old('isActive')?old('isActive'):1;

$srach_firstName=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($userID != NULL && $userID >0)
{
	if(isset($getsingleUsers))
	{
		$roleID=$getsingleUsers->roleID;
		$firstName=$getsingleUsers->firstName;
		$lastName=$getsingleUsers->lastName;
		$email=$getsingleUsers->email;
		$password=$getsingleUsers->password;
		$isActive=$getsingleUsers->isActive;
	}
}

?>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        @if(session()->get('admin_role')==1)
        <li><a href="{{ url('/') }}/adminarea/user">User Management</a></li>
        @endif
        <li class="active">@if($userID != NULL && $userID >0) Edit @else Add @endif User </a></li>
    </ol>
    @include('adminarea.include.message')
    <form name="frm_user_addedit" id="frm_user_addedit"  action="{{ url('/') }}/adminarea/user/saveuser" method="post" class="form-horizontal" >
        <input type="hidden" class="form-control" name="userID" id="userID" value="{{ $userID }}">
        <input type="hidden" name="pageno" value="{{ $pageno }}" />
        <input type="hidden" name="srach_firstName" id="srach_firstName" value="{{ $srach_firstName }}" >
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
                        <h2>@if($userID != NULL && $userID >0) Edit @else Add @endif User </h2>
                    </div>
                 <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group">
                                            <input type="hidden"  name="propertyUniqueID" id="propertyUniqueID" maxlength="50" value="">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Role Name</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <select name="roleID" class="form-control">
                                                    <option value="">= = =Select Role= = =</option>
                                                    @foreach($getRole as $displayRole)
                                                        <option value="{{ $displayRole->roleID }}" @if($displayRole->roleID == $roleID)  selected="selected" @endif>{{ $displayRole->name }}</option>
                                                    @endforeach
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        	<label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">First Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input type="text" class="form-control" name="firstName" id="firstName" maxlength="100" value="{{ $firstName }}" placeholder="First Name">
                                        	</div>
                                        </div>
                                        <div class="form-group">
                                           <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Last Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="lastName" id="lastName" maxlength="100" value="{{ $lastName }}" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Email <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                @if($userID >0 && $userID == 1)
                                                 <input type="hidden" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email">
                                                 <input type="text" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email" disabled="disabled">
                                                 @else
                                                  <input type="text" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email">
                                                 @endif
                                            </div>
                                        </div>
                                        @if($userID == 0)
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Password <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="password" class="form-control" name="password" id="password" maxlength="100" placeholder="Password" value="{{ $password }}">
                                            </div>
                                        </div>
                                        @endif
                                        <input type="hidden" class="form-control" name="old_password" id="old_password" maxlength="100" value="{{ $password }}">
                                        <div class="form-group">
                                             <div class="col-sm-offset-2 col-sm-10">
                                             <div class="col-sm-6 col-md-6 col-xs-9">
                                               <label class="check_btn">
                                                  <input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1 || !$userID) checked='checked' @endif name="isActive"> IsActive?
                                                </label>
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