@extends('adminarea.home')
@section('content')
@include('adminarea.product.product-js')

<?php
	$productID=Input::get('productID')?Input::get('productID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_product_list" method="post" action="{{ url('/') }}/adminarea/product/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="productID" />
<input type="hidden" value="{{$CategorytypeID}}" name="CategorytypeID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
		@if($CategorytypeID == Config::get('config.packageCategorytypeID','12'))
			<li class="active">Package Management</li>
		@else
        	<li class="active">Event Management</li>
		@endif
        
    </ol>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New Campaign</a>
						<?php /*?><a href="javascript:fun_changeOrder();" class="add_edit_btn"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Display Order</a><?php */?>
                        <a class="add_edit_btn" href="#" id="advance_search" onclick="funToggleSearch('Product');"><i class="fa fa-search"></i>&nbsp; Search</a>
                        <?php /*?><a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a>
                        <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a>
                        <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a><?php */?>
						<a class="add_edit_btn" href="##" ><b>Drag &amp; Drop</b> boxes to reorder your Event.</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content" id="searchSectionProduct" @if(Session::get('searchSectionProduct')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                             <ul class="pagination pagination-sm search_by_alphabetic">
                                  <li><a href="javascript:fun_productSearch('')">All</a></li>
                                  @for($i=65;$i<=90;$i++)
                                      <li><a href="javascript:fun_productSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                  @endfor
                                </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="text" name="srach_name" class="form-control" id="srach_name" value="{{ $srach_name }}" placeholder="Event Title">
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
                                 <div class="col-md-2 col-xs-2 col-sm-2">
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
                             <th>Event Name 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('productName','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('productName','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                              <?php /*?><th>Event Number 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('itemnumber','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('itemnumber','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th><?php */?>
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
							  <th>Conference Date
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('productDate','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('productDate','DESC');" class="asc_desc_icon">
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
                                            <a href="javascript:;" onclick="fun_upDown('created_at','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                              @if(Session::get('admin_role')==1)	
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
                             @endif
                             <th>View</th>
                        </thead>
						<tbody id="sortable">
						
                        @if (($recordcount)>0)
                            @if(isset($recordcount))<?php $no_row=1; ?>
                                @foreach($qGetAllProduct as $GetAllProduct)
                                    <?php $isShow=1;?>
                                    <?php if($GetAllProduct->isDraft==1){if($GetAllProduct->createdBy!=Session::get('admin_user')){$isShow=0;}}?>
                                    @if($isShow==1)
                                    <tr id="ID_{{ $GetAllProduct->productID }}" @if($GetAllProduct->productID==$productID) class="bg-warning" @endif>
                                        <td>
                                            <input class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllProduct->productID }}" type="checkbox" />
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetAllProduct->productID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetAllProduct->productID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllProduct->productName }}</td>
                                        <?php /*?><td>{{ $GetAllProduct->itemnumber }}</td><?php */?>
										<td id="displayOrder_{{ $GetAllProduct->productID }}">{{ $GetAllProduct->displayOrder }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllProduct->productDate)) }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllProduct->created_at)) }}</td>
                                         @if(Session::get('admin_role')==1)	
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetAllProduct->productID }});">
                                                <span id="status_{{ $GetAllProduct->productID }}">
                                                    @if($GetAllProduct->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        @endif
                                        <td><a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllProduct->productID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.product.product-view')
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                        @else
                          <tr>
                            <td colspan="8" align="center">Record not found.</td>
                          </tr>
                        @endif
                        </tbody>
                  </table>
                </div>
                <!-- end product management table-->
                <div class="pagination_box" id="paggination">
                    <nav aria-label="Page navigation">
						<?php /*?>{!! $qGetAllProduct->render() !!}<?php */?>
                        @include('adminarea.pagination', ['paginator' => $qGetAllProduct])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
		  </div>
	</section>
</form> 
<script type="text/javascript" src="{{ url('/components/js/jquery-ui_drop.js') }}"></script>
<script type="text/javascript">
    $(function() {
     function stopCallback(event, ui) {
			  var myOrder =  $(this).sortable('toArray').toString().split("ID_").join("");
			  $.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/product/saveorder",
				data: 'item='+myOrder,
				success: function(data)
				{
					var array = myOrder.split(",");
					var count=1;
					for (index = 0; index < array.length; ++index) {
					
						$('#displayOrder_'+array[index]).html(count);
						count++;
					}
					//$( "#sortable" ).load(window.location.href + " .faq_category" );
					//location.reload();
				}
				});
				setTimeout(function(){
				  $(".flash").slideUp("slow", function () {
				  $(".flash").hide();
				}); }, 3000);
    }

    $("#sortable").sortable({
        stop: stopCallback
    }).disableSelection();
});
</script>
@endsection