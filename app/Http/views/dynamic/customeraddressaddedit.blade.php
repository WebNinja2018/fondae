<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/font-awesome.css') !!}">
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/Glyphter.css') !!}">
<!-- LIBRARY CSS-->
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/animate.css') !!}">
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/bootstrap.css') !!}">
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/style.css') !!}" id="color-skins" >
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/responsive2.css') !!}" id="color-skins" >
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/responsive.css') !!}" id="color-skins" >

<script src="{{url('/components/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/') }}/components/js/jquery.metadata.js" type="text/javascript"></script>
<script src="{{ url('/') }}/components/js/jquery.validate.js" type="text/javascript"></script>
<script src="{!! url('components/front-end/js/jquery.maskedinput.js') !!}"></script>
<script type="text/javascript">
		 $(document).ready(function(){$(".phoneMask").mask("(999) 999-9999");});
</script>


<?php
	if($customerAddressID==0){
		$customerAddressID=old('customerAddressID')?old('customerAddressID'):0;	
	}
	if($typeID==0){
    	$typeID = old('typeID')? old('typeID') :0;
	}
	$firstName = old('firstName')? old('firstName') : '';
	$lastName = old('lastName')? old('lastName') : '';
	$address1 = old('address1')? old('address1') : '';
	$address2 = old('address2')? old('address2') : '';
	$city = old('city')? old('city') : '';
	$state = old('state')? old('state') : '';
	$country = old('country')? old('country') : '';
	$zipcode = old('zipcode')? old('zipcode') : '';
	$phone = old('phone')? old('phone') : '';

	
	// Set exsiting address variable.	
	if(isset($addressRecordCount) && $addressRecordCount > 0){
		if(isset($qGetAddressData)){
			$customerAddressID = $qGetAddressData[0]->customerAddressID;
			$typeID = $qGetAddressData[0]->typeID;
			$firstName = $qGetAddressData[0]->firstName;
			$lastName = $qGetAddressData[0]->lastName;
			$address1 = $qGetAddressData[0]->address1;
			$address2 = $qGetAddressData[0]->address2;
			$city = $qGetAddressData[0]->city;
			$state = $qGetAddressData[0]->state;
			$country = $qGetAddressData[0]->country;
			$zipcode = $qGetAddressData[0]->zipcode;
			$phone = $qGetAddressData[0]->phone;
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
			zipcode:{required:true,number: true},
		},
		messages: {
				firstName: "{{ Config::get('commonmessage.msg_validate_firstname','Please enter first name') }}",
				lastName: "{{ Config::get('commonmessage.msg_validate_lastname','Please enter last name') }}",
				address1: "{{ Config::get('commonmessage.msg_validate_address1','Please enter address') }}",
				city: "{{ Config::get('commonmessage.msg_validate_city','Please enter city') }}",
				country: "{{ Config::get('commonmessage.msg_validate_country','Please select country') }}",
				state:"{{ Config::get('commonmessage.msg_validate_state','Please select state') }}",
				zipcode:{required:"{{ Config::get('commonmessage.msg_validate_zipcode','Please enter zipcode') }}",number:"{{ Config::get('commonmessage.msg_validate_validnumber','Please enter valid zipcode') }}"},
				
			}
		});
});
</script>
@endif

<script type="text/javascript"> 
function fun_getallstate(){
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
}
</script>

<!-- start ckeck_out left area-->
	<div class="col-sm-7 col-md-8 col-xs-12 col-lg-8 check_out_left">
        @include('include.message')
		<form class="bg-w-form" id="frm_billingaddress" name="frm_billingaddress" action="{{ url('/') }}/action/customeraddressaddedit"  method="post" >
            <input type="hidden" value="{{$customerAddressID}}" id="customerAddressID" name="customerAddressID">
			<input type="hidden" value="{{$typeID}}" id="typeID" name="typeID">
            <input type="hidden" value="{{$state}}" id="getStateID" name="getStateID">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                <div class="row add_shipping_billing_info">
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="control-label form-label">First Name <span class="highlight"> * </span></label>
                            <input type="text" maxlength="100" class="form-control" value="{{$firstName}}" placeholder="Enter First Name" id="firstName" name="firstName">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
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
                        <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
                            <label class="control-label form-label">Country <span class="highlight"> * </span></label>
                            <select id="country" name="country"  class="form-control" onchange="fun_getallstate()">
                                <option value="">-- Select Country --</option>
                                   @if($countryRecordCount > 0)
                                        @foreach($qGetCountryData as $resultCountryData)
                                            <option value="{{$resultCountryData->country_id}}" @if($resultCountryData->country_id == $country) selected="selected" @endif >{{$resultCountryData->country_name}}</option>
                                        @endforeach
                                   @endif
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="control-label form-label">State <span class="highlight"> * </span></label>
                            <select id="stateID" name="state"  class="form-control">
                                <option value="">-- Select State --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                             <label class="control-label form-label">City <span class="highlight"> * </span></label>
                             <input type="text" class="checkbox_text form-control" value="{{$city}}"  placeholder="Enter City" name="city" id="city" maxlength="100">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="control-label form-label">Zip Code <span class="highlight"> * </span></label>
                            <input type="text" maxlength="6" class="checkbox_text form-control" placeholder="Enter ZipCode" value="{{$zipcode}}" name="zipcode" id="zipcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                            <label class="control-label form-label">Phone</label>
                            <input type="text" maxlength="20" class="checkbox_text form-control phoneMask" placeholder="Enter Phone Number" value="{{$phone}}" id="phone" name="phone">
                        </div>
                    </div>
				 <div class="form-group">	
                      <div class="col-sm-12 col-md-12 col-xs-12 check_out_step_btn">
                          <input type="submit" value="Continue" name="shipingcontinue" class="btn btn-grey video-btn-right">
                      </div>
                </div>
            </div>
          </div>
            <!-- start billing method -->
        </form>
    </div>
    
<!-- end ckeck_out left area-->
<script>
fun_getallstate();
</script>