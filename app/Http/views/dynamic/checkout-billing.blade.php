<?php
	$customerAddressID=Input::get('customerAddressID')?Input::get('customerAddressID'):'0';
	if($customerAddressID==0){
		$customerAddressID=old('customerAddressID')?old('customerAddressID'):'';	
	}
    $typeID = old('typeID')? old('typeID') : 2;
	$firstName = old('firstName')? old('firstName') : '';
	$lastName = old('lastName')? old('lastName') : '';
	$address1 = old('address1')? old('address1') : '';
	$address2 = old('address2')? old('address2') : '';
	$city = old('city')? old('city') : '';
	$state = old('state')? old('state') : '';
	$country = old('country')? old('country') : '';
	$zipcode = old('zipcode')? old('zipcode') : '';
	$phone = old('phone')? old('phone') : '';
	$shippingID = old('shippingID')? old('shippingID') : '';

	// Default Payment and card session variable set here.	
	$paymentType=Session::get('paymentType')?Session::get('paymentType'):2;
	$cardType=Session::get('cardType')?Session::get('cardType'):'';
	$cardName=Session::get('cardName')?Session::get('cardName'):'';
	$cardNumber=Session::get('cardNumber')?Session::get('cardNumber'):'';
	$cvvNumber=Session::get('cvvNumber')?Session::get('cvvNumber'):'';
	$expYear=Session::get('expYear')?Session::get('expYear'):'';
	$expMonth=Session::get('expMonth')?Session::get('expMonth'):'';
	
	// Set exsiting address variable.	
	if(isset($customerAddressRecordCount) && $customerAddressRecordCount > 0){
		if(isset($qGetCustomerAddressData)){
			$customerAddressID = $qGetCustomerAddressData[0]->customerAddressID;
			$typeID = $qGetCustomerAddressData[0]->typeID;
			$firstName = $qGetCustomerAddressData[0]->firstName;
			$lastName = $qGetCustomerAddressData[0]->lastName;
			$address1 = $qGetCustomerAddressData[0]->address1;
			$address2 = $qGetCustomerAddressData[0]->address2;
			$city = $qGetCustomerAddressData[0]->city;
			$state = $qGetCustomerAddressData[0]->state;
			$country = $qGetCustomerAddressData[0]->country;
			$zipcode = $qGetCustomerAddressData[0]->zipcode;
			$phone = $qGetCustomerAddressData[0]->phone;
		}
	}
?>
@if(Config::get('config.isClientValidationStop', '0')!=1)
<script type="text/javascript">
$.validator.setDefaults({
		submitHandler7: function() { window.document.frm_billingaddress.submit() }
	});
	$.metadata.setType("attr", "validate");
	$().ready(function() {
	// validate the comment form when it is submitted
	$("#frm_billingaddress").validate({
		rules: {	
			firstName: "required",
			lastName: "required",
			address1: "required",
			city:"required",
			country:"required",
			state:"required",
			phone:"required",
			zipcode:{required:true,number: true},
			/* Card Client Side Validation*/
			paymentType: "required",
			cardType: {required:'#paymentTypeCard:checked'},
			cvvNumber: {required:'#paymentTypeCard:checked',number: true,minlength:3,maxlength:3},
			cardNumber: {required:'#paymentTypeCard:checked',number: true,minlength:16,maxlength:16},
			cardName:{required:'#paymentTypeCard:checked'},
			expYear:{required:'#paymentTypeCard:checked'},
			expMonth:{required:'#paymentTypeCard:checked'}		
		},
		messages: {
				firstName: "{{ Config::get('commonmessage.msg_validate_firstname','Please enter first name') }}",
				lastName: "{{ Config::get('commonmessage.msg_validate_lastname','Please enter last name') }}",
				address1: "{{ Config::get('commonmessage.msg_validate_address1','Please enter address') }}",
				city: "{{ Config::get('commonmessage.msg_validate_city','Please enter city') }}",
				country: "{{ Config::get('commonmessage.msg_validate_country','Please select country') }}",
				state:"{{ Config::get('commonmessage.msg_validate_state','Please select state') }}",
				phone:"{{ Config::get('commonmessage.msg_validate_phone','Please enter phone') }}",
				zipcode:{required:"{{ Config::get('commonmessage.msg_validate_zipcode','Please enter zipcode') }}",number:"{{ Config::get('commonmessage.msg_validate_validnumber','Please enter valid zipcode') }}"},
				paymentType: "{{ Config::get('commonmessage.msg_validate_paymentType','Please select Payment Type') }}",
				cardType: "{{ Config::get('commonmessage.msg_validate_cardType','Please select Card Type') }}",
				cvvNumber: {required:"{{ Config::get('commonmessage.msg_validate_cvvNumber','Please enter CVV') }}",number:"{{ Config::get('commonmessage.msg_validate_validnumber','Please enter valid CVV') }}",maxlength:"{{ Config::get('commonmessage.msg_validate_cvvMaxLength','Please enter valid CVV')}}"},
				cardNumber: {required:"{{ Config::get('commonmessage.msg_validate_cardNumber','Please enter Card Number') }}",number:"{{ Config::get('commonmessage.msg_validate_validnumber','Please enter valid Card Number') }}",maxlength:"{{ Config::get('commonmessage.msg_validate_cardMaxLength','Please enter valid Card Number') }}"},
				cardName: "{{ Config::get('commonmessage.msg_validate_cardName','Please enter Card Name') }}",
				expMonth: "{{ Config::get('commonmessage.msg_validate_expMonth','Please enter exp Month') }}",
				expYear: "{{ Config::get('commonmessage.msg_validate_expYear','Please enter exp Year') }}",
			}
		});
});
</script>
@endif

