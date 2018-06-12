<?php use App\Http\Models\Coupon; ?>
<script type="text/javascript">
	function fun_cartUpadte(cartDetialsID)
	{
		var quantity = $("#quantity_"+cartDetialsID).val();
		if(!isNaN(quantity) && quantity > 0){
			$("#checkOut").addClass("disabled");
			$.ajax({
			 	type: "POST",
			  	url: "{{ url('/') }}/ajax/updateCartQuantity",
			  	data: "quantity="+quantity+"&cartDetailID="+cartDetialsID,
			  	success: function(result)
			  	{
					var price = result.split('~');
					if(price[0]==1){
						alert('Cart Updated!');
						$("#productPrice_"+cartDetialsID).load(document.URL + ' #productPrice_'+cartDetialsID);
						$("#Subtotal").load(document.URL + ' #Subtotal');
						$("#Discount").load(document.URL + ' #Discount');
						$("#Total").load(document.URL + ' #Total');
						$("#checkOut").removeClass("disabled");
					}else if(price[0]==2){
						alert('The requested quantity is not available.');
					}else{
						alert('Cart Not Upadate.Please try agian!');
					}
				}
			});
		}else{
			alert('Please enter valid Quantity.');
		}
	}
	function fun_cartdelete(cartDetialsID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
					type: "POST",
					url: "{{ url('/') }}/ajax/deleteCartProduct",
					data: "cartDetailID="+cartDetialsID,
					success: function(result)
					{
						var price = result.split('~');
						if(price[0]==1){
							if(price[1]==0){
								price[1]='0.00';
								price[2]='0.00';
								price[3]='0.00';
							}
							$("#cartID_"+cartDetialsID).animate({ opacity: "hide" },"slow");
							$("#Subtotal").html('<i class="{{Config::get("config.priceClass","$")}}" aria-hidden="true"></i>'+ price[1]);
							$("#Discount").html('<i class="{{Config::get("config.priceClass","$")}}" aria-hidden="true"></i>'+ price[2]);
							$("#Total").html('<i class="{{Config::get("config.priceClass","$")}}" aria-hidden="true"></i>'+ price[3]);
							//window.location.reload();
						}else{
								alert('Cart Not Delete.Please try agian!');
						}	
					}
				});
		}
	}

	function fun_emptycart(cartID)
	{
		if(confirm("Are you sure want to empty your cart? "))
		{
			$.ajax({
					type: "POST",
					url: "{{ url('/') }}/ajax/deleteCart",
					data: "cartID="+cartID,
					success: function(result)
					{
						window.location.reload();
					}
				});
		}
	}

	function fun_removecoupon()	/*Remove Coupon*/
	{
		window.document.frm_coupon.action = "{{url('/')}}/action/removecoupon";
		$('#frm_coupon').submit();
	}
	
	$.validator.setDefaults({
		submitHandler2: function() { window.document.frm_coupon.submit() }
	});
	$.metadata.setType("attr", "validate");
	$().ready(function() {
	$("#frm_coupon").validate({
		rules: {
			couponCode:{required: true}
	},
		messages: {
			couponCode: "Please enter couponcode."
			}
		});
	});
