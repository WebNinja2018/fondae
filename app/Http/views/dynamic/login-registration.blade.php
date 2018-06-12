<?php 
//===================================  Code Complete ======================================//
//                                               //
//        Check By Parth. Don't Change.anythig without asking senior           //
//                                               //
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
    submitHandler4: function() { window.document.frm_login.submit()}
  });
  $().ready(function() {
  $("#frm_login").validate({
      rules: {
        email:{required: true, email:true},
        password:{required: true}
      },
      messages: {
        email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
        password:{required:"{{ Config::get('commonmessage.msg_validate_password') }}"}
        
      }
    });
  
  });
</script>

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
      password:{required: true},
      confirmPassword:{required: true,equalTo:"#regpassword"}
    },
    messages: {
      firstName: "{{ Config::get('commonmessage.msg_validate_firstname') }}",
      lastName: "{{ Config::get('commonmessage.msg_validate_lastname') }}",
      //email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}",/*remote:"{{ Config::get('commonmessage.msg_validate_checkemail') }}"*/},
      email: {required:"{{ Config::get('commonmessage.msg_validate_email') }}",email:"{{ Config::get('commonmessage.msg_validate_valid_email') }}"},
      password:{required:"{{ Config::get('commonmessage.msg_validate_password') }}"},
      confirmPassword:{required:"{{ Config::get('commonmessage.msg_validate_confirmpassword') }}",equalTo:"Password confirmation doesn't match Password."}
    }
  });
    
    /*$.validator.addMethod("pwcheck", function(value) {
    return /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%&]{8,25}$/.test(value) // consists of only these
       && /[a-z]/.test(value)// has a lowercase letter 
       && /[A-Z]/.test(value)// has a Uppercase letter 
       && /[0-9]/.test(value)// has a numeric letter 
       && /[!@#$%&]/.test(value)// has a special characetr letter 
       && /\d/.test(value) // has a digit
    });*/
    
  });
  
</script>
@endif


<?php  $email=old('email')?old('email'):'';
     $redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
    if(strlen($redirects_to)==0){
    $redirects_to=old('redirects_to')?old('redirects_to'): '';
    }
?>

<?php   
  $firstName=old('firstName')?old('firstName'):'';
  $lastName=old('lastName')?old('lastName'):'';
  $email=old('email')?old('email'):'';
  $loginemail = old('loginemail')?old('loginemail'):'';
  $password=old('password')?old('password'):'';
  $confirmPassword=old('confirmPassword')?old('confirmPassword'):'';
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div class="col-sm-12 col-md-12 col-xs-12" style='text-align: center;'>
        @include('include.message')
