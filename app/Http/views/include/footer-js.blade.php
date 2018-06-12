<!-- start js -->

<script src="{!! url('components/front-end/js/jquery.metadata.js') !!}" type="text/javascript"></script>
<script src="{!! url('components/front-end/js/jquery.validate.js') !!}" type="text/javascript"></script>
<script src="{!! url('components/front-end/js/jquery.placeholder.js') !!}"></script>
<script src="{!! url('components/front-end/js/bootstrap-datepicker.js') !!}" type="text/javascript"></script>

<script src="{{url('/')}}/components/front-end/js/jquery.appear.js"></script>
<script src="{{url('/')}}/components/front-end/js/jquery.countTo.js"></script>
<script src="{{url('/')}}/components/front-end/js/wow.min.js"></script>
<script src="{{url('/')}}/components/front-end/js/jquery.selectbox-0.2.min.js"></script>
<script src="{{url('/')}}/components/front-end/js/jquery.fancybox.js"></script>
<script src="{{url('/')}}/components/front-end/js/jquery.fancybox-buttons.js"></script>
<!-- MAIN JS-->
<script src="{{url('/')}}/components/front-end/js/main.js"></script>
<!-- LOADING SCRIPTS FOR PAGE-->
<script src="{{url('/')}}/components/front-end/js/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/components/front-end/js/fit-columns.js"></script>
<script src="{{url('/')}}/components/front-end/js/homepage.js"></script>
<script src="{{url('/')}}/components/front-end/js/courses.js"></script>



<!-- start js -->
<script>
	$("#project-carousel").owlCarousel({
	  items: 5
	});
	
	$("#help-carousel").owlCarousel({
	  items: 5
	});
	
	$("#homepage").owlCarousel({
	  items: 1
	});
	
</script>

<script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/jquery.appear.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/wow.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{asset('frontend/js/custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1
      });
    });
</script>
<script type="text/javascript">
$().ready(function(){
    $('#contactus-form').validate({
        submitHandler: function(){
            var curForm = $('#contactus-form');
            $("<div />").addClass("formOverlay").appendTo(curForm);     
            $.ajax({
                url: 'mail.php',
                type: 'POST',
                data: curForm.serialize(),
                success: function(data) {
                var res=data.split("::");
                curForm.find("div.formOverlay").remove();
                curForm.prev('.expMessage').html(res[1]);
                if(res[0]=='Success')
                    {
                       curForm.remove(); 
                       curForm.prev('.expMessage').html('');
                    }              
                }
            });
            return false;
        }   
    })


})
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57 )) {
        return false;
    }
    return true;
}

</script>

<script>
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
             setTimeout(function() { window.location = "{{url('/')}}/user/account"; }, 2000);   <?php /*?><?php echo url::site('/user/account')?><?php */?>
         }
         }, 'json');
     });
   } else if (response.status === 'not_authorized') {
     // The person is logged into Facebook, but not your app.
     FB.api('/me?fields=name,email', function(response) {
         $.post( "loginfacebook.json", { name: response.name, email: response.email },function(resp){ 
             showMessage(resp.message); 
             if(resp.message.type == MSG_TYPE_OK) {
             setTimeout(function() { window.location = '{{url('/')}}/user/account'; }, 2000);  <?php /*?><?php echo url::site('/user/account')?><?php */?>
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
</script>
<!-- end js -->
<!-- end js -->
