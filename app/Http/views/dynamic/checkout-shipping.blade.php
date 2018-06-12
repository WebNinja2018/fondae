<?php

	$customerAddressID=Input::get('customerAddressID')?Input::get('customerAddressID'):'0';
	if($customerAddressID==0){
		$customerAddressID=old('customerAddressID')?old('customerAddressID'):'';	
	}
    $typeID = old('typeID')? old('typeID') : 1;
	$firstName = old('firstName')? old('firstName') : '';
	$lastName = old('lastName')? old('lastName') : '';
	$address1 = old('address1')? old('address1') : '';
	$address2 = old('address2')? old('address2') : '';
	$city = old('city')? old('city') : '';
	$state = old('state')? old('state') : '';
	$country = old('country')? old('country') : '';
	$zipcode = old('zipcode')? old('zipcode') : '';
	$phone = old('phone')? old('phone') : '';
	
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

if(!empty($_REQUEST['m'])){
    $mm=$_REQUEST['m'];
}
else{

     $mm=5;
}
?>
<script type="text/javascript">
	$( document ).ready(function() {
	   	$("#country").change(function(){
			var country_id = $("#country").val();
			var stateID = $("#getStateID").val();
				$.ajax({
					type: "POST",
					url: "{{url('/')}}/ajax/getallstate",
					data: "country_id="+country_id+"&stateID="+stateID,
			  		success: function(result){
					$("#stateID").html(result);
				}
			});
		})
	
		$("#customerAddressID").change(function(){
			var customerAddressID = $("#customerAddressID").val();
			var typeID = $("#typeID").val();
				if(customerAddressID > 0){
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
									$("#stateID").val(result[7]);
									$('#stateID').attr('readonly', true);
									$("#zipcode").val(result[8]);
									$('#zipcode').attr('readonly', true);
									$("#phone").val(result[9]);
									$('#phone').attr('readonly', true);
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
			}
		});	
@if($country > 0)
	$("#country").change();
@endif
@if($customerAddressID > 0)
	$("#customerAddressID").change();
@endif
});
</script>
@if(Config::get('config.isClientValidationStop', '0')!=1)
	<script type="text/javascript">
        $.validator.setDefaults({
            submitHandler5: function() {window.document.frm_shipingaddress.submit()}
        });
        $.metadata.setType("attr", "validate");
        $().ready(function() {
        // validate the comment form when it is submitted
        $("#frm_shipingaddress").validate({
                rules: {
                    firstName: "required",
                    lastName: "required",
                    address1: "required",
                    city:"required",
                    state:"required",
                    country:"required",
					phone:"required",
                    zipcode:{required:true,number: true}
                },
                messages: {
                    firstName: "{{ Config::get('commonmessage.msg_validate_firstname','Please enter first name') }}",
                    lastName: "{{ Config::get('commonmessage.msg_validate_lastname','Please enter last name') }}",
                    address1: "{{ Config::get('commonmessage.msg_validate_address1','Please enter address') }}",
                    city: "{{ Config::get('commonmessage.msg_validate_city','Please enter city') }}",
                    country: "{{ Config::get('commonmessage.msg_validate_country','Please select country') }}",
                    state:"{{ Config::get('commonmessage.msg_validate_state','Please select state') }}",
					phone:"{{ Config::get('commonmessage.msg_validate_phone','Please enter phone') }}",
                    zipcode:{required:"{{ Config::get('commonmessage.msg_validate_zipcode','Please enter zipcode') }}",number:"{{ Config::get('commonmessage.msg_validate_validnumber','Please enter valid zipcode') }}"}
                }
            });
        });
    </script>
@endif

<div class="col-sm-7 col-md-8 col-xs-12 col-lg-8 check_out_left">
    <div class="box_shadow">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
            <a href="##">Step 1 : Billing Info</a>
        </div>
		@include('include.message')
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
             <form class="bg-w-form" name="frm_shipingaddress" id="frm_shipingaddress" action="{{ url('/') }}/action/checkoutshippingaction" method="post" >
                 <input type="hidden" value="{{$typeID}}" id="typeID" name="typeID">
                 <input type="hidden" value="{{$state}}" id="getStateID" name="getStateID">
                 <input type="hidden" value="{{$mm }}" id="min_amount" name="min_amount">

                    <div class="row check_out_form">
                        <?php /*?><div class="form-group">
							@if($customerAddressRecordCount > 0)
                                <div class="col-sm-6 col-md-6 col-xs-12 col-lg-6">
                                    <select id="customerAddressID" name="customerAddressID" class="form-control">
                                        <option value="">Add New Address</option>
                                        @foreach($qGetCustomerAddressData as $resultCustomerAddressData)
                                            <option value="{{$resultCustomerAddressData->customerAddressID}}" @if($resultCustomerAddressData->customerAddressID == $qGetCartData[0]->shippingID) selected="selected" @endif>{{$resultCustomerAddressData->firstName.' '.$resultCustomerAddressData->lastName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif       
                        </div><?php */?>
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
                                <input type="text" maxlength="100" class="form-control" value="{{$address1}}" name="address1" id="address1" placeholder="Enter Address 1">
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
                                <input type="text" maxlength="15" class="checkbox_text form-control phoneMask" placeholder="Enter Phone Number" value="{{$phone}}" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="form-group">	
                            <div class="col-sm-12 col-md-12 col-xs-12 check_out_step_btn">
								<input type="submit" value="Continue" name="shipingcontinue" class="btn btn-grey video-btn-left pull-right">
                                <a href="{{url('/')}}/explore" class="btn btn-grey video-btn-left pull-right"><span><b> Back to Event</b></span></a>
                            </div>
                         </div>
                     </div>
                </form>
        </div>
        <!--start all ckeck_out step-->
        <!-- start Checkout step 3-->
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
                <a href="javascript:;">Step 2: Donate</a>
            </div>
        <!--END checkout step 3-->
    </div>
</div>