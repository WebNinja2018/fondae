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
            submitHandler3: function() { window.document.frm_unsubscribe.submit() }
        });
        $.metadata.setType("attr", "validate");
        $().ready(function() {
        // validate the comment form when it is submitted
        $("#frm_forgotpassword").validate({
            rules: {
                 email:  {required: true,email: true},
                
        },
            messages: {
                email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
                }
            });
        });
    
    </script>
@endif
<?php 	
	$email=old('email')?old('email'):'';
	$url_title = (Request::segment(1))? Request::segment(1) : 0;
?>
<style>
	.bg-w-form .form-group { float:left; width:100%;}
</style>

  
<div class="contact-main-wrapper">
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
		
        <div class="col-md-8 contact-method">
			@include('include.message')
           <div class="method-item">
               <h6><i class="fa fa-envelope"></i> Un-Subscribe</h6>
               <form class="bg-w-form my_profile contact-form" name="frm_unsubscribe" id="frm_unsubscribe" method="post" action="{{ url('/') }}/action/unsubscribe">
                <div class=" col-sm-12 col-md-12 col-xs-12">
                    <div class="login-form bg-w-form rlp-form">
                    	<div class="row">
                            <div class="col-sm-12 col-md-12 col-xs-12">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label form-label">Email <span class="highlight">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            <input type="text" name="email" id="email" value="{{$email}}" maxlength="100" placeholder="Email*" class="form-control" autocomplete="off" aria-describedby="sizing-addon2">
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
                    <div class="contact-submit" >
                        <button class="btn btn-contact btn-green" type="submit" name="save1" id="save1" ><span>SUBMIT</span></button>
                    </div>
                  </div>
               </form>
            </div>
        </div>
    </div>
</div>