</script>

      <div class="course-syllabus">
        <div class="course-syllabus-title underline">Product Cart @if($CartRecordCount > 0) <button class="btn btn-grey video-btn-right pull-right" style="margin-right:0px;" onclick="fun_emptycart({{$cartID}})"><span><b>Empty Cart</b></span></button> @endif </div>
          <div class="course-table">
              <div class="outer-container">
                  <div class="inner-container">
                      <div class="table-header">
					  @include('include.message')
					  <form name="frm_cartupdate" id="frm_cartupdate" action="" method="post" enctype="multipart/form-data" >
                          <table class="edu-table-responsive cart_table table-hover table-bordered">
                              <thead>
                              <tr class="heading-table">
                                  <th style="width:5%;">Item</th>
                                  <th>product Name</th>
                                  <th style="width:15%;">Quantity</th>
                                  <th style="width:10%;">Price</th>
                                  <th style="width:10%;">Item-total</th>
                                  <th style="width:10%;">Remove Item</th>
                              </tr>
                              </thead>
							  
                              <tbody>
							  @if($CartRecordCount > 0)
								  <?php $i=1;?>
								  @foreach($qGetCartResult as $resultCartData)	
                                  <tr class="table-row" id="cartID_{{$resultCartData->cartDetailID}}">
                                      <td>{{$i}}</td>
                                      <td style="text-align:left;"><p class="text-left" ><a href="{{url('/conference')}}/{{$resultCartData->url_title}}">{{$resultCartData->productName}}</a></p>{{$resultCartData->sizeName}}</td>
                                      <td><input type="text" name="quantity" id="quantity_{{$resultCartData->cartDetailID}}" value="{{$resultCartData->quantity}}" placeholder="1" class="form-control cart_quantity" >
										  <a href="##" onclick="fun_cartUpadte('{{$resultCartData->cartDetailID}}')"> Update</a>
									  </td>
                                      <td><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format($resultCartData->price,2)}}</td>
                                      <td><b id="productPrice_{{$resultCartData->cartDetailID}}"><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{number_format(($resultCartData->quantity * $resultCartData->price),2)}}</b></td>
                                      <td><a href="##" onclick="fun_cartdelete('{{$resultCartData->cartDetailID}}')"><i class="w20 fa fa-times" aria-hidden="true"></i></a></td>
                                  </tr>
								  <?php $i++;?>
								  @endforeach
							  @else
                                   <tr><td colspan='6'><h3 align='center'> Your Cart is Empty!</h3></td></tr>
                              @endif
                              </tbody>
                          </table>
					  </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
	 @if($CartRecordCount > 0)
		<?php $couponCodeID=$qGetCartResult[0]->couponCodeID;?>
	 	<div class="col-sm-6 col-md-6 col-xs-12 pull-left">
	 	<div class="row">
			  <div class="col-sm-12 col-md-12 col-xs-12">
				  <div class="row">
					  <div class="col-sm-12 col-md-12 col-xs-12 pull-right cart_total coupon_code">
					  	<div class="row">
							<form name="frm_coupon" id="frm_coupon" method="post" action="{{url('/')}}/action/addcuopon">
                                  <input type="hidden" name="subtotal" id="subtotal1" value="{{$cartPrice['cartGrandTotal']}}" />
                                  <input type="hidden" name="cartID" id="cartID" value="{{$qGetCartResult[0]->cartID}}" />
                                  <label>Enter Coupon Code</label>
                                  <input type="text" class="form-control" name="couponCode" value="@if($couponCodeID>0) {{$couponCode}} @endif" id="couponCode" />
								  @if($couponCodeID>0)
                                  	<button type="submit" name="remove" class="btn btn-grey video-btn-right" onclick="fun_removecoupon();"><span><b>Remove</b></span></button>
								  @else
									<button type="submit" name="submit" class="btn btn-grey video-btn-right"><span><b>Submit</b></span></button>
								  @endif
                            </form>
					  	</div>
					  </div>
				  </div>
			  </div>
		  	<div class="col-sm-10 col-md-10 col-xs-12">
				<div class="row">
					<div class="cards_images">
						<h4 class="cart_title">We accept</h4>
						<ul>
							<li><img src="{!! url('components/front-end/images/cart_visa_img.png') !!}" alt="" title=""></li>
							<li><img src="{!! url('components/front-end/images/cart_paypal_img.png') !!}" alt="" title=""></li>
						</ul>
					</div>
			  </div>
			</div>
		 </div>
	 </div>
	 @endif
	 <div class="col-sm-6 col-md-6 col-xs-12 pull-right">
	 	<div class="row">
		  @if($CartRecordCount > 0)
			  <div class="col-sm-12 col-md-12 col-xs-12">
				  <div class="row">
					  <div class="col-sm-8 col-md-8 col-xs-6 pull-right cart_total">
						  <table class="edu-table-responsive">
							  <tbody>
								  <tr class="heading-content">
									  <td>Sub Total :</td>
									  <td><b id="Subtotal"><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{$cartPrice['cartproductTotal']}} </b></td>
								  </tr>
								  <tr class="heading-content">
									  <td>Discount :</td>
									  <td><b id="Discount"><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{$cartPrice['cartDiscount']}} </b></td>
								  </tr>	
								  <tr class="heading-content final_total">
									  <td>Total :</td>
									  <td><b id="Total"><i class="w20 {{Config::get('config.priceClass', 'fa fa-usd')}}" aria-hidden="true"></i> {{$cartPrice['cartGrandTotal']}} </b></td>
								  </tr>	
							  </tbody>
						  </table>
					  </div>
				  </div>
			  </div>
			  @endif
		  	<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="row">
				  @if($CartRecordCount > 0)
					  @if(Session::get('customerID'))
						  <a id="checkOut" class="btn btn-grey video-btn-right pull-right" href="{{url('/')}}/donate" ><span><b>Proceed To Pay</b></span></a>
					  @else
						  <a id="checkOut" class="btn btn-grey video-btn-right pull-right" href="{{url('/')}}/login-registration" ><span><b>Proceed To Pay</b></span></a>
					  @endif
				  @endif
				  <a class="btn btn-grey video-btn-left pull-right" href="{{url('/')}}/audio-conference"><span><b>Continue Shopping </b></span></a>
			  </div>
			</div>
		 </div>
	 </div>