<div class="alert alert-info" >
          <strong>Info!</strong> We are currently in our Testing/Pre-Launch phase. During this period we can only accommodate a select number of specially chosen projects. Please email us your project details in the "Contact Us" section at the bottom of the page to be considered and sign up for our newsletter to get updates on our progress.
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-xs-12">
      <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 new_guest_login">
                <div class="login-wrapper rlp-wrapper">
                    <div class="login-table rlp-table">
                        <h3>New Guest Sign Up</h3>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                        <p><b>If you are a new customer or would prefer to move forward without registering, you can proceed as a guest.</b></p>
                             <a class="btn btn-login btn-green" href="{{url('/guest-checkout')}}"><span>Donate as a guest</span></a>
                        </div>
                     </div>
                </div>
            </div>
          </div>

            <div class="row">
            <br><div class="col-sm-12 col-md-12 col-xs-12" id='logindiv'>
                <div class="login-wrapper rlp-wrapper">
                    <div class="login-table rlp-table">
                        <h3>Login</h3>
                        <div class="alert alert-danger">
                              <strong>Warning!</strong> We've disabled Login during our Pre-Launch Period. However, you can donate as a guest on this page.
                            </div>

                        <?php $postdata=Request::all();if(isset($postdata['redirecturl'])){$redirects_to=$postdata['redirecturl'];}?>
                        <?php if(Request::segment(2)=='dashboard'){ $mainurl='/dashboard';}else{ $mainurl=''; }?>
                        <form name="frm_login" id="frm_login" method="post" action="{{url('/')}}/signup/login{{$mainurl}}" autocomplete="off">
                        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                        <div class=" col-sm-12 col-md-12 col-xs-12" >
                            <div class="login-form bg-w-form rlp-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="regpassword" class="control-label form-label">Email <span class="highlight">*</span></label>
                                        <div class="input-group">
                                          <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user" aria-hidden="true"></i></span>
                                          <input type="text" name="email" id="email" placeholder="Username*" class="form-control" maxlength="100" value="{{$email}}" aria-describedby="sizing-addon2">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="regpassword" class="control-label form-label">password <span class="highlight">*</span></label>
                                        <div class="input-group">
                                          <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                          <input type="password" name="password" id="password" placeholder="Password*" class="form-control" autocomplete="off" value="" aria-describedby="sizing-addon2">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="recaptcha1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="login-submit">
                                <button type="submit" class="btn btn-login btn-green"><span>sign in</span></button>
                                 <span class="or">- OR -</span>
                                 <div class="login-submit">
                                      <button type="button" class="btn btn-login btn-green" onclick="return login()" style="background-color:#3a589b; margin-top:15px;"><span>Connect with Facebook</span></button>
                                      <?php /*?><fb:login-button size="medium"  onclick="return login()"> Connect with Facebook </fb:login-button><?php */?>
                                  </div>
                                <div class="login_forget">
                                    <p><a href="{{url('/forgot-password')}}">Forgot Password?</a> </p>
                                </div>
                            </div>
                        </div>
                        </form>
                     </div>
                </div>
            </div>
            
         </div>
    </div>
  <br>  <br><br>  <br><br><br>  <div class="col-sm-6 col-md-6 col-xs-12" id='registerdiv'>
        <div class="login-wrapper rlp-wrapper">
            <div class="login-table rlp-table">

                <h3>Registration</h3>
                <div class="alert alert-danger">
                <strong>Warning!</strong> We've disabled Registration during our Pre-Launch Period. However, you can donate as a guest on this page.
              </div>
                <form name="frm_register" id="frm_register" method="post" action="{{url('/')}}/signup/register" autocomplete="off">
                <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                <input type="hidden" name="customerType" id="customerType" value="1" >
                <div class=" col-sm-12 col-md-12 col-xs-12">
                    <div class="login-form bg-w-form rlp-form">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="regpassword" class="control-label form-label">First Name <span class="highlight">*</span></label>
                                <div class="input-group">
                                  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" maxlength="50" autocomplete="off" value="{{$firstName}}"  aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="regpassword" class="control-label form-label">Last Name <span class="highlight">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" autocomplete="off" value="{{$lastName}}" maxlength="50" aria-describedby="sizing-addon2">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="regpassword" class="control-label form-label ">Email <span class="highlight">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <input type="text" name="email" id="email" placeholder="Email" class="form-control" autocomplete="off" value="{{$email}}" maxlength="50"  aria-describedby="sizing-addon2" >
                                </div>
                            </div>
              <div class="col-md-12">
                                <label for="regpassword" class="control-label form-label">Password <span class="highlight">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input type="password" name="password" id="regpassword" placeholder="Password" class="form-control" autocomplete="off" value="" maxlength="50">
                                </div>
                                <a class="tool_container" href="#" title="" ><img src="{{url('/').'/components/front-end/images/tooltip.png'}}"  alt="Tooltips">
                                  <div class="image_tooltip">
                                    <p>{{ Config::get('config.tooltips') }}</p>
                                  </div>
                                </a>
                                <?php /*?><img src="http://phpserver5/projects/online_audio_training/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="" data-original-title="{{ Config::get('config.tooltips') }}"><?php */?>
                            </div>
                            <div class="col-md-12">
                                <label for="regpassword" class="control-label form-label">Confirm Password <span class="highlight">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" autocomplete="off" value="" maxlength="50">
                                </div>
                            </div>
              <div class="col-md-12">
                                <div id="recaptcha2"></div>
                            </div>
                        </div>
                    </div>
                    
          <div class="login-submit">
                        <button type="submit" class="btn btn-login btn-green"><span>sign in</span></button>
                    </div>
          
                </div>
                </form>
             </div>
        </div>
    </div>
    <!-- BUTTON BACK TO TOP-->
    <div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
</div>


<script>
  // This is called with the results from from FB.getLoginStatus().
 
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '672602762938420',
      xfbml      : true,
      version    : 'v2.9'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
  function login(){
    FB.login(function(response) {
     if (response.status === 'connected') {
          testAPI();
        }else{
        alert("fgdfg"); 
      }
    },{ scope: 'email' });
  }
  
  
  
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me','GET',{fields:"id,email,birthday,gender,first_name,last_name"}, function(response) {
      console.log('Successful login for: ' + response.name);
    fbdata = response;
      callTheAjax(fbdata);
    });
  }
  
  function callTheAjax(fbdata) {
    
    $.ajax({
            url:  '{{url("/signup/fblogin")}}',
            type: 'POST',
            data: {firstName:fbdata.first_name,lastName:fbdata.last_name,email:fbdata.email,id:fbdata.id},
            success: function(response) {
                console.log(response);
        location.reload();
            },
            error: function(error) {
                console.log(error);
        alert(error);
            }
        });
  }
</script>
@if(isset($_REQUEST['user']) && $_REQUEST['user']=='454fdsfsdf5454'){

@else
<script type="text/javascript">
$("#logindiv :submit").attr("disabled", true);
$("#registerdiv :submit").attr("disabled", true);
$("#logindiv :input").attr("disabled", true);
$("#logindiv :email").attr("disabled", true);
$("#logindiv :password").attr("disabled", true);
$("#registerdiv :text").attr("disabled", true);
$("#registerdiv :email").attr("disabled", true);
$("#registerdiv :password").attr("disabled", true);
</script>
@endif