<script type="text/javascript">
 $(document).ready(function(){
 	<?php //Get All state with selectes Country. ?>
	$("#country").change(function(){
		var country_id = $("#country").val();
		var stateID = $("#getStateID").val();
			$.ajax({
				type: "POST",
				url: "{{url('/')}}/ajax/getallstate",
				data: "country_id="+country_id+"&stateID="+stateID,
				success: function(result){
				$("#stateID").html(result);
				if(country_id > 0){
					$("#frm_billingaddress").valid();
				}
			}
		});
	})
	<?php //Set Billing Address same as Shipping address. ?>
	$("#shippingID").click( function(){
	   var shippingID = $("#shippingID").val();
	   var typeID = $("#typeID").val();
	   if( $(this).is(':checked')){
			fun_getAddressDetail(shippingID,typeID);
	   }else{
	   	<?php // shiping address not selected then shiping staet value nu;;?>
			var stateID = $("#getStateID").val('');  
			fun_getAddressDetail(0,typeID);
	   }
	});	
	<?php // if Billing address same as shipping address then this function excute on load.
		if($qGetCartData[0]->shippingID == $qGetCartData[0]->billingID){?>
		$("#shippingID").click();
	<?php }
	// it work with payment option Selection and hide show card  blog ?>
	$(".paymentType").click( function(){
		if($(this).val()==1){
			$("#creditCardInfo").css('display','block');
		}else{
			$("#creditCardInfo").css('display','none');
		}
	});
	<?php if($customerAddressID > 0){?> 
		var customerAddressID = $("#customerAddressID").val();
	   	var typeID = $("#typeID").val();
		fun_getAddressDetail(customerAddressID,typeID);
	<?php }?>
	
	<?php if($paymentType==2){?>
		$(".paymentType").click();
	<?php }?>
});

	function fun_getAddressDetail(customerAddressID,typeID)
	{
		if(customerAddressID>0){
			$.ajax({
					type: "POST",
					url: "{{url('/')}}/ajax/getAddressData",
					data: "customerAddressID="+customerAddressID+"&typeID="+typeID,
					success: function(respone)
					{
						var result = respone.split('~');
						if(result[0]==1){
							$("#firstName").val(result[1]);
							$('#firstName').attr('readonly', true);
							$("#lastName").val(result[2]);
							$('#lastName').attr('readonly', true);
							$("#address1").val(result[3]);
							$('#address1').attr('readonly', true);
							$("#address2").val(result[4]);
							$('#address2').attr('readonly', true);
							$("#country").val(result[5]);
							$('#country').attr('readonly', true);
							$("#city").val(result[6]);
							$('#city').attr('readonly', true);
							$("#getStateID").val(result[7]);
							$("#stateID").val(result[7]);
							$('#stateID').attr('readonly', true);
							$("#zipcode").val(result[8]);
							$('#zipcode').attr('readonly', true);
							$("#phone").val(result[9]);
							$('#phone').attr('readonly', true);
							$("#country").change();
							$("#frm_billingaddress").valid();
						}else{
							$.alert({
								title: false,
								theme: 'black',
								content: 'Something Wrong in address selection!',
								confirmButtonClass: 'btn-primary',
								confirm: function(){
								}

							});
						}
					}
				});
		}else{
			
			$.ajax({
					type: "POST",
					url: "{{url('/')}}/ajax/getAddressData",
					data: "customerAddressID="+customerAddressID+"&typeID="+typeID,
					success: function(respone)
					{
						$("#firstName").val('');
						$('#firstName').attr('readonly', false);
						$("#lastName").val('');
						$('#lastName').attr('readonly', false);
						$("#address1").val('');
						$('#address1').attr('readonly', false);
						$("#address2").val('');
						$('#address2').attr('readonly', false);
						$("#country").val('');
						$('#country').attr('readonly', false);
						$("#stateID").val('');
						$('#stateID').attr('readonly', false);
						$("#city").val('');
						$('#city').attr('readonly', false);
						$("#zipcode").val('');
						$('#zipcode').attr('readonly', false);
						$("#phone").val('');
						$('#phone').attr('readonly', false);
						$("#country").change();
					}
				});
		}
	}
