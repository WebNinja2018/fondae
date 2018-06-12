@extends('adminarea.home')
@section('content')
@include('adminarea.user.user-js')

<?php
	$userID=Input::get('userID')?Input::get('userID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$firstName=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form class="form-inline" role="form" name="frm_user_list" method="post" action="{{ url('/') }}/adminarea/user/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="userID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<div class="col-sm-12 col-md-12 col-xs-12 main_content_area">
	<div class="row">
    	<section class="content-header top_header_content">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
                <li class="active">User Management</li>
            </ol>
            <div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
                <div class="advance_button">
                    <a href="javascript:;" onclick="funToggleSearch('User')" class="search_icon"><i class="fa fa-search" title="Search"></i>&nbsp; Search</a>
                </div>
            </div>
        </section>
    	
    
    
    
        <div class="center_container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
                <li class="active">User Management</li>
                <a href="javascript:;" onclick="funToggleSearch('User')" class="search_icon"><label>Search</label>&nbsp;<i class="fa fa-search" title="Search"></i></a>
            </ul>
        </div>
            
            
            
            <div class="panel row">
                <div class="panel-body">
                <div class="col-md-13" role="main">
                @include('adminarea.include.message')
                <div class="panel panel-default" id="searchSectionUser" @if( (!Session::get('searchSectionRole')) || (Session::get('searchSectionRole') && Session::get('searchSectionRole')==0) ) style="display:none" @endif >
                <div class="panel-heading">
                <h3 class="panel-title">Search Area
                <a class="pull-right" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></a>
                </h3>
                </div>
                <div class="collapse in" id="collapseExample">
                <div class="col-md-12" role="main">
                <ul class="pagination pagination-sm">
                <li><a href="javascript:fun_userSearch('')">All</a></li>
                @for($i=65;$i<=90;$i++)
                <li><a href="javascript:fun_userSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                @endfor
                </ul>
                </div>
                
                <div class="col-md-12" role="main">
                <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">First Name</label>
                <input type="text" name="srach_firstName" class="form-control" id="srach_firstName" value="{{ $firstName }}" placeholder="First Name">
                </div>
                <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">Status</label>
                <select class="form-control" id="exampleInputEmail2" name="srch_status">
                <option value="">====SELECT====</option>
                <option value="1" @if(@$_POST['srch_status']== "1") selected='selected' @endif>Active</option>
                <option value="0" @if(@$_POST['srch_status']== "0") selected='selected' @endif>InActive</option>
                </select>
                </div>
                <div class="form-group">
                <div class="input-group">
                <div id="sandbox-container">
                <input type="text" class="form-control" name="startDate" placeholder="Date From" value="{{ $startDate }}" id="startDate">
                </div>
                <script type="text/javascript">
                $('#startDate').datepicker({
                multidateSeparator: "dd-mm-yyyy",
                keyboardNavigation: false,
                forceParse: false
                });
                </script>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                </div>
                <div class="form-group">
                <div class="input-group">
                <div id="sandbox-container">
                <input class="form-control" type="text" name="endDate" placeholder="Date To" value="{{ $endDate }}" id="endDate">
                </div>
                <script type="text/javascript">
                $('#endDate').datepicker({
                multidateSeparator: "dd-mm-yyyy",
                keyboardNavigation: false,
                forceParse: false
                });
                </script>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                </div>
                </div>   
                <div class="col-md-12" role="main">
                &nbsp;
                </div>    
                <div class="col-md-12" role="main">
                <button type="button" class="btn btn-default" onclick="fun_search();">Search</button>
                <button type="button" class="btn btn-default" onclick="fun_reset();">Reset</button> 
                </div>
                <div class="col-md-12" role="main">
                &nbsp;
                </div>
                </div>
                </div>
                <div class="main_row">
                <div class="btn-group">
                <a href="javascript:fun_edit(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add New User</a>
                <a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Active</a>
                <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Inactive</a>
                <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Delete</a>
                </div>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered">
                <tr>
                <th width="1%">
                <input name="checkall" id= "checkall" value="" type="checkbox" />
                </th>
                <th width="2%">Actions</th>
                <th width="15%">First Name 
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('firstName','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('firstName','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="12%">Last Name
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('lastName','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('lastName','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="5%">Role
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('name','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('name','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="20%">Email
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('email','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('email','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="12%">Created Date
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('user.createdDate','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('user.createdDate','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="8%">Status
                <div class="pull-left">
                <div class="col-md-12">
                <a href="javascript:fun_upDown('isActive','ASC');"><i class="fa fa-caret-up" title="Ascending"></i></a>
                </div>
                <div class="col-md-12">
                <a href="javascript:fun_upDown('isActive','DESC');"><i class="fa fa-caret-down" title="Descending"></i></a>
                </div>
                </div>
                </th>
                <th width="5%">View</th>
                </tr>
                
                @if (($recordcount)>0)
                @if(isset($recordcount)) 
                <?php $no_row=1; ?>
                @foreach($qGetAllUser as $GetAllUser)
                <tr id="ID_{{ $GetAllUser->userID }}" @if($GetAllUser->userID==$userID) class="bg-warning" @endif>
                <td  valign="top">
                @if($GetAllUser->userID !=1)
                <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllUser->userID }}" type="checkbox" />
                @endif
                </td>
                <td>
                <a class="glyphicon glyphicon-pencil" href="javascript:fun_edit({{ $GetAllUser->userID }});" title="Edit"></a>&nbsp;&nbsp;
                @if($GetAllUser->userID !=1)
                <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete({{ $GetAllUser->userID }});" title="Delete"></a>
                @endif
                </td>
                
                <td>{{ $GetAllUser->firstName }}</td>
                <td>{{ $GetAllUser->lastName }}</td>
                <td>{{ $GetAllUser->name }}</td>
                <td>{{ $GetAllUser->email }}</td>
                <td>{{ date('m/d/Y',strtotime($GetAllUser->created_at)) }}</td>
                <td>
                @if($GetAllUser->userID ==1)
                <span id="status_{{ $GetAllUser->userID }}">
                @if($GetAllUser->isActive==1) Active @else Inactive @endif
                </span>
                @else
                <a href="javascript:fun_single_status({{ $GetAllUser->userID }});">
                <span id="status_{{ $GetAllUser->userID }}">
                @if($GetAllUser->isActive==1) Active @else Inactive @endif
                </span>
                </a>
                @endif
                </td>
                <td>
                <a class="glyphicon glyphicon-eye-open" href="" data-toggle="modal" data-target="#myModal_{{ $GetAllUser->userID }}" title="View"></a>
                @include('adminarea.user.user-view')
                </td>
                </tr>
                <?php $no_row++; ?> 
                @endforeach
                @endif
                @else
                <tr>
                <td colspan="7" align="center">Record not found.</td>
                </tr>
                @endif
                </table>
                </div>
                </div>
                <div class="main_row">
                <ul class="pagination pagination-sm">
                <?php /*?>{!! $qGetAllUser->render() !!}<?php */?>
                @include('adminarea.pagination', ['paginator' => $qGetAllUser])
                </ul>
                </div>
                </div>
            </div>
	</div>

</div>


</form>

@endsection