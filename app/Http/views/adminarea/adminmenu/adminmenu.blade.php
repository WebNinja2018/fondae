@extends('adminarea.home')
@section('content')
@include('adminarea.adminmenu.adminmenu-js')
<?php
    use App\Http\Models\Adminmenu;
	$menuID=Input::get('menuID')?Input::get('menuID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$menuName=Input::get('menuName')?Input::get('menuName'):'';
	$srch_menuParentID=Input::get('srch_menuParentID')?Input::get('srch_menuParentID'):'';
	$srch_status=Input::get('srch_status')? Input::get('srch_status'):'';
?>

<form class="form-inline" role="form" name="frm_adminmenu_list" method="post" action="{{ url('/') }}/adminarea/adminmenu/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="menuID" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Adminmenu Management</li>
    </ol>
    @include('adminarea.include.message')
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New Pages</a>
                        <?php /*?><a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a>
                        <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a>
                        <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a><?php */?>
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
                             <th style="width:5%;"><input name="checkall" id="checkall" value="" type="checkbox">
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
                             <th>Menu Name
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('firstName','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div> 
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('firstName','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                             <th>Link
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('lastName','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('lastName','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Display Order</th>
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
                                </div
                             ></th>
                        </thead>
                        <tbody>
						<?php $adminmenu= new Adminmenu;?>
                        @if(isset($data['recordcount'])) 
                        	<?php $no_row=1;?>
                            @foreach($data['qGetAllAdminmenu'] as $GetAllAdminmenu)
                                <?php $subTopMenu=$adminmenu->getAllParent($GetAllAdminmenu->menuID,'',session()->get('admin_role'));?>
                                <tr id="ID_{{ $GetAllAdminmenu->menuID }}" @if($GetAllAdminmenu->menuID==$menuID) class="bg-warning" @endif >
                                    <td  valign="top">
                                        <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllAdminmenu->menuID }}" type="checkbox" />
                                    </td>
                                    <td>
                                        <a href="javascript:fun_edit({{ $GetAllAdminmenu->menuID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="javascript:fun_single_delete({{ $GetAllAdminmenu->menuID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </td>
                                    <td>{{ $GetAllAdminmenu->menuName }}</td>
                                    <td>{{ $GetAllAdminmenu->menuLink }}</td>
                                    <td>{{ $GetAllAdminmenu->displayOrder }}</td>
                                    <td>
                                        <a href="javascript:fun_single_status({{ $GetAllAdminmenu->menuID }});">
                                            <span id="status_{{ $GetAllAdminmenu->menuID }}">
                                            @if($GetAllAdminmenu->isActive==1) Active @else Inactive @endif
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @if( $subTopMenu['rows']>0 )
                                    @foreach($subTopMenu['data'] as $GetSubAdminmenu)
                                        <tr id="ID_{{ $GetSubAdminmenu->menuID }}">
                                        <td  valign="top">
                                            <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetSubAdminmenu->menuID }}" type="checkbox" />
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetSubAdminmenu->menuID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetSubAdminmenu->menuID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td> <i class="glyphicon glyphicon-chevron-right"></i> {{ $GetSubAdminmenu->menuName }}</td>
                                        <td>{{ $GetSubAdminmenu->menuLink }}</td>
                                        <td>{{ $GetSubAdminmenu->displayOrder }}</td>
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetSubAdminmenu->menuID }});">
                                            	<span id="status_{{ $GetSubAdminmenu->menuID }}">
                                                    @if($GetSubAdminmenu->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <?php $no_row++;?> 
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style="text-align:center;">Record Not Found</td>
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