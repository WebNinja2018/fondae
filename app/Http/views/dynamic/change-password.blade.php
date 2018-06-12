@if(Config::get('config.isClientValidationStop', '0')!=1)
<script>
$.validator.setDefaults({
submitHandler2: function() { window.document.frm_changepassword.submit()}
});
$().ready(function() {
$("#frm_changepassword").validate({
	ignore: ":hidden",
	rules: {
			password:{required: true},
			new_password:{required: true,pwcheck: true},
			confirm_password:{required: true,equalTo:"#new_password"}
			},
			
	messages:{
				password:{required:"Please enter password.",pwcheck:"Invalid format.<a class='tool_container_message' href='#' title=''>Click here<div class='image_tooltip'><p>Your password needs to contain minimum length of 6 characters.</p></div></a> to view password requirement."},
				new_password: {required:"Please enter new password."},
				confirmPassword:{required:"Please enter confirm password.",equalTo:"Please enter valid confirm password."}
			 }
	});
	$.validator.addMethod("pwcheck", function(value) {
			  return /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,25}$/.test(value) // consists of only these
			  && /[a-z]/.test(value)// has a lowercase letter 
			  && /[A-Z]/.test(value)// has a Uppercase letter 
			  && /[0-9]/.test(value)// has a numeric letter 
			  && /[!@#$%]/.test(value)// has a special characetr letter 
			  && /\d/.test(value) // has a digit
			});
	});
</script>
@endif
<?php 	
	$password=old('password')?old('password'):'';
	$new_password=old('new_password')?old('new_password'):'';
	$confirm_password=old('confirm_password')?old('confirm_password'):'';
?>
<div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner">
    <div class="method-item right_form">
		@include('include.message')
        <h6><i class="fa fa-lock"></i>Change Password </h6>
        <form class="bg-w-form my_profile" name="frm_changepassword" id="frm_changepassword" method="post" action="{{url('/')}}/action/changepassword" autocomplete="off">
            <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">old passowrd <span class="highlight">*</span></label>
                        <input type="password" name="password" id="password"  class="form-control form-input" maxlength="100">
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">new password <span class="highlight">*</span></label>
                        <input type="password" name="new_password" id="new_password" class="form-control form-input" maxlength="100">
                    </div>
					<a class="tool_container" href="#" title="" ><img src="{{url('/').'/components/front-end/images/tooltip.png'}}"  alt="Tooltips">
                      <div class="image_tooltip">
                        <p>{{ Config::get('config.tooltips') }}</p>
                      </div>
                    </a>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label class="control-label form-label">confirm password <span class="highlight">*</span></label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-input" maxlength="100">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="contact-submit">
                    <button type="submit" class="btn btn-contact btn-green"><span>Update password</span></button>
                </div>
            </div>	
        </form>
    </div>
</div>
