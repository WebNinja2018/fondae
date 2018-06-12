<?php
if(Session::get('admin_user'))
{
	return Redirect::away(url('/adminarea/home'))->send();
}
$email=old('email')?old('email'):'';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reset Password</title>
        
        <link rel="stylesheet" href="{{ url('/') }}/components/bootstrap/css/bootstrap.min_blue.css" id="cssId">
        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="{{ url('/') }}/components/css/style.css">
         <link rel="stylesheet" href="{{  url('/') }}/components/css/skins/_all-skins.min.css">
        <!-- Latest compiled and minified JavaScript -->
       	<script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="{{ url('/') }}/components/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{ url('/') }}/components/css/bootstrapValidator.css"/>
        <script type="text/javascript" src="{{ url('/') }}/components/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/components/js/bootstrapValidator.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="IE/html5shiv.min.js"></script>
            <script src="IE/respond.min.js"></script>
        <![endif]-->
		<script src="{{url('/components/js/demo.js') }}" type="text/javascript"></script>
        <!-- Validation End -->
        <script type="text/javascript">
			function funPageNav(pageno)
			{
				var formname = $('#formname').val();
				$('#pageno').val(pageno);
				$('#'+formname).submit();
			}
			function getCookie(c_name)
			{
				if (document.cookie.length>0)
				  {
				  c_start=document.cookie.indexOf(c_name + "=");
				  if (c_start!=-1)
					{ 
					c_start=c_start + c_name.length+1; 
					c_end=document.cookie.indexOf(";",c_start);
					if (c_end==-1) c_end=document.cookie.length;
					return unescape(document.cookie.substring(c_start,c_end));
					} 
				  }
				return "";
			}
			function Set_Cookie( name, value, expires, path, domain, secure ) 
			{
				// set time, it's in milliseconds
				var today = new Date();
				today.setTime( today.getTime() );

				if ( expires )
				{
				expires = expires * 1000 * 60 * 60 * 24;
				}
				var expires_date = new Date( today.getTime() + (expires) );

				document.cookie = name + "=" +escape( value ) +
				( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
				( ( path ) ? ";path=" + path : "" ) + 
				( ( domain ) ? ";domain=" + domain : "" ) +
				( ( secure ) ? ";secure" : "" );
			}
			function setCookie(c_name,value,expiredays)
				{var exdate=new Date();exdate.setDate(exdate.getDate()+expiredays);
				document.cookie=c_name+ "=" +escape(value)+
				((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
			}
			changeTo(getCookie('mysheet'));			
			function changeTo(s)
			{
				if(s==null || s=='undefined' || s == '' || s == 'none')
				{s='blue';}	
				document.getElementById('cssId').href="{{ url('/') }}/components/bootstrap/css/bootstrap.min_" + s + ".css";
				Set_Cookie('mysheet',s,'30','/','','');	
			}
		</script>
		
		

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="IE/html5shiv.min.js"></script>
            <script src="IE/respond.min.js"></script>
        <![endif]-->
        <script>
		(function(){
			  // if firefox 3.5+, hide content till load (or 3 seconds) to prevent FOUT
			  var d = document, e = d.documentElement, s = d.createElement('style');
			  if (e.style.MozTransform === ''){ // gecko 1.9.1 inference
				s.textContent = 'body{visibility:hidden}';
				var r = document.getElementsByTagName('script')[0];
				r.parentNode.insertBefore(s, r);
				function f(){ s.parentNode && s.parentNode.removeChild(s); }
				addEventListener('load',f,false);
				setTimeout(f,1000);
			  }
			})();
			$(document).ready(function(){
			  $(".16px").click(function(){
				$( "body" ).addClass( "body_16px" );
				$( "body" ).removeClass( "body_14px" );
				$( "body" ).removeClass( "body_12px" );
			  });
			});
			$(document).ready(function(){
			  $(".14px").click(function(){
				$( "body" ).addClass( "body_14px" );
				$( "body" ).removeClass( "body_16px" );
				$( "body" ).removeClass( "body_12px" );
			  });
			});
			$(document).ready(function(){
			  $(".12px").click(function(){
				$( "body" ).addClass( "body_12px" );
				$( "body" ).removeClass( "body_16px" );
				$( "body" ).removeClass( "body_14px" );
			  });
			});

		</script>
    </head>
    <body class="hold-transition skin-green sidebar-mini">
    	{{ Session::get('admin_user') }}
        <nav class="navbar navbar-default login_header" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                	<a class="navbar-brand" href="#">{{ Config::get('config.site_title', 'Yatharth') }}</a>
                </div>
            </div>
        </nav>
        <div class="login_bg">
        	<div class="login-box-body">
                <div class="login_form">
                    <div class="login-logo">
                        <h1>Admin Management Area</h1>
                    </div>
					@if($custoemerRecordcount>0)
               	 		@if($hashkey==md5(date('Ymd',strtotime('now'))))
                            <div>
                              <form class="" name="frm_defaultForm" id="defaultForm" action="{{ url('/') }}/adminarea/resetpassword_process" method="post" autocomplete="off" > 
                                @include('adminarea.include.message')
								<input type="hidden" name="md5userID" value="{{$md5userID}}">
            					<input type="hidden" name="hashkey" value="{{$hashkey}}">
                                <div class="col-sm-12 col-xs-12 col-md-12">
                                    <div class="row">
                                        <p class="ip_address_text">You are accessing site through IP address: {{$_SERVER['SERVER_ADDR']}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                        <input type="password" placeholder="Password" id="new_password" name="new_password" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                        <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="g-recaptcha" style="float:right; margin:0 10px 0 0;" data-sitekey="{{ Config::get('config.CaptchaSiteKey', '') }}"></div>
                                    </div>
                                </div>
                                <div class="sign_btn">
                                    <button type="submit" class="btn btn-block btn-flat">Update password</button>
                                </div>
                            </form>
                            </div>
						@else
                            <h4 style="color:#FF0000; text-align:center">Your Link is Expire.</h4>
                        @endif
                    @else
                        <h4 style="color:#FF0000; text-align:center">Invalid CustomerID</h4>
                    @endif
                    
                <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div>
                
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-xs-12 footer_login">
        	<div class="row">
            	<div class="login_footer">
                	<p>Copyright &copy; <?php echo date('Y',strtotime('now'));?> <a href="http://hrinfocare.com" target="_blank">HR Infocare Private Limited</a>. All rights reserved.</p>
                </div>
            </div>
        </div>

    </body>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#defaultForm').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					email: {
								validators: {notEmpty: {message: 'The email address is required and can\'t be empty'},
								emailAddress: {message: 'The input is not a valid email address'}
							}
						},
					pwd:{
								validators: {notEmpty: {message: 'Please Enter Password'}
							}
						}	
				}
			});
		});
    </script>
</html>