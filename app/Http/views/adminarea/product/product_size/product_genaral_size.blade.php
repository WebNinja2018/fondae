@extends('adminarea.home')
@section('content')
@include('adminarea.product.product-js')

<?php
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$sizeID=Input::get('sizeID')?Input::get('sizeID'):'';
$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>
<form role="form" name="frm_product_generalsize_list" id="frm_product_generalsize_list" method="post" action="{{ url('/') }}/adminarea/product/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="sizeID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <section class="content-header top_header_content">
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Product Genaral Size Management</li>
        </ol>
        <?php /*?><div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
            <div class="advance_button">
                <a class="" href="#" id="advance_search" onclick="funToggleSearch('Property');"><i class="fa fa-search"></i>&nbsp; Search</a>
            </div>
        </div><?php */?>
    </section>
    
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New Product</a>
						<a href="javascript:fun_changeOrder();" class="add_edit_btn"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Display Order</a>
                        <a class="add_edit_btn" href="#" id="advance_search" onclick="funToggleSearch('ProductGenaralSize');"><i class="fa fa-search"></i>&nbsp; Search</a>
                        <?php /*?><a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a>
                        <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a>
                        <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a><?php */?>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content" id="searchSectionProductGenaralSize" @if(Session::get('searchSectionProductGenaralSize')!= 1) style=" display:none;" @endif> 
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
                                      <li><a href="javascript:fun_productSearch('')">All</a></li>
                                      @for($i=65;$i<=90;$i++)
                                          <li><a href="javascript:fun_productSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                      @endfor
                                    </ul>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                	<div class="col-sm-12 col-md-12 col-xs-12">
                                         <div class="col-sm-3 col-md-3 col-xs-3">
                                            <div class="row">
                                                <div class="col-md-10 col-xs-10 col-sm-10">
                                                    <div class="row">
                                                        <input type="text" name="srach_name" class="form-control" id="srach_name" value="{{ $srach_name }}" placeholder="Product Title">
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
                               		<div class="col-md-3 col-xs-5 col-sm-3">
                                         <div class="row">
                                            <div class="col-md-11 col-sm-11 col-xs-12">
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
	<!--strat section Main content -->
	<section class="content-header top_header_content">
		<div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="row">
              <!-- strat box area-->
                <div class="box">
                    <!-- start product management table-->
                    <div class="table-responsive data_view_table">
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
                                 <th>Size Name
                                        <div class="pull-left">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <a href="javascript:;" onclick="fun_upDown('sizeName','ASC');" class="asc_desc_icon" >
                                                    <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <a href="javascript:;" onclick="fun_upDown('sizeName','DESC');" class="asc_desc_icon">
                                                    <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                                </a>
                                            </div>
                                        </div>
                                  </th>
                                  <th>Size Number 
                                        <div class="pull-left">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <a href="javascript:;" onclick="fun_upDown('sizeNumber','ASC');" class="asc_desc_icon" >
                                                    <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <a href="javascript:;" onclick="fun_upDown('sizeNumber','DESC');" class="asc_desc_icon">
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
                            @if (($generalProductSizeRecordCount)>0)
                                @if(isset($generalProductSizeRecordCount))<?php $no_row=1; ?>
                                    @foreach($qGetGeneralProductSizeData as $resultGeneralProductSizeData)
                                        <tr id="ID_{{ $resultGeneralProductSizeData->sizeID }}" @if($resultGeneralProductSizeData->sizeID==$sizeID) class="bg-warning" @endif>
                                            <td>
                                                <input class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $resultGeneralProductSizeData->sizeID }}" type="checkbox" />
                                            </td>
                                            <td>
                                                <a href="javascript:fun_edit({{ $resultGeneralProductSizeData->sizeID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="javascript:fun_single_delete({{ $resultGeneralProductSizeData->sizeID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                            <td>{{ $resultGeneralProductSizeData->sizeName; }}</td>
                        					<td>{{ $resultGeneralProductSizeData->sizeNumber; }}</td>
                                            <td>
                                                <a href="javascript:fun_single_status({{ $GetAllProduct->productID }});">
                                                    <span id="status_{{ $GetAllProduct->productID }}">
                                                        @if($resultGeneralProductSizeData->isActive==1) Active @else Inactive @endif
                                                    </span>
                                                </a>
                                            </td>
                                            <td><a class="glyphicon glyphicon-eye-open" href="javascript:fun_viewproductdetail(<?php echo $resultGeneralProductSizeData->sizeID; ?>);"  title="View Details"></a>
                                                <?php /*?>@include('adminarea.product.product-view')<?php */?>
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
                    <!-- end product management table-->
                </div>
                <div class="pagination_box" id="paggination">
                <nav aria-label="Page navigation">
                  <ul class="pagination pull-right">
                    <li>
                        <?php /*?>{!! $qGetAllProduct->render() !!}<?php */?>
                        @include('adminarea.pagination', ['paginator' => $qGetGeneralProductSizeData])
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