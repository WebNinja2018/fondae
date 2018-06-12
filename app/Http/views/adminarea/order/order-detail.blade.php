@extends('adminarea.home')
@section('content')
<?php use App\Http\Models\Customer; ?>
<script type="text/javascript">
	function printDiv(divName) /*Print Funation*/
	{
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#description').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<ol class="breadcrumb">
	<li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="##"> Donation</a></li>
    <li class="active">Donation Detail</li>
</ol>

<section class="content-header top_header_content">
    <div class="box">
        <div class="property_add">
            <div class="box-title with-border">
           		<h2 class="col-sm-6 text-left">Donation Detail</h2><div class="col-sm-6 control-label text-right" style="float:right"><a href="javascript:printDiv('printableArea');" class="btn btn-default btn-warning "><span>Print Invoice</span></a>&nbsp;&nbsp;<?php /*?><a href="{{ URL::previous() }}" class="btn btn-default btn-warning "><span>< Back</span></a><?php */?></div>
           	</div>
            <div class="addunit_forms" id="printableArea">
                <div class="box-body">
               		<div class="form-group">
                    	<div class="col-sm-9 col-xs-9 col-md-9">
                        	<div class="row">
                                <label class="col-sm-6 col-md-6 col-xs-12 control-label text-left">Donation Number : <a href="##">{{$qGetOrderlist[0]->orderNumber}}</a></label>
                                <label class="col-sm-6 col-md-6 col-xs-12 control-label text-left">Donation Date :<span> {{date('m/d/Y',strtotime($qGetOrderlist[0]->created_at))}}</span></label>
                                <?php /*?><label class="col-sm-3 col-md-3 col-xs-12 control-label text-left">Order Status : <span> {{$qGetOrderlist[0]->orderName}} </span></label><?php */?>
                        	</div>
                        </div>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-12 col-xs-12 col-md-12">
							<div class="row">
                            	<div class="col-sm-8 col-xs-8 col-md-8">
                                   <div class="table-responsive data_view_table">
                                      <table id="example" class="table-bordered table-striped table-hover table">
                                            <thead>
                                            	<tr>
													<th colspan="2">Customer Detail</th> 
                                            	</tr>
                                             </thead>
                                             <tbody>
                                             	<tr>
                                                	<td style="width:30%;"><label class="control-label text-left">Member Name </label></td>
                                                    <td>{{ $qGetOrderlist[0]->firstName }} {{ $qGetOrderlist[0]->lastName }}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:30%;"><label class="control-label text-left">Email</label></td>
                                                    <td>{{ $qGetOrderlist[0]->email }}</td>
                                                </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                </div>                     	
                             </div>
							<br />
                        	<div class="row">
                            	<?php /*?><div class="col-sm-6 col-md-6 col-xs-6">
                                 @if($shippingAddressRecordCount>0)
                                   <div class="table-responsive data_view_table">
                                      <table id="example" class="table-bordered table-striped table-hover table">
                                            <thead>
                                            	<tr>
													<th>Shipping Address</th> 
                                                 	<th style="text-align:center;">{{$qGetShippingAddressData[0]->firstName}} {{$qGetShippingAddressData[0]->lastName}}</th> 
                                            	</tr>
                                             </thead>
                                             <tbody>
                                             	<tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Address 1 </label></td>
                                                    <td>{{$qGetShippingAddressData[0]->address1}}</td>
                                                </tr>
                                                @if(strlen($qGetShippingAddressData[0]->address2)>0)
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Address 2</label></td>
                                                    <td>{{$qGetShippingAddressData[0]->address2}}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Country </label></td>
                                                    <td>{{$qGetShippingAddressData[0]->countryName}}, {{$qGetShippingAddressData[0]->zipcode}}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">State </label></td>
                                                    <td>{{$qGetShippingAddressData[0]->stateName}}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">City</label></td>
                                                    <td> {{$qGetShippingAddressData[0]->city}}</td>
                                                </tr>
                                                @if(strlen($qGetShippingAddressData[0]->phone)>0)
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Phone</label></td>
                                                    <td>  {{$qGetShippingAddressData[0]->phone}}</td>
                                                </tr>
                                                @endif
                                             </tbody>
                                         </table>
                                     </div>
                                 @endif
                                 </div><?php */?>
                                 <div class="col-sm-6 col-md-6 col-xs-6">
                                 @if($billingAddressRecordCount>0)
                                 	<div class="table-responsive data_view_table">
                                      <table id="example" class="table-bordered table-striped table-hover table">
                                            <thead>
                                            	<tr>
													<th>Billing Address</th> 
                                                 	<th style="text-align:center;">{{$qGetBillingAddressData[0]->firstName}} {{$qGetBillingAddressData[0]->lastName}}</th> 
                                            	</tr>
                                             </thead>
                                             <tbody>
                                             	<tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Address 1 </label></td>
                                                    <td>{{$qGetBillingAddressData[0]->address1}}</td>
                                                </tr>
                                                @if(strlen($qGetShippingAddressData[0]->address2)>0)
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Address 2</label></td>
                                                    <td>{{$qGetBillingAddressData[0]->address2}}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Country </label></td>
                                                    <td>{{$qGetBillingAddressData[0]->countryName}}, {{$qGetBillingAddressData[0]->zipcode}}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">State </label></td>
                                                    <td>{{$qGetBillingAddressData[0]->stateName}}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">City</label></td>
                                                    <td> {{$qGetBillingAddressData[0]->city}}</td>
                                                </tr>
                                                @if(strlen($qGetBillingAddressData[0]->phone)>0)
                                                <tr>
                                                	<td style="width:25%;"><label class="control-label text-left">Phone</label></td>
                                                    <td>  {{$qGetBillingAddressData[0]->phone}}</td>
                                                </tr>
                                                @endif
                                             </tbody>
                                         </table>
                                     </div>
                                 @endif
                                </div>                       	
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-12 col-xs-12 col-md-12">
                             <div class="table-responsive">
                              <table class="table table-striped table-hover table-bordered">
                              	 <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Event Detail</th>
                                        <th>QTY</th>
                                        <th style="width:15%;">Price</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $i=1; ?>
                                    @foreach($qGetOrderlist as $resultCartData)	
									<?php $productcreatedBy=Customer::find($resultCartData->createdBy);?>                                        
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>
                                                <div class="checkout_product">
                                                    <h5><a href="{{url('/')}}/event/{{$resultCartData->url_title}}" target="_blank">{{$resultCartData->productName}}</a></h5>
                                                    By: {{$productcreatedBy->firstName}} {{$productcreatedBy->lastName}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkout_product_qty">
                                                    <span>{{$resultCartData->product_quantity}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkout_product_qty">
                                                    <span><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format($resultCartData->grandTotal*$resultCartData->product_quantity,2)}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $i++;?>
                                    @endforeach
                                    </tbody>
                                </table>
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-5 col-md-5 col-lg-5 col-xs-12 pull-right">
                            <div class="table-responsive checkout_table">
                                <table class="table table-striped table-hover table-bordered">
                                    <tbody>
                                        <?php /*?><tr>
                                            <th style="text-align:left;">SUB TOTAL</th>
                                            <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($qGetOrderlist[0]->subTotal,2)}}</b></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align:left;">DISCOUNT</th>
                                            <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($qGetOrderlist[0]->discount,2)}}</b></td>
                                        </tr>
                                        @if(Config::get('config.Tax', '0') > 0)
                                        <tr>
                                            <th style="text-align:left;">TAX({{Config::get('config.Tax', '0')}}%)</th>
                                            <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($qGetOrderlist[0]->tax,2)}}</b></td>
                                        </tr>
                                        @endif<?php */?>
                                        <tr>
                                            <th style="text-align:left;">TOTAL</th>
                                            <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($qGetOrderlist[0]->grandTotal,2)}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<div class="col-sm-12 col-xs-12 col-md-12">
                             <div class="table-responsive">
                             <form name="frm_reward" id="frm_reward"  action="{{ url('/') }}/adminarea/order/reward" method="post" class="form-horizontal" enctype="multipart/form-data" >
                              <input type="hidden" class="form-control" name="customerEmail" id="customerEmail" value="{{ $qGetOrderlist[0]->email }}" required>
                              <table class="table table-striped table-hover table-bordered">
                              	 <thead>
                                    <tr>
                                        <th colspan="2" style="text-align:center;">Reward</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  		<tr>
                                            <td width="20%">Subject</td>
                                            <td>
                                               <input type="text" class="form-control" name="subject" maxlength="200" id="subject" placeholder="Subject" value="" required >
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td width="20%">Description</td>
                                            <td>
                                               <textarea id="description" name="description" required></textarea>
                                               <br> 
                                               <input type="submit" class="btn btn-warning waves-effect waves-light" name="Send" value="Send">
                                            </td>
                                        </tr>
                                   
                                    </tbody>
                                </table>
                                </form>
                             </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
   </div>
</section>

@endsection