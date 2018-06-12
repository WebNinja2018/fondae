@if(Config::get('config.isClientValidationStop', '0')!=1)
<script>
	$.validator.setDefaults({
	submitHandler2: function() { window.document.frm_myprofile.submit()}
	});
	$().ready(function() {
	$("#frm_myprofile").validate({
		ignore: ":hidden",
		rules: {
			firstName:{required: true},
			lastName:{required: true},
			email:{required: true, email:true},
		},
		messages: {
			firstName: "{{ Config::get('commonmessage.msg_validate_firstname') }}",
			lastName: "{{ Config::get('commonmessage.msg_validate_lastname') }}",
			email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
			}
	});
	});
	
</script>
@endif

<?php 
	$customerID=old('customerID')?old('customerID'):'';	
	$firstName=old('firstName')?old('firstName'):'';
	$lastName=old('lastName')?old('lastName'):'';
	$email=old('email')?old('email'):'';
	
	if(isset($qGetcustomerData))
	{
		foreach($qGetcustomerData as $getCustomerData)
		{
			$customerID = $getCustomerData->customerID;
			$firstName = $getCustomerData->firstName;
			$lastName = $getCustomerData->lastName;
			$email = $getCustomerData->email;
			$password = $getCustomerData->password;
		}
	}
?>

<div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner">
    <div class="method-item right_form">
		@include('include.message')
        <h6><i class="fa fa-user"></i>My Profile</h6>
        <form class="bg-w-form my_profile" name="frm_myprofile" id="frm_myprofile" method="post" action="{{url('/')}}/action/myprofile" autocomplete="off">
			<input type="hidden" name="customerID" value="{{$customerID}}" />
			<input type="hidden" name="email_old" value="{{$email}}" />
            <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">FIRST NAME <span class="highlight">*</span></label>
                        <input type="text" name="firstName" id="firstName" value="{{$firstName}}"  class="form-control form-input" maxlength="100">
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">LAST NAME <span class="highlight">*</span></label>
                        <input type="text" name="lastName" id="lastName" value="{{$lastName}}" class="form-control form-input" maxlength="100">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">EMAIL ID <span class="highlight">*</span></label>
                        <input type="text" name="email" id="email" value="{{$email}}" placeholder="Email" class="form-control form-input" maxlength="100">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="contact-submit">
                    <button type="submit" class="btn btn-contact btn-green"><span>Update</span></button>
                </div>
            </div>	
        </form>
    </div>
</div>
