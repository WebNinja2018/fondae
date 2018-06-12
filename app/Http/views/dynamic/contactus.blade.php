<?php 
//===================================  Code Complete ======================================//
//																						   //
//				Check By Ajay. Don't Change.anythig without asking senior				   //
//																						   //
//===================================  Code Complete ======================================//
?>
@if(Config::get('config.isClientValidationStop', '0')!=1)
	<script type="text/javascript">
        $.validator.setDefaults({
            submitHandler3: function() { window.document.frm_contactus.submit() }
        });
        $.metadata.setType("attr", "validate");
        $().ready(function() {
        // validate the comment form when it is submitted
        $("#frm_contactus").validate({
            rules: {
                firstName: {required: true},
                lastName: {required: true},
				phone: {required: true},
				comment: {required: true},
                email:  {required: true,email: true},
				
                
        },
            messages: {
                firstName:"{{ Config::get('commonmessage.msg_validate_firstname') }}",
                lastName:"{{ Config::get('commonmessage.msg_validate_lastname') }}",
				phone:"{{ Config::get('commonmessage.msg_validate_phone','Please enter phone number.') }}",
				comment:"{{ Config::get('commonmessage.msg_validate_comment','Please enter comment.') }}",
                email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
                }
            });
        });
    
    </script>
@endif
<?php 	
	$firstName=old('firstName')?old('firstName'):'';
	$lastName=old('lastName')?old('lastName'):'';
	$email=old('email')?old('email'):'';
	$phone=old('phone')?old('phone'):'';
	$comment=old('comment')?old('comment'):'';
	$url_title = (Request::segment(1))? Request::segment(1) : 0;
?>

  
<div class="contact-main-wrapper">
    @if(Session::has('flash_message'))
        <div class="error" align="center">{{ Session::get('flash_message') }}</div>
    @endif
    
    <div class="row">
        <div class="col-md-4 contact-method">
            <div class="col-md-12">
                <div class="method-item">
                    <h6><i class="fa fa-map-marker"></i> {{Config::get('config.contactTitle', 'HR Infocare PVT.LTD')}}</h6>
                    <div class="detail">
                        <div class="col-md-1"><div class="row"><i class="fa fa-map-marker"></i></div></div>
                        <p>{!!Config::get('config.contactAddress')!!}</p>
                    </div>
					@if(strlen(Config::get('config.contactNumber'))>0)
                    <div class="detail">
                        <div class="col-md-1"><div class="row"><i class="fa fa-phone"></i></div></div>
                        <p>{{Config::get('config.contactNumber', '')}}</p>
                    </div>
					@endif
					@if(strlen(Config::get('config.contactEmail'))>0)
                    <div class="detail">
                        <div class="col-md-1"><div class="row"><i class="fa fa-envelope"></i></div></div>
                        <p><a href="#">{{Config::get('config.contactEmail', 'info@hrinfocare.com')}}</a></p>
                    </div>
					@endif
                 </div>
             </div>
        </div>
		
        <div class="col-md-8 contact-method">
			@include('include.message')
           <div class="method-item">
               <h6><i class="fa fa-envelope"></i> Get In Touch With Us</h6>
               <form class="bg-w-form my_profile contact-form" name="frm_contactus" id="frm_contactus" method="post" action="{{ url('/') }}/action/contactus">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label form-label">First Name <span class="highlight">*</span></label>
                                <input type="text"  name="firstName" id="firstName" value="{{$firstName}}" maxlength="50" placeholder="First Name*" class="form-control form-input" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label class="control-label form-label">Last Name <span class="highlight">*</span></label>
                                <input type="text" name="lastName" id="lastName" value="{{$lastName}}" maxlength="50" placeholder="Last Name*" class="form-control form-input" autocomplete="off">
                            </div>
                         </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label form-label">Email <span class="highlight">*</span></label>
                                <input type="text" name="email" id="email" value="{{$email}}" maxlength="100" placeholder="Email*" class="form-control form-input" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label class="control-label form-label">Phone Number <span class="highlight">*</span></label>
                                <input type="text" name="phone" id="phone" value="{{$phone}}" maxlength="20" placeholder="Phone*" class="form-control form-input phone phoneMask" autocomplete="off">
                            </div>
                         </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="control-label form-label">Message</label>	
                                <textarea  name="comment" class="form-control form-input" placeholder="Comment*">{{$comment}}</textarea>
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
                    <div class="contact-submit" >
                        <button class="btn btn-contact btn-green" type="submit" name="save1" id="save1" ><span>SUBMIT CONTACT</span></button>
                    </div>
               </form>
            </div>
        </div>
    </div>
</div>
