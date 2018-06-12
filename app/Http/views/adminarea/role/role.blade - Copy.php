@extends('adminarea.home')
@section('content')
@include('adminarea.role.role-js')

<?php
$roleID=Input::get('roleID')?Input::get('roleID'):'';
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$name=Input::get('srach_name')?Input::get('srach_name'):'';
$faqDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_role_list" method="post" action="{{ url('/') }}/adminarea/role/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="roleID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
  <section class="content-header top_header_content">
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Role Management</li>
        </ol>
        <div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
            <div class="advance_button">
                <a class="" href="javascript:;" onclick="funToggleSearch('Property');"><i class="fa fa-search"></i>&nbsp; Search</a>
            </div>
        </div>
    </section>
    <section class="content-header top_header_content" id="searchSectionProperty" style=" display:none;"> 
         <div class="box">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="search_box_col">
                        <div class="row">
                           <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                                    <ul class="pagination pagination-sm search_by_alphabetic">
                                       <li><a href="javascript:fun_roleSearch('')">All</a></li>
                                          @for($i=65;$i<=90;$i++)
                                              <li><a href="javascript:fun_roleSearch('{{ chr($i) }} ')">{{ chr($i) }}</a></li>
                                          @endfor
                                    </ul>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                        <?php /*?><div class="col-md-3 col-xs-3 col-sm-3">
                                             <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
                                                        <select class="form-control" name="searchByType" id="searchByType">
                                                            <option value="">-- Select Alphabetics--</option>
                                                            <option value="2">A</option>
                                                            <option value="1">B</option>
                                                            <option value="1">C</option>
                                                            <option value="1">D</option>
                                                            <option value="1">E</option>
                                                        </select>
                                                    </div>
                                                </div>
                                             </div>
                                         </div><?php */?>
                                         <div class="col-sm-3 col-md-3 col-xs-3">
                                            <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
                                                        <input type="text" name="srach_name" class="form-control" id="srach_name" value="{{ $name }}" placeholder="Role Name">
                                                    </div>
                                                </div>
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-xs-3 col-sm-3">
                                             <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
                                                        <select class="form-control" id="srch_status" name="srch_status">
                                                            <option value="">====SELECT====</option>
                                                            <option value="1" @if(@$_POST['srch_status']== "1") selected='selected' @endif>Active</option>
                                                            <option value="0" @if(@$_POST['srch_status']== "0") selected='selected' @endif>InActive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-xs-3 col-sm-3">
                                             <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
                                                        <div id="sandbox-container" class="date_for_search">
                                                            <input type="text" class="form-control" name="startDate" placeholder="Date From" value="{{ $faqDate }}" id="startDate">
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
                                                </div>
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-xs-3 col-sm-3">
                                             <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
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
                                                </div>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                            </div>
                           <div class="col-sm-12 col-md-12 col-xs-12">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <div class="col-md-3 col-xs-5">
                                             <div class="row">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <button type="button" class="btn btn-warning waves-effect waves-light" onclick="fun_search();">Search</button>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="fun_reset();">Reset</button> 
                                                    </div>
                                                </div>
                                             </div>
                                         </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer-->
           </div>
    </section>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp; Add New Role</a>
                        <a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a>
                        <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a>
                        <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
          <!-- strat box area-->
            <div class="box">
                <!-- start user management table-->
                <div class="table-responsive">
                  <table id="example" class="table-bordered table-striped table-hover table">
                        <thead>
                             <th style="width:4%;"><input name="checkall" id="checkall" value="" type="checkbox"></th>
                             <th>Actions</th>
                             <th>Role Name
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('name','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div> 
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('name','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                             <th>Status
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>View</th>
                        </thead>
                        <tbody>
						@if (($recordcount)>0)
                            @if(isset($recordcount)) <?php $no_row=1;?>
                                @foreach($qGetAllRole as $GetAllRole)
                                    <tr  id="ID_{{ $GetAllRole->roleID }}" @if($GetAllRole->roleID==$roleID) class="bg-warning" @endif>
                                        <td>
                                        	<input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllRole->roleID }}" type="checkbox" />
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetAllRole->roleID }} );" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetAllRole->roleID }} );"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td><?php echo $GetAllRole->name; ?></td>
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetAllRole->roleID }});">
                                                <span id="status_{{ $GetAllRole->roleID }}">
                                                    @if($GetAllRole->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllRole->roleID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.role.role-view')
                                        </td>
                                    </tr>
                                	<?php $no_row++;?> 
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
                <!-- end user management table-->
            </div>
            <div class="pagination_box" id="paggination">
            <nav aria-label="Page navigation">
              <ul class="pagination pull-right">
                <li>
                	 <?php /*?>{!! $qGetAllRole->render() !!}<?php */?>
                      @include('adminarea.pagination', ['paginator' => $qGetAllRole])
                </li>
              </ul>
            </nav>
        </div>
          <!-- strat box area-->
         </div>
      </div>
</section>
</form>
@endsection