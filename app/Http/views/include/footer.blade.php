<div class="clearfix"> </div>
<!--start abover-footer-->
<section id="above-footer" class="module parallax parallax-2">
    <div class="">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="col-md-12">
                    <div class="col-md-6 col-sm-12" >
                        <div class="footer">
                            <img src="{{asset('frontend/images/Charity-logo_03.png')}}" alt="logo">
                        </div>    
                    </div>    
                    <div class="col-md-6 ">
                            <div class="nav-search">
                                <form name="frm_search" id="frm_search" method="post" action="{{ url('/search')}}">
                                    <input type="hidden" value="" name="pageFileName">
                                    <input type="text" name="srchByKeyword" id="srchByKeyword" value="" placeholder="Search" class="searchbox">
                                    <button type="submit" class="searchbutton fa fa-search"></button>
                                </form>
                            </div>
                    </div>        
                    <?php /*?><div class="col-md-6 col-sm-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
                        <div class="footer-above">
                            <div class="footer-info-box">
                                <div class="footer_icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="footer_iconinfo">
                                    <h2>ADDRESS</h2>
                                    <p>250 Elizabeth , NY, US</p>
                                </div>
                            </div>
                            <div class="footer-info-box">
                                <div class="footer_icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="footer_iconinfo">
                                    <h2>Email</h2>
                                    <p>info@fondae.com</p>
                                </div>
                            </div>
                            <div class="footer-info-box">
                                <div class="footer_icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="footer_iconinfo">
                                    <h2>PHONE</h2>
                                    <p>254-256-988-1 or 325-588-687</p>
                                </div>
                            </div>

                        </div>
                    </div><?php */?>
                </div>
                <div class="col-md-12 clearfix">
                    <div class="col-md-6 col-sm-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
                        <div class="footer-above">
                            <div class="footer-info-box">
                                <div class="footer_iconinfo">
                                    <h2>campaigning</h2>
                                    <a href="{{ url('/adminarea')}}">start a campaign</a><br>
                                    <a href="{{ url('/explore')}}">Popular Events</a><br>
                                    <a href="{{ url('/explore')}}">Explore</a><br>
                                    <a href="{{url('/Pricing')}}">Pricing</a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
                        <div class="footer-above">
                            <div class="footer-info-box">
                                <div class="footer_iconinfo">
                                    <h2>about fondae</h2>
                                    <a href="{{url('about')}}">about us</a><br>
                                    <a href="{{url('/blog')}}">Blog</a><br>
                                    <a href="{{url('/faq')}}">FAQ</a><br>
                                    <a href="{{url('/privacy-policy')}}">Trust & Safety</a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6 footer-form-base">
                <div class="col-md-6 ">
                    <div class="footer-form wow fadeIn" data-wow-duration="2s" data-wow-delay="0.4s">
                        <div class="top-head">
                            <h1>Signup for the Fondae Newsletter</h1>
                        </div>
                        <div class="form-form">
                            <div class="expMessage"></div>
                            @include('include.e-newsletter')
                        </div>
                    </div>
                    <div class="grid_6" style="color: #B9B8B9; font-weight: bold; font-size: 16px;">
                    <div class="baronNeueBlack" style="margin-bottom: 15px; color: #fff;">stay in the know</div>
                    <a href="https://twitter.com/fondaedotcom" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @twitter</a>
                    <div>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                    </div>
                    
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=672602762938420";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div style="padding-top:3px"><a target="_blank" href="https://www.facebook.com/fondae/"><img src="{{asset('img/facebook-logo.jpg')}}" style="height: 36px" /></a></div>
                    
                    <div style="padding-top:3px"><a href="http://instagram.com/fondaedotcom"><img src="{{asset('img/instagram.png')}}" style="height: 23px" /></a></div>
                </div>
                </div>
                <div class="col-md-6 ">
                    @include('include.contactus')
                </div>
            </div>

            <div class="container " >
                <div class="col-md-12" style=" border-top: thick solid #e8ae00;"></div>
                <div class="col-sm-2 ">
                    <div style="padding-top: 5px;font: bold;; text-align: left">
                        <a href="{{url('/term-of-use')}}">Terms of Use</a>
                    </div>
                </div>
                <div class="col-sm-2 ">
                    
                    <div style="padding-top: 5px;font: bold;; text-align: left">
                        <a href="{{url('/privacy-policy')}}">Privacy Policy</a>
                    </div>
                </div>
                <div class="col-sm-2 ">
                    <div style="padding-top: 5px;font: bold;; text-align: left">
                        <a href="{{url('cookie-policy')}}">Cookie Policy</a>
                    </div>
                </div>
                
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-3 social_icon text-right">
                    <div class="icon">
                        <a href="{{Config::get('config.facebook', 'https://www.facebook.com/fondae')}}" target="_blank"><i class="fa fa-facebook"></i></a>
                    </div>
                    <?php /*?><div class="icon">
                        <a href="{{Config::get('config.google', 'https://plus.google.com/')}}" target="_blank"><i class="fa fa-google-plus"></i></a>
                    </div><?php */?>
                    <div class="icon">
                        <a href="{{Config::get('config.twitter', 'https://twitter.com/fondaedotcom')}}" target="_blank"><i class="fa fa-twitter"></i></a>
                    </div>
                   <?php /*?> <div class="icon">
                        <a href="{{Config::get('config.pinterest', 'https://www.pinterest.com/')}}" target="_blank"><i class="fa fa-pinterest"></i></a>
                    </div><?php */?>
                    <div class="icon">
                        <a href="{{Config::get('config.instagram', 'https://www.instagram.com/fondaedotcom/')}}" target="_blank"><i class="fa fa-instagram"></i></a>
                    </div>                           
                </div>           
            </div>
            
                 
        </div>
    </div>
