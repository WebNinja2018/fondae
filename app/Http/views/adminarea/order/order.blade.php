@extends('adminarea.home')
@section('content')
<script type="text/javascript">
	function fun_emailset(formID)
	{
		frmobj=window.document.frm_order;
		frmobj.formID.value=formID;
		document.frm_order.action="{{ url('/') }}/adminarea/report/emailsetting";
		frmobj.submit();
	}
	
	function fun_single_delete(orderID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/order/ordersingledelete",
				data: "orderID=" + orderID,
				success: function(total){
				$("#ID_"+orderID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
	
	function fun_multipleDelete()
	{
	  var count = $(":checkbox:checked").length;
	  if(count > 0)
	  {
		  var status = confirm("Are you sure want to delete this record?");
		  if(status==true)
		  {
			  frmobj=window.document.frm_order;
			  frmobj.method.value="multipleDelete";
			  document.frm_order.action="{{ url('/') }}/adminarea/order";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}

	function fun_search(perpage)
	{
		var frmobj=window.document.frm_order;
		frmobj.submit();
	}
	
	function fun_reset()
	{
		var frmobj=window.document.frm_order;
		frmobj.srach_orderNumber.value='';
		frmobj.startDate.value='';
		frmobj.endDate.value='';
		frmobj.srch_status.value='';
		
		frmobj.action="{{ url('/') }}/adminarea/order";
		frmobj.submit();
	}
	
	function fun_userSearch(srach_orderNumber)
	{
		var frmobj=window.document.frm_order;
		frmobj.srach_orderNumber.value=srach_orderNumber;
		frmobj.action="{{ url('/') }}/adminarea/order";
		frmobj.submit();
	}
	
	/******************* CHECK ALL CHECKBOX *****************/
	jQuery(document).ready(function($)
	{
		$('#checkall').click(function()
		{
			$(':checkbox').each(function()
			{
				if(this.checked)
				{
					this.checked = false;
				}
				else
				{
					this.checked = true;
				}
			});
			return false;
		}); 
	});
	
	function fun_single_status(orderID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/ordersinglestatus",
			data: "orderID=" + orderID,
			success: function(result){
				if(result == 0)
				{
					$('#status_'+orderID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+orderID).html("Active");
				}
			}
		});
	}
	
	function fun_orderDetail(orderID,orderTypeID)
	{
		var frmobj=window.document.frm_order;
		frmobj.orderID.value=orderID;
		if(orderTypeID==1){
			frmobj.action="{{ url('/') }}/adminarea/order/orderDetail";
		}else{
			frmobj.action="{{ url('/') }}/adminarea/order/rewardDetail";
		}
		frmobj.submit();
	}
	
	function fun_orderstausNotes(orderstatusID,orderID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/order/changeOrderStatus",
			data: "orderID=" + orderID + "&orderstatusID="+orderstatusID,
			success: function(result){
				//alert(result);
				alert("Order status changed successfully!");
			}
		});
		//tb_show("<b>Order StatusNotes</b>","{{ url('/') }}/adminarea/order/orderstatusNotes?d=&c=order&m=orderstatusNotes&orderstatusID="+orderstatusID+"&orderID="+orderID+"&popup=true&KeepThis=true&height=200&width=400&TB_iframe=true");
	}
	
</script>

<?php
$orderID=Input::get('orderID')?Input::get('orderID'):'';
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$orderNumber=Input::get('srach_orderNumber')?Input::get('srach_orderNumber'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_order" id="frm_order" method="post" action="{{ url('/') }}/adminarea/order">
<input type="hidden" name="formID" value="4"  />
<input type="hidden" name="listPage" value="order" />
<input type="hidden" name="listPage_name" value="Order" />
<input type="hidden" value="" name="orderID" id="orderID" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" id="redirects_to" value="{{Request::fullUrl()}}" />

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Donation</li>
    </ol>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_emailset(5);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp;&nbsp;Email Setting</a>
                        <a class="add_edit_btn" href="javascript:;" onclick="funToggleSearch('Order');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
    <section class="content-header top_header_content" id="searchSectionOrder" @if(Session::get('searchSectionOrder')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <?php /*?><ul class="pagination pagination-sm search_by_alphabetic">
                               <li><a href="javascript:fun_contactusSearch('')">All</a></li>
                                  @for($i=65;$i<=90;$i++)
                                      <li><a href="javascript:fun_contactusSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                  @endfor
                            </ul><?php */?>
                            <div class="form-group">
                                <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="text" name="srach_orderNumber" class="form-control" id="srach_orderNumber" value="{{ $orderNumber }}" placeholder="Donation Number">
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
								<?php /*?><div class="col-sm-2 col-md-2 col-xs-2">
                                    <label class="sr-only" for="exampleInputEmail2">Status</label>
                                    <select class="form-control" id="orderstatusID" name="srch_status">
                                        <option value="">==SELECT STATUS====</option>
                                          @foreach($orderStausName as $statusName)
                                            <option value="{{$statusName->orderstatusID}}" @if($statusName->orderstatusID==$srch_status) selected="selected" @endif >{{$statusName->orderName}}</option>
                                          @endforeach
                                    </select>
                                 </div><?php */?>
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
	<section class="content-header top_header_content">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <!-- start user management table-->
                <div class="table-responsive">
                  <table id="example" class="table-bordered table-striped table-hover table">
                        <thead>
                             <th style="width:5%;"><input name="checkall" id="checkall" value="" type="checkbox">
                                <div class="dropdown" style="float:right;">
                                  <a href="#" data-toggle="dropdown">
                                  <span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="javascript:fun_multipleDelete();" ><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                  </ul>
                                </div>
                             </th>
                             <th width="1%">Actions</th>
							 <th >Donation Number</th>
                             <th >Member Name</th>
                             <th >Product Name</th>
                             <th width="10%">Grand Total</th>
                    		 <th width="10%">Created Date</th>
                             <th width="5%">View</th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount)) <?php $no_row=1; //print_r($qGetAllorder);?>
                                @foreach($qGetAllorder as $GetAllOrder)
                                    <tr  id="ID_{{ $GetAllOrder->orderID }}" @if($GetAllOrder->orderID==$orderID) class="bg-warning" @endif>
                                        <td>
                                            <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllOrder->orderID }}" type="checkbox" />
                                        </td>
                                        <td>
                                           <a href="javascript:fun_single_delete({{ $GetAllOrder->orderID }});"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
										<td>{{ $GetAllOrder->orderNumber }}</td>
                                        <td>{{ $GetAllOrder->firstName }} {{ $GetAllOrder->lastName }}</td>
                                        <td>{{ $GetAllOrder->productName }}</td>
                                        <td><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format($GetAllOrder->grandTotal,2) }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllOrder->created_at)) }}</td>
										<td align="center">
											<a class="glyphicon glyphicon-eye-open" href="" data-toggle="modal" data-target="#myModal_{{$GetAllOrder->orderID}}" onclick="fun_orderDetail({{ $GetAllOrder->orderID}},{{ $GetAllOrder->eventType}});"></a> &nbsp;&nbsp;
                             			</td>
                                    </tr>
                                    <?php $no_row++;?> 
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <td colspan="13" align="center">Record not found.</td>
                            </tr>
                        @endif
                                
                        </tbody>
                  </table>
                </div>
                <!-- end user management table-->
                <div class="pagination_box" id="paggination">
                    <nav aria-label="Page navigation">
                         <?php /*?>{!! $GetAllOrder->render() !!}<?php */?>
                          @include('adminarea.pagination', ['paginator' => $qGetAllorder])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
          </div>
    </section>
 </form>
@endsection