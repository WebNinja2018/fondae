@if(Config::get('config.isClientValidationStop', '0')!=1)
<script type="text/javascript">
	$.validator.setDefaults({
		submitHandler12: function() { window.document.frm_newsletter.submit() }
	});
	$.metadata.setType("attr", "validate");
	$().ready(function() {
		$("#frm_newsletter").validate({
			rules: {
				email: {required: true,email:true,remote: {type: 'POST',url: "{{ url('/') }}/action/chackenewsletter",delay: 1000}},
			},
			messages: {
				email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}",						                remote:"You are already subscribed !"},
			}
		});
	});


//$(document).ready(function() {
//    $('#frm_newsletter').bootstrapValidator({
//        message: 'This value is not valid',
//        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
//        },
//		fields: {
//				email:{
//					message: 'Please Enter Valid Email ID',
//					validators: 
//						{
//							notEmpty:{message: 'Please Enter Email'},
//							emailAddress: {message: 'Please Enter Valid Email'},
//							remote: {
//										type: 'POST',
//										url: "{{ url('/') }}/action/chackenewsletter",
//										message: 'Please enter unique email.',
//										delay: 1000
//							}
//														
//						}
//				},
//			}
//    });
//});
</script>
@endif

<?php $email=old('email')?old('email'):''; ?>
<form name="frm_newsletter" id="frm_newsletter" method="post" action="{{ url('/') }}/action/enewsletter">
    <input type="text" name="email" maxlength="100" id="name" class="form-control" required autocomplete="off" value="{{$email}}" /> 
    <div class="form-btn">
        <button type="submit" name="save" class="hvr-shutter-out-horizontal">Sign Up Now</button>                         
    </div>
</form>
