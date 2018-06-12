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
$isActive=old('isActive')?old('isActive'):'';
$srach_firstName=old('srach_firstName')?old('srach_firstName'):'';
$startDate=old('startDate')? date('m/d/Y',strtotime(old('startDate'))):'';
$endDate=old('endDate')? date('m/d/Y',strtotime(old('endDate'))):'';
$srch_status=old('srch_status')?old('srch_status'):'';


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
    <div class="right_side" role="main">
		<div class="center_container">
			<ul class="breadcrumb">
			  <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
			  <li><a href="{{ url('/') }}/adminarea/user">User Management</a></li>
			  <li class="active">@if($userID != NULL && $userID >0) Edit @else Add @endif User </a></li>
			</ul>
		</div>
        <div class="panel row">
          <div class="panel-body">
            <div class="col-md-13" role="main">
                <div class="panel panel-default">
                	  @include('adminarea.include.message')
                      <div class="panel-heading">
                        <h3 class="panel-title">@if($userID != NULL && $userID >0) Edit @else Add @endif User </a></h3>
                      </div>
                      <div class="col-md-12" role="main">
                        <form name="frm_user_addedit" id="frm_user_addedit"  action="{{ url('/') }}/adminarea/user/saveuser" method="post" class="form-horizontal" >
                            <input type="hidden" class="form-control" name="userID" id="userID" value="{{ $userID }}">
                            <input type="hidden" name="pageno" value="{{ $pageno }}" />
                            <input type="hidden" name="srach_firstName" id="srach_firstName" value="{{ $srach_firstName }}" >
                            <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status }}" >
                            <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}" >
                            <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}" >
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                             <div class="tab-content">
                                    <!--================================User Form Start=====================================-->
                                      <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">&nbsp;</label>
                                        <div class="col-md-4">&nbsp;</div>
                                      </div>
                                      <div class="form-group">
                                        <label for="role" class="col-sm-2 control-label">Role Name: *</label>
                                        <div class="col-md-3">
                                          <select name="roleID" class="form-control">
                                          		<option value="">= = =Select Role= = =</option>
                                                @foreach($getRole as $displayRole)
                                                	<option value="{{ $displayRole->roleID }}" @if($displayRole->roleID == $roleID)  selected="selected" @endif>{{ $displayRole->name }}</option>
                                                @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="firstName" class="col-sm-2 control-label">First Name *</label>
                                        <div class="col-md-4">
                                          <input type="text" class="form-control" name="firstName" id="firstName" maxlength="100" value="{{ $firstName }}" placeholder="First Name">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="lastName" class="col-sm-2 control-label">Last Name *</label>
                                        <div class="col-md-4">
                                          <input type="text" class="form-control" name="lastName" id="lastName" maxlength="100" value="{{ $lastName }}" placeholder="Last Name">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email *</label>
                                        <div class="col-md-3">
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
                                        <label for="password" class="col-sm-2 control-label">Password *</label>
                                        <div class="col-md-3">
                                          <input type="password" class="form-control" name="password" id="password" maxlength="100" placeholder="Password" value="{{ $password }}">
                                        </div>
                                      </div>
                                      @endif
                                      <input type="hidden" class="form-control" name="old_password" id="old_password" maxlength="100" value="{{ $password }}">
                                      <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                          <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value="1" @if($isActive==1 || !$userID) checked='checked' @endif name="isActive"> IsActive?
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                          <button type="submit" class="btn btn-default btn-primary">Submit</button>
                                          <button class="btn btn-default" type="button" onclick="fun_back()">Back</button>
                                        </div>
                                      </div>
                                    <!--================================User Form Start=====================================-->
                             </div>
                            </form>
                        </div>
                </div>
             </div>
          </div>
        </div>
    </div>
@endsection