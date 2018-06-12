@extends('adminarea.home')
@section('content')
@include('adminarea.staff.staff-js')

<?php
	//dd($_POST);
	$staffID=Input::get('staffID')?Input::get('staffID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_staff_list" id="frm_staff_list" method="post" action="{{ url('/') }}/adminarea/staff/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="staffID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Staff Management</li>
    </ol>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New Staff</a>
						<a href="javascript:fun_changeOrder();" class="add_edit_btn"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Display Order</a>
                        <a class="add_edit_btn" href="#" id="advance_search" onclick="funToggleSearch('Staff');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content" id="searchSectionStaff" @if(Session::get('searchSectionStaff')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                              <li><a href="javascript:fun_staffSearch('')">All</a></li>
                              @for($i=65;$i<=90;$i++)
                                  <li><a href="javascript:fun_staffSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                              @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                     <input type="text" name="srach_name" class="form-control" id="srach_name" value="{{ $srach_name }}" placeholder="Staff Name">
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <select class="form-control" id="srch_status" name="srch_status">
                                        <option value="">====SELECT====</option>
                                        <option value="1" @if(@$_POST['srch_status']== "1") selected='selected' @endif>Active</option>
                                        <option value="0" @if(@$_POST['srch_status']== "0") selected='selected' @endif>InActive</option>
                                    </select>
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <div id="sandbox-container" class="date_for_search">
                                        <input type="text" class="form-control" name="startDate" placeholder="Date From" value="{{ $startDate }}" id="startDate">
                                    </div>
                                    <script type="text/javascript">
                                          $('#startDate').datepicker({
                                          multidateSeparator: "dd-mm-yyyy",
                                          keyboardNavigation: false,
                                          forceParse: false
                                          });
                                    </script>
                                    <span class="input-group-addon date_icon"><i class="glyphicon glyphicon-calendar"></i></span>
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <div id="sandbox-container" class="date_for_search">
                                        <input class="form-control" type="text" name="endDate" placeholder="Date To" value="{{ $endDate }}" id="endDate">
                                    </div>
                                    <script type="text/javascript">
                                        $('#endDate').datepicker({
                                        multidateSeparator: "dd-mm-yyyy",
                                        keyboardNavigation: false,
                                        forceParse: false
                                        });
                                    </script>
                                    <span class="input-group-addon date_icon"><i class="glyphicon glyphicon-calendar"></i></span>
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <button type="button" class="btn btn-warning waves-effect waves-light" onclick="fun_search();">Search</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="fun_reset();">Reset</button> 
                             	</div>
                             </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer-->
           </div>
    </section>
	<!--strat section Main content -->
	<section class="content-header top_header_content">
		<div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="row">
                <!-- start staff management table-->
                <div class="table-responsive">
                  <table id="example" class="table-bordered table-striped table-hover table">
                        <thead>
                             <th ><input name="checkall" id="checkall" value="" type="checkbox">
                                <div class="dropdown" style="float:right;">
                                  <a href="#" data-toggle="dropdown">
                                  <span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="javascript:fun_active_inactive(1);"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a></li>
                                      <li><a href="javascript:fun_active_inactive(0);" ><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a></li>
                                      <li><a href="javascript:fun_multipleDelete();" ><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                  </ul>
                                </div>
                             </th>
                             <th>Actions</th>
                             <th>Name 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('firstname','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('firstname','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                              
                              <th>Position  
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('position','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('position','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Email  
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('email','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('email','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Phone  
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('telephone','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('telephone','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Display Order
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('displayOrder','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('displayOrder','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Created Date
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('created_at','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('created_at','ASC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Status
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs1-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs1-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>
                                 View
                             </th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount))<?php $no_row=1; ?>
                                @foreach($qGetAllStaff as $GetAllStaff)
                                    <tr id="ID_{{ $GetAllStaff->staffID }}" @if($GetAllStaff->staffID==$staffID) class="bg-warning" @endif>
                                        <td>
                                            @if($GetAllStaff->staffID !=1)
                                                <input class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllStaff->staffID }}" type="checkbox" />
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetAllStaff->staffID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetAllStaff->staffID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllStaff->firstname }} {{ $GetAllStaff->lastname }}</td>
                                        <td>{{ $GetAllStaff->position }}</td>
                                        <td>{{ $GetAllStaff->email }}</td>
                                        <td>{{ $GetAllStaff->telephone }}</td>
                                        <td>{{ $GetAllStaff->displayOrder }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllStaff->created_at)) }}</td>
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetAllStaff->staffID }});">
                                                <span id="status_{{ $GetAllStaff->staffID }}">
                                                    @if($GetAllStaff->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td><a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllStaff->staffID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.staff.staff-view')
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @else
                          <tr>
                            <td colspan="7" align="center">Record not found.</td>
                          </tr>
                        @endif
                        </tbody>
                  </table>
                </div>
                <!-- end staff management table-->
                <div class="pagination_box" id="paggination">
                    <nav aria-label="Page navigation">
						<?php /*?>{!! $qGetAllStaff->render() !!}<?php */?>
                        @include('adminarea.pagination', ['paginator' => $qGetAllStaff])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
		  </div>
	</section>
</form> 
@endsection