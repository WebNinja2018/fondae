<?php 
	$searchOrder=old('searchOrder')? old('searchOrder') : '';
	$orderDate=old('orderDate')? old('orderDate') : '';
?>
<div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner">
    <div class="method-item right_form">
        <h6><i class="fa fa-shopping-cart" aria-hidden="true"></i>Donation History <a href="{{URL('/')}}/dashboard"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a></h6>
        <form name="frm_orderhistory" id="frm_orderhistory" method="post" action="{{url('/orderhistory')}}" autocomplete="off">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group serch_form">
						  <input type="text" name="searchOrder" id="searchOrder" value="{{$searchOrder}}" placeholder="Search By Donation #" class="form-control"  aria-describedby="sizing-addon2" maxlength="100">
                          <button type="submit" class="searchbutton"></button>
                    </div>
                </div>
                <?php /*?><div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group serch_form">
                          <input type="text" name="orderDate" id="datepicker" placeholder="Search By Order Date" class="form-control" maxlength="100" value="{{$orderDate}}" aria-describedby="sizing-addon2">
                          <button type="submit" class="searchbutton"></button>
                    </div>
                </div><?php */?>
            </div>
            <div class="col-sm-12 col-md-12 col-xs-12">
                <div class="col-sm-12 col-md-12 col-xs-12">
                    @if($orderRecordCount>0)
						@foreach($qGetOrderlist as $getOrderlist)
                        <div class="order_history">
                            <div class="col-sm-9 col-md-9 col-xs-6">
                                <div class="order_number">
                                    <h4><b>Donation Number : </b> <a href="{{url('/orderdetail')}}/{{$getOrderlist->orderNumber}}">{{$getOrderlist->orderNumber}}</a></h4>
                                    <h4><b>Donation Date : </b> <span class="date">{{date('m/d/Y',strtotime($getOrderlist->created_at))}}</span></h4>
                                    <?php /*?><h4><b>Order Status : </b> <span class="red">{{$getOrderlist->orderName}}</span></h4><?php */?>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xs-6">
                                <div class="order_number">
                                    <a href="{{url('/orderdetail')}}/{{$getOrderlist->orderNumber}}" class="detail_link">Donation Details</a>
                                </div>
                            </div>                                            	
                        </div>
						@endforeach
					@else
						<h3 align="center">Record not found.</h3>
                    @endif
                </div>
            </div>
        </form>
    </div>
	<nav class="pagination col-md-12">
        <ul class="pagination__list">
            <li>@include('include.pagination', ['paginator' => $qGetOrderlist])</li>
        </ul>
    </nav>
</div>