</section>
<!--Footer-->
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 footer_text wow fadeIn" data-wow-duration="2s">
                <p>
                    © Copyright 2016 by Fondae. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</section>
<script>
    $("#project-carousel").owlCarousel({
      loop: true,
      nav: true,
      items: 5
    });
    
    $("#help-carousel").owlCarousel({
      loop: true,
      nav: true,
      items: 5
    });
    
</script>

<script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/jquery.appear.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/wow.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<script src="{{asset('frontend/js/custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57 )) {
        return false;
    }
    return true;
}

</script>

<?php /*?><script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '194960100843351',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  //LOGIN - REGISTRATION WITH FACEBOOK BELOW
  function myFacebookLogin() {   
     FB.login(function(response) {
   if (response.status === 'connected') {
     // Logged into your app and Facebook.
     FB.api('/me?fields=name,email', function(response) {
         $.post( "loginfacebook.json", { name: response.name, email: response.email },function(resp){ 
             showMessage(resp.message); 
             if(resp.message.type == MSG_TYPE_OK) {
             setTimeout(function() { window.location = '<?php echo url::site('/user/account')?>'; }, 2000);
         }
         }, 'json');
     });
   } else if (response.status === 'not_authorized') {
     // The person is logged into Facebook, but not your app.
     FB.api('/me?fields=name,email', function(response) {
         $.post( "loginfacebook.json", { name: response.name, email: response.email },function(resp){ 
             showMessage(resp.message); 
             if(resp.message.type == MSG_TYPE_OK) {
             setTimeout(function() { window.location = '<?php echo url::site('/user/account')?>'; }, 2000);
         }
         }, 'json');
       });
   } else {
     alert("Please LogIn to your Facebook.");
     // The person is not logged into Facebook, so we're not sure if
     // they are logged into this app or not.
   }
 }, {scope: 'public_profile,email'});

 }
 // LOGIN - REGISTRATION WITH FACEBOOK ABOWE
</script><?php */?>


