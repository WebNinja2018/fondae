<?php 
//===================================  Code Complete ======================================//
//																						   //
//				Check By Ajay. Don't Change.anythig without asking senior				   //
//																						   //
//===================================  Code Complete ======================================//
?>
<?php
use App\Http\Models\Cart;

$cartData = array('uID'=>$_COOKIE['uID']);

$Cart= new Cart;
    $cartResult= $Cart->getCardDataWithPrice($cartData);
    $data['recordCount']= $cartResult;

if(Session::get('customerID'))
{
  //return Redirect::away(url('/dashboard'))->send();

    if($data['recordCount']['recordCount']>0)
    {
      return Redirect::away(url('/donate'))->send();
    }
    else
    {
      return Redirect::away(url('/'))->send();
    }
}
?>
@if(Config::get('config.isClientValidationStop', '0')!=1)
<script>
	$.validator.setDefaults({
	submitHandler: function() { window.document.frm_register.submit()}
	});
	$().ready(function() {
	$("#frm_register").validate({
		ignore: ":hidden",
		rules: {
			firstName:{required: true},
			lastName:{required: true},
			//email:{required: true, email:true,/*remote: {url: "{{url('/')}}/signup/ajaxCheckCustomerEmailExist",type: "post"}*/},
			email:{required: true, email:true},
		},
		messages: {
			firstName: "{{ Config::get('commonmessage.msg_validate_firstname') }}",
			lastName: "{{ Config::get('commonmessage.msg_validate_lastname') }}",
			//email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}",/*remote:"{{ Config::get('commonmessage.msg_validate_checkemail') }}"*/},
			email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
		}
	});
		
		$.validator.addMethod("pwcheck", function(value) {
		return /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&]{8,25}$/.test(value) // consists of only these
		   && /[a-z]/.test(value)// has a lowercase letter 
		   && /[A-Z]/.test(value)// has a Uppercase letter 
		   && /[0-9]/.test(value)// has a numeric letter 
		   && /[!@#$%&]/.test(value)// has a special characetr letter 
		   && /\d/.test(value) // has a digit
		});
		
	});
	
</script>
@endif


<?php  $email=old('email')?old('email'):'';
	   $redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
		if(strlen($redirects_to)==0){
		$redirects_to=old('redirects_to')?old('redirects_to'): 'guest-checkout';
		}
?>

<?php 	
	$firstName=old('firstName')?old('firstName'):'';
	$lastName=old('lastName')?old('lastName'):'';
	$email=old('email')?old('email'):'';
?>
<style>
	.bg-w-form .form-group { float:left; width:100%;}
</style>
<div class="contact-main-wrapper">
    @if(Session::has('flash_message'))
        <div class="error" align="center">{{ Session::get('flash_message') }}</div>
    @endif
    
    <div class="row">
        <!--div class="col-md-4 contact-method">
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
             </div-->
        </div>
		
        <div class="col-md-10 contact-method">
			@include('include.message')
           <div class="method-item">
               <h6><i class="fa fa-sign-in"></i> CHECK OUT AS A GUEST</h6>
               <form class="bg-w-form my_profile contact-form" name="frm_register" id="frm_register" method="post" action="{{url('/')}}/signup/guestcheckout" autocomplete="off">
                        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                        <input type="hidden" name="customerType" id="customerType" value="2" >
                        <div class=" col-sm-12 col-md-12 col-xs-12">
                            <div class="login-form bg-w-form rlp-form">
                                <div class="row">
                                	<div class="col-sm-12 col-md-12 col-xs-12">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="regpassword" class="control-label form-label">First Name <span class="highlight">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                    <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" maxlength="50" autocomplete="off" value="{{$firstName}}"  aria-describedby="sizing-addon2">
                                                </div>
                                             </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="regpassword" class="control-label form-label">Last Name <span class="highlight">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                    <input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" autocomplete="off" value="{{$lastName}}" maxlength="50" aria-describedby="sizing-addon2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="regpassword" class="control-label form-label ">Email <span class="highlight">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                                    <input type="text" name="email" id="email" placeholder="Email" class="form-control" autocomplete="off" value="{{$email}}" maxlength="50"  aria-describedby="sizing-addon2" >
                                                </div>
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
                                </div>
                            </div>
                             <div class="row">
                              <div class="login-submit col-md-4">
                                <button type="submit" class="btn btn-login btn-green"><span>Continue</span></button>
                             </div>    <div class="clear-fix"></div>  
                             <br> <br> <br><div class=" col-md-4">
                                    
                            </div>
                            
                           
                        </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
	<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
</div>