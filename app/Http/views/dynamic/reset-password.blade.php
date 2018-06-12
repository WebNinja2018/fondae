<?php
    $password=old('password')?old('password'):'';
	$confirm_password=old('confirm_password')?old('confirm_password'):'';
?>
<div class="row">
    <div class="col-md-4 contact-method">
        <div class="col-md-12">
            <div class="method-item">
                <h6><i class="fa fa-map-marker"></i> {{Config::get('config.contactTitle', 'HR Infocare PVT.LTD')}}</h6>
                <div class="detail">
                    <div class="col-md-1"><div class="row"><i class="fa fa-map-marker"></i></div></div>
                    <p>{!!Config::get('config.contactAddress')!!}</p>
                </div>
                <div class="detail">
                    <div class="col-md-1"><div class="row"><i class="fa fa-phone"></i></div></div>
                    <p>{{Config::get('config.contactNumber', '9998446909')}}</p>
                </div>
                <div class="detail">
                    <div class="col-md-1"><div class="row"><i class="fa fa-envelope"></i></div></div>
                    <p><a href="#">{{Config::get('config.contactEmail', 'info@hrinfocare.com')}}</a></p>
                </div>
             </div>
         </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner">
        <div class="method-item right_form">
            @include('include.message')
            <h6><i class="fa fa-lock"></i>Reset Password </h6>
			@if($custoemerRecordcount>0)
                @if($hashkey==md5(date('Ymd',strtotime('now'))))
               		<form class="bg-w-form my_profile" name="frm_resetpassword" id="frm_resetpassword" method="post" action="{{url('/')}}/action/resetpassword" autocomplete="off">
						<input type="hidden" name="md5customerID" value="{{$md5customerID}}">
            			<input type="hidden" name="hashkey" value="{{$hashkey}}">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             
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
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div id="recaptcha1"></div>
                                </div>
                            </div>	
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="contact-submit">
                                <button type="submit" class="btn btn-contact btn-green"><span>Update password</span></button>
                            </div>
                        </div>	
                    </form>
                @else
					<h4 style="color:#FF0000; text-align:center">Your Link is Expire.</h4>
                @endif
			@else
				<h4 style="color:#FF0000; text-align:center">Invalid CustomerID</h4>
			@endif
        </div>
    </div>
</div>
@if(Config::get('config.isClientValidationStop', '0')!=1)
<script>
$.validator.setDefaults({
submitHandler2: function() { window.document.frm_resetpassword.submit()}
});
$().ready(function() {
$("#frm_resetpassword").validate({
	ignore: ":hidden",
	rules: {
			new_password:{required: true,pwcheck: true},
			confirm_password:{required: true,equalTo:"#new_password"}
			},
			
	messages:{
				new_password:{required:"Please enter password.",pwcheck:"Invalid format.<a class='tool_container_message' href='#' title=''>Click here<div class='image_tooltip'><p>Your password needs to contain minimum length of 6 characters.</p></div></a> to view password requirement."},
				confirmPassword:{required:"Please enter confirm password.",equalTo:"Please enter valid confirm password."}
			 }
	});
	$.validator.addMethod("pwcheck", function(value) {
			  return /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,25}$/.test(value) // consists of only these
			  //&& /[a-z]/.test(value)// has a lowercase letter 
			  //&& /[A-Z]/.test(value)// has a Uppercase letter 
			  //&& /[0-9]/.test(value)// has a numeric letter 
			  //&& /[!@#$%]/.test(value)// has a special characetr letter 
			  && /\d/.test(value) // has a digit
			});
	});
</script>
@endif
