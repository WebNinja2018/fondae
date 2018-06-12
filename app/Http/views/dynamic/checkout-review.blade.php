<!-- start ckeck_out left area-->
<div class="col-sm-7 col-md-8 col-xs-12 col-lg-8 check_out_left">
  <div class="box_shadow">
      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
          <a href="{{url('/')}}/checkout-shipping">Step 1 : Shipping info</a>
      </div>
      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
          <a href="{{url('/')}}/checkout-billing">Step 2: Billing info</a>
      </div>
      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
          <a href="##">Step 3: Review</a>
      </div>
      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
          <form class="bg-w-form" id="frm_completeorder" name="frm_completeorder" action="{{url('/payment/confirmOrder')}}"  method="post" >

				  @if($shippingAddressRecordCount>0)
                  <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 shipping_billing">
                      <b>Shipping</b>
                      <b>{{$qGetShippingAddressData[0]->firstName}} {{$qGetShippingAddressData[0]->lastName}}</b>
                      <span>{{$qGetShippingAddressData[0]->address1}}</span>
                      @if(strlen($qGetShippingAddressData[0]->address2)>0)<span>{{$qGetShippingAddressData[0]->address2}}</span>@endif
					  <span>{{$qGetShippingAddressData[0]->city}}</span>
                      <span>{{$qGetShippingAddressData[0]->zipcode}}</span>
                      @if(strlen($qGetShippingAddressData[0]->phone)>0)<span>phone: {{$qGetShippingAddressData[0]->phone}}</span>@endif
					  <a href="{{url('/')}}/checkout-shipping" title="Edit">Edit</a>
                  </div>
				  @endif
				  @if($billingAddressRecordCount>0)
                  <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 shipping_billing">
                      <b>Billing</b>
                      <b>{{$qGetBillingAddressData[0]->firstName}} {{$qGetBillingAddressData[0]->lastName}}</b>
                      <span>{{$qGetBillingAddressData[0]->address1}}</span>
                      @if(strlen($qGetBillingAddressData[0]->address2)>0)<span>{{$qGetBillingAddressData[0]->address2}}</span>@endif
					  <span>{{$qGetBillingAddressData[0]->city}}</span>
                      <span>{{$qGetBillingAddressData[0]->zipcode}}</span>
                      @if(strlen($qGetBillingAddressData[0]->phone)>0)<span>phone: {{$qGetBillingAddressData[0]->phone}}</span>@endif
					  <a href="{{url('/')}}/checkout-billing" title="Edit">Edit</a>
                  </div>
				  @endif
                  <div class="product_table">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                          <div class="row">
                              <div class="table-responsive">
                                  <table class="table table-striped table-hover table-bordered">
                                      <tr>
                                          <th style="width:5%;">Item</th>
                                          <th style="width:50%;">Product Detail</th>
                                          <th style="width:15%;">Quntity</th>
                                          <th style="width:15%;">Price</th>
										  <th style="width:15%;">Item-Total</th>
                                      </tr>
									  <?php $i=1;?>
								  	  @foreach($qGetCartData as $resultCartData)	
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
                                                  <span>QTY</span>
                                                  <input type="text" value="{{$resultCartData->quantity}}" readonly="readonly" name="quantity" class="form-control" id="quantity" >
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkout_product_qty">
                                                  <span><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format($resultCartData->price,2)}}</span>
                                              </div>
                                          </td>
										  <td>
                                              <div class="checkout_product_qty">
                                                  <span><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format(($resultCartData->quantity * $resultCartData->price),2)}}</span>
                                              </div>
                                          </td>
                                      </tr>
									  <?php $i++;?>
								  	  @endforeach
                                  </table>	
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12 pull-right">
                          <div class="row">
                              <div class="table-responsive checkout_table">
                                  <table class="table table-striped table-hover">
                                      <tbody>
                                          <tr>
                                              <th style="text-align:left;">SUB TOTAL</th>
                                              <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($cartPrice['cartproductTotal'],2)}}</b></td>
                                          </tr>
                                          <tr>
                                              <th style="text-align:left;">DISCOUNT</th>
                                              <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($cartPrice['cartDiscount'],2)}}</b></td>
                                          </tr>
                                          @if(Config::get('config.Tax', '0') > 0)
                                          <tr>
                                              <th style="text-align:left;">TAX({{Config::get('config.Tax', '0')}}%)</th>
                                              <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($cartPrice['taxTotal'],2)}}</b></td>
                                          </tr>
                                          @endif
                                          <?php /*?><tr>
                                              <th style="text-align:left;">SHIPPING</th>
                                              <td style="text-align:right;"><span>(Calculated in Step 3)</span></td>
                                          </tr><?php */?>
                                          <tr>
                                              <th style="text-align:left;">TOTAL</th>
                                              <td style="text-align:right;"><b>{{Config::get('config.priceSign', '$')}} {{number_format($cartPrice['grandTotal'],2)}}</b></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                         </div>
                      </div>
                  </div>
                  <div class="form-group">	
                      <div class="col-sm-12 col-md-12 col-xs-12 check_out_step_btn">
					  	<div class="row">
							  <input type="submit" value="Continue" name="shipingcontinue" class="btn btn-grey video-btn-right pull-right">
							  <a href="{{url('/')}}/checkout-billing" class="btn btn-grey video-btn-left pull-right"><span><b> Back to step 2</b></span></a>
						  </div>
                      </div>
                   </div>
              </form>
      </div>
  </div>
</div>
<!-- end ckeck_out left area-->