</script>

<!-- start ckeck_out left area-->
<div class="col-sm-7 col-md-8 col-xs-12 col-lg-8 check_out_left">
    <div class="box_shadow">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
            <a href="{{url('/')}}/checkout-shipping">Step 1 : Shipping info</a>
        </div>
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
            <a href="#">Step 2: Billing info</a>
        </div>
        @include('include.message')
		<form class="bg-w-form" id="frm_billingaddress" name="frm_billingaddress" action="{{ url('/') }}/action/checkoutbillingaction"  method="post" >
            <input type="hidden" value="{{$typeID}}" id="typeID" name="typeID">
            <input type="hidden" value="" id="getStateID" name="getStateID">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                <div class="row check_out_form">
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-xs-12 col-lg-6 shipping_check_box">
                             <label class="control-label form-label"><input type="checkbox" value="{{$qGetCartData[0]->shippingID}}" name="shippingID" id="shippingID" ><span>Use Shipping Info</span></label>
                        </div>   
                        @if($customerAddressRecordCount > 0)
                            <div class="col-sm-6 col-md-6 col-xs-12 col-lg-6">
                                <select id="customerAddressID" onchange="fun_getAddressDetail(this.value,'{{ Config::get('config.billingTypeID',1) }}');" name="customerAddressID" class="form-control getAddress">
                                    <option value="">Add New Address</option>
                                    @foreach($qGetCustomerAddressData as $resultCustomerAddressData)
                                        <option value="{{$resultCustomerAddressData->customerAddressID}}" @if($resultCustomerAddressData->customerAddressID == $qGetCartData[0]->billingID) selected="selected" @endif>{{$resultCustomerAddressData->firstName.' '.$resultCustomerAddressData->lastName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif     
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">First Name <span class="highlight"> * </span></label>
                            <input type="text" maxlength="100" class="form-control" value="{{$firstName}}" placeholder="Enter First Name" id="firstName" name="firstName">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Last Name <span class="highlight"> * </span></label>
                            <input type="text" maxlength="100" class="form-control" value="{{$lastName}}" placeholder="Enter Last Name" id="lastName" name="lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 street_address">
                            <label class="control-label form-label">Street Address <span class="highlight"> * </span></label>
                            <input type="text" maxlength="100" class="form-control" value="{{$address1}}" name="address1" id="address1"  placeholder="Enter Address 1">
                            <input type="text" maxlength="100" class="form-control form_address" value="{{$address2}}" name="address2" id="address2"  placeholder="Enter Address 2">
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-xs-12 col-lg-6">
                                    <label class="control-label form-label">Country <span class="highlight"> * </span></label>
                                    <select id="country" name="country"  class="form-control">
                                        <option value="">-- Select Country --</option>
                                           @if($countryRecordCount > 0)
                                                @foreach($qGetCountryData as $resultCountryData)
                                                    <option value="{{$resultCountryData->country_id}}" @if($resultCountryData->country_id == $country) selected="selected" @endif >{{$resultCountryData->country_name}}</option>
                                                @endforeach
                                           @endif
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                                    <label class="control-label form-label">State <span class="highlight"> * </span></label>
                                    <select id="stateID" name="state"  class="form-control">
                                        <option value="">-- Select State --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                             <label class="control-label form-label">City <span class="highlight"> * </span></label>
                             <input type="text" class="checkbox_text form-control" value="{{$city}}"  placeholder="Enter City" name="city" id="city" maxlength="100">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Zip Code <span class="highlight"> * </span></label>
                            <input type="text" maxlength="6" class="checkbox_text form-control" placeholder="Enter ZipCode" value="{{$zipcode}}" name="zipcode" id="zipcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Phone <span class="highlight"> * </span></label>
                            <input type="text" maxlength="20" class="checkbox_text form-control phoneMask" placeholder="Enter Phone Number" value="{{$phone}}" id="phone" name="phone">
                        </div>
                    </div>
                 </div>
            </div>
            <!-- start billing method -->
            <div class="billing_method">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                    <h4>Billing Method</h4>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                     <ul>
                        <li>
                            <img src="{{url('/')}}/components/front-end/images/cart_visa_img.png" alt="cart_ach_img" title="cart_ach_img" />
                        </li>
                        <li>
                            <img src="{{url('/')}}/components/front-end/images/cart_amex_mg.png" alt="cart_ach_img" title="cart_ach_img" />
                        </li>
                        <li>
                            <img src="{{url('/')}}/components/front-end/images/cart_paypal_img.png" alt="cart_ach_img" title="cart_ach_img" />
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 text-center select_card_type">
                    <label class="radio-inline"><input type="radio" class="paymentType" @if($paymentType==1) checked="checked" @endif id="paymentTypeCard"  value="1" name="paymentType">Credit Card </label>
                    <label class="radio-inline"><input type="radio" class="paymentType" @if($paymentType==2) checked="checked" @endif value="2" name="paymentType"  checked="checked">Paypal</label>
                </div>
                <div id="creditCardInfo">
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-xs-12 col-lg-6">
                            <select id="cardType" name="cardType" class="valid form-control">
                                <option value="">Select Card On File <span class="mandatory_msg"> * </span></option>
                                <option value="Visa" @if($cardType=='Visa') selected="selected" @endif>Visa</option>
                                <option value="Mastercard" @if($cardType=='Mastercard') selected="selected" @endif>Mastercard</option>
                                <option value="Amex" @if($cardType=='Amex') selected="selected" @endif>Amex</option>
                            </select>
                        </div>
                   </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Card Name <span class="highlight"> * </span></label>
                            <input type="text" value="{{$cardName}}" class="form-control valid" maxlength="100" id="cardName" name="cardName" >
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Card Number <span class="highlight"> * </span></label>
                            <input type="text" value="{{$cardNumber}}" class="form-control valid" maxlength="16" id="cardNumber" name="cardNumber">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                            <label class="control-label form-label">Exp. Date <span class="highlight"> * </span></label>
                            <select id="expMonth" name="expMonth" class="valid form-control">
                                <option selected="selected" value="">Month</option>
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}" @if($expMonth==$i) selected="selected" @endif >@if($i<10) 0 @endif{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
                           <label class="control-label form-label"> &nbsp;</label>
                            <select id="expYear" name="expYear" class="valid form-control">
                               <?php $currentYear = date('Y'); $endYear = $currentYear + 25; ?>
                                @for($currentYear;$currentYear<=$endYear;$currentYear++)
                                    <option value="{{$currentYear}}" @if($expYear == $currentYear) selected="selected" @endif >{{$currentYear}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="control-label form-label">Security Code <span class="highlight"> * </span></label>
                            <input type="text" value="{{$cvvNumber}}" maxlength="3" class="valid form-control" id="cvvNumber" name="cvvNumber">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="col-sm-12 col-md-12 col-xs-12">&nbsp;</label>
                            <a title="Card Verification Number" class="billing_whatthis" data-target="#myModal" data-toggle="modal" href="">What is This?</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">	
                  <div class="col-sm-12 col-md-12 col-xs-12 check_out_step_btn">
                      <input type="submit" value="Continue" name="shipingcontinue" class="btn btn-grey video-btn-right pull-right">
                      <a href="{{url('/')}}/checkout-shipping" class="btn btn-grey video-btn-left pull-right"><span><b> Back to step 1</b></span></a>
                  </div>
                </div>
             </div>
        </form>
            
        <!-- end billing method-->
        <!--start all ckeck_out step-->
            <!-- start Checkout step 4-->
                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
                <a href="#">Step 3: Review</a>
                </div>
            <!--END checkout step 4-->
        <!--end all ckeck_out step-->
    </div>
</div>
<div aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header checkout_security">
                <div class="checkout_close"><button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">&times;</span></button></div>
                <h4 id="myModalLabel" class="modal-title">Security Code</h4>
            </div>
            <div class="modal-body">
                <div class="security_paragraph">
                    <p>In order to ensure the safety and security of your credit card, we require that you enter the Card Verification Number. Since this number is not embossed on the card and does not appear on purchase receipts, it helps to ensure that your card is not being used by someone else.</p>
                    <p>Card issuers refer to this number as the &quot;Card Verification Code &quot; , &quot;Card Verification Value&quot; , &quot; Card Authentication Value &quot; , &quot; Cardmember Identifier &quot; , &quot; Card Verification Number &quot; , &quot; Personal Security Code &quot; or &quot; Security Code &quot;. If it is not available, please try using a different card.</p>
                    <p>For help finding your Card Verification Code, please refer to the examples below.</p>
                </div>
                <div class="security_images">
                    <img title="security_img" alt="security_img" src="{{url('/')}}/components/front-end/images/security_img.png">
                </div>     
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- end ckeck_out left area-->
