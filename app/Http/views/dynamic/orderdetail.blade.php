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

<div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner" id="printableArea">
    <div class="method-item right_form">
        <h6><i class="fa fa-shopping-cart" aria-hidden="true"></i>Donation Detail <a href="{{URL('/')}}/orderhistory"><i class="fa fa-angle-left" aria-hidden="true"></i> Back to Donation List</a></h6>
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="col-sm-12 col-md-12 col-xs-12">
                <div class="order_history">
                    <div class="col-sm-6 col-md-6 col-xs-6">
                        <div class="order_number">
                            <h4><b>Donation Number : </b> <a href="##">{{$qGetOrderlist[0]->orderNumber}}</a></h4>
                            <h4><b>Donation Date : </b> <span class="date">{{date('m/d/Y',strtotime($qGetOrderlist[0]->created_at))}}</span></h4>
                           <?php /*?> <h4><b>Order Status : </b> <span class="red">{{$qGetOrderlist[0]->orderName}}</span></h4><?php */?>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-6">
                         <a href="javascript:printDiv('printableArea');" class="btn btn-contact btn-green" style=" margin-top:15px;"><span>Print Invoice</span></a>
                    </div>                                            	
                </div>
            </div>
            @if($qGetOrderlist[0]->eventType==1)
				<div class="billing_detail_method">
				<?php /*?>@if($shippingAddressRecordCount>0)
				<div class="col-sm-6 col-xs-12 col-md-6">
                    <div class="inner_billing_detail">
                        <h4>{{$qGetShippingAddressData[0]->firstName}} {{$qGetShippingAddressData[0]->lastName}}</h4>
                        <span><b>Address 1 </b>: &nbsp; {{$qGetShippingAddressData[0]->address1}}</span>
                         @if(strlen($qGetShippingAddressData[0]->address2)>0)<span><b>Address 2 </b> : &nbsp; {{$qGetShippingAddressData[0]->address2}}</span>@endif
                        <span><b>city </b> : &nbsp; {{$qGetShippingAddressData[0]->city}} </span>
                        <span><b>state </b> : &nbsp;{{$qGetShippingAddressData[0]->stateName}} </span>
                        <span><b>country </b> : &nbsp;{{$qGetShippingAddressData[0]->countryName}}, {{$qGetShippingAddressData[0]->zipcode}}</span>
                        @if(strlen($qGetShippingAddressData[0]->phone)>0)<span>phone: {{$qGetShippingAddressData[0]->phone}}</span>@endif
                    </div>
                </div>
				@endif<?php */?>
				@if($billingAddressRecordCount>0)
                <div class="col-sm-6 col-xs-12 col-md-6">
                    <div class="inner_billing_detail">
                        <h4>{{$qGetBillingAddressData[0]->firstName}} {{$qGetBillingAddressData[0]->lastName}}</h4>
                        <span><b>Address 1 </b>: &nbsp; {{$qGetBillingAddressData[0]->address1}}</span>
                         @if(strlen($qGetBillingAddressData[0]->address2)>0)<span><b>Address 2 </b> : &nbsp; {{$qGetBillingAddressData[0]->address2}}</span>@endif
                        <span><b>city </b> : &nbsp; {{$qGetBillingAddressData[0]->city}} </span>
                        <span><b>state </b> : &nbsp; {{$qGetBillingAddressData[0]->stateName}} </span>
                        <span><b>country </b> : &nbsp;{{$qGetBillingAddressData[0]->countryName}}, {{$qGetBillingAddressData[0]->zipcode}}</span>
                        @if(strlen($qGetBillingAddressData[0]->phone)>0)<span>phone: {{$qGetBillingAddressData[0]->phone}}</span>@endif
                    </div>
                </div>
				@endif
            </div>
            @endif
        </div>
        
        @if($qGetOrderlist[0]->eventType==1)
           <div class="col-sm-12 col-xs-12 col-md-12">
                <div class="product_table">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                    <th>Item</th>
                                    <th>Product Detail</th>
                                    <th>QTY</th>
                                    <th style="width:15%;">Price</th>
                                </tr>
                                <?php $i=1;?>
                                @foreach($qGetOrderlist as $resultCartData)	
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <div class="checkout_product">
                                            <h5>{{$resultCartData->productName}}</h5>
                                            {{$resultCartData->sizeName}}
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
                            </table>	
                        </div>
                    </div>
                    
                    <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12 pull-right">
                        <div class="row">
                            <div class="table-responsive checkout_table">
                                <table class="table table-striped table-hover">
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
                            <?php /*?><a href="" class="btn btn-grey video-btn-right pull-right"><span><b>REORDER</b></span></a><?php */?>
                       </div>
                    </div>
                </div>
           </div>
        @else
           <div class="col-sm-12 col-xs-12 col-md-12">
                <div class="product_table">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <tr>
                                    <th>Item</th>
                                    <th>Product Detail</th>
                                    <th>Reward Type</th>
                                    @if($qGetOrderlist[0]->unpaidOption==1)<th>Email</th>@endif
                                </tr>
                                <?php $i=1;?>
                                @foreach($qGetOrderlist as $resultCartData)	
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <div class="checkout_product">
                                            <h5>{{$resultCartData->productName}}</h5>
                                            {{$resultCartData->sizeName}}
                                        </div>
                                    </td>
                                    <td>
                                   		<div class="checkout_product_qty">
                                            <span>@if($resultCartData->unpaidOption==1) Email @elseif($resultCartData->unpaidOption==2) Facebook @else Tweeter @endif</span>
                                        </div>    
                                    </td>
                                    @if($qGetOrderlist[0]->unpaidOption==1)
                                    <td>
                                        <div class="checkout_product_qty">
                                            <span>{{$resultCartData->orderEmail}}</span>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                <?php $i++;?>
                                @endforeach
                            </table>	
                        </div>
                    </div>
                </div>
           </div>
           
           @if($resultCartData->unpaidOption!=1)
               <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="product_table">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered" align="center">
                                    <tr>
                                        <th>Upload Image</th>
                                    </tr>
                                    <?php $i=1;?>
                                    @foreach($qGetOrderlist as $resultCartData)	
                                    <tr>
                                        <td><img src="{{ url('/') }}/upload/eventshare/th_{{ $resultCartData->image}}" height="500" /></td>
                                    </tr>
                                    <?php $i++;?>
                                    @endforeach
                                </table>	
                            </div>
                        </div>
                    </div>
               </div>
           @endif
        @endif
    </div>
</div>
