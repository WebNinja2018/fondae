<link rel="shortcut icon" type="image/ico" href="{!! url('components/images/favicon.png') !!}" >
@if($filename =='conference')
<title>@if(strlen($qGetProductResult[0]->productName)>0){{$qGetProductResult[0]->productName}}@else{{$qGetPagesResult[0]->pageName}}@endif  | Connecting The Crowd And The Funders Through Social Events</title>
<meta name="description" content="{!!$qGetProductResult[0]->metaDescription!!}">
<meta name="keywords" content="{!!$qGetProductResult[0]->metaKeyword!!}">
@else
<title>{{$qGetPagesResult[0]->pageName}}  | Connecting The Crowd And The Funders Through Social Events</title>
<meta name="description" content="{!!$qGetPagesResult[0]->pageMetaDescription!!}">
<meta name="keywords" content="{!!$qGetPagesResult[0]->pageMetaKeywords!!}">
@endif
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- start css -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600,400italic,800italic,700italic,300italic,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,300,200,900,800,600,500' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/font-awesome.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/owl.theme.css')}}">  
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/w3.css')}}">  
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/hover-min.css')}}"> 
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/prettyPhoto.css')}}">
<link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/loader.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{!! url('components/front-end/css/ch.css') !!}">

<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/style.css') !!}" id="color-skins" >
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/responsive2.css') !!}" id="color-skins" >
<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/responsive.css') !!}" id="color-skins" >
<!-- end css -->

<script src="{{url('/components/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>

<script src="{{url('/')}}/components/front-end/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/components/front-end/js/jquery-smoothscroll.js"></script>
<script src="{{url('/')}}/components/front-end/js/owl.carousel.min.js"></script>
<style type="text/css">.fancybox-margin{margin-right:17px;}</style>

<?php /*?><script src="{{url('/components/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ url('/components/js/bootstrapValidator.js') }}"></script>
<link rel="stylesheet" href="{{ url('/components/css/bootstrapValidator.css') }}"/><?php */?>
<!-- start contact us js -->
	<script src="{{ url('/') }}/components/js/jquery.metadata.js" type="text/javascript"></script>
    <script src="{{ url('/') }}/components/js/jquery.validate.js" type="text/javascript"></script>

	@if ($filename == 'contactus' || $filename == 'login-registration' || $filename == 'checkout-shipping'|| $filename == 'checkout-billing'|| $filename == 'conference'|| $filename == 'myprofile'|| $filename == 'forgot-password'|| $filename == 'reset-password'|| $filename == 'guest-checkout'|| $filename == 'un-subscribe')
		<script src="{!! url('components/front-end/js/jquery.maskedinput.js') !!}"></script>
        <script type="text/javascript">
                 $(document).ready(function(){$(".phoneMask").mask("(999) 999-9999");});
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>

        <script type="text/javascript">
              var recaptcha1;
              var recaptcha2;
              var myCallBack = function() {
                //Render the recaptcha1 on the element with ID "recaptcha1"
                recaptcha1 = grecaptcha.render('recaptcha1', {
                  'sitekey' : "{{Config::get('config.CaptchaSiteKey')}}", //Replace this with your Site key
                  'theme' : 'light',
				  'callback': 'verifyCallback'  // optional
                });
                
                //Render the recaptcha2 on the element with ID "recaptcha2"
                recaptcha2 = grecaptcha.render('recaptcha2', {
                  'sitekey' : "{{Config::get('config.CaptchaSiteKey')}}", //Replace this with your Site key
                  'theme' : 'light',
				  'callback': 'verifyCallback'  // optional
                });
              };
        </script>
    @else
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

	
<!-- end contact us js -->
@if ($filename == 'billinginfo' || $filename == 'shippinginfo')
	<script src="{{url('/')}}/components/front-end/js/thickbox.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/thickbox.css') !!}">
@endif

<script type="text/javascript">
		function delayer(){
			window.location = "{{url('/')}}/";
		}
		window.onload=function(){  $("#page").fadeOut(2000); }
</script>

<style type="text/css">
.corner-date-background {
    width: 0;
    height: 0;
    position: absolute;
    z-index: 9990;
    border-style: solid;
    border-width: 70px 70px 0 0;
    border-color: #ffc34d transparent transparent transparent;
}
.deadline-month {
    position: absolute;
    z-index: 999999;
    font-size: 16px;
    font-weight: bold;
    color: #000000;
    top: 1px;
    left: 1px;
}
.deadline-day {
    position: absolute;
    z-index: 999999;
    font-size: 20px;
    font-weight: bold;
    color: #000000;
    top: 21px;
    left: 1px;
}

.project-header-title{
    top: 57px;
    position: absolute;
}
.project-header-tagline{
    color: #fff;
    position: absolute;
    top: 25%;
    margin-left: 12px;
}
.gm-marker {
    margin-bottom: -3px;
    height: 20px;
    width: 20px;
    padding-left:18px;
    background: url("img/gm-marker.png") no-repeat center;
}
</style>
<script>
$( function() {
  // init Isotope
  var $container = $('.isotope').isotope({
    itemSelector: '.children'
  });

  // store filter for each group
  var filters = {};

  $('#filters').on( 'click', '.button', function() {
    var $this = $(this);
    // get group key
    var $buttonGroup = $this.parents('.button-group');
    var filterGroup = $buttonGroup.attr('data-filter-group');
    // set filter for group
    filters[ filterGroup ] = $this.attr('data-filter');

    // combine filters
    var filterValue = '';
    for ( var prop in filters ) {
      filterValue += filters[ prop ];
    }
    // set filter for Isotope
    $container.isotope({ filter: filterValue });
  });

  // change is-checked class on buttons
  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function( event ) {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( event.currentTarget ).addClass('is-checked');
    });
  });
  
});

</script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<link type="text/css" rel="stylesheet" href="{!! url('components/front-end/css/jcarousellite.css') !!}">
<script src="{{url('/')}}/components/front-end/js/jcarousellite.js"></script>
<script type="text/javascript">
	$(function() {
		$(".default .carousel").jCarouselLite({
			btnNext: ".default .next",
			btnPrev: ".default .prev"
		});
	});
</script>

<script type="text/javascript">
	$(function() {
		$(".default2 .carousel2").jCarouselLite({
			btnNext: ".default2 .next2",
			btnPrev: ".default2 .prev2",
			visible: 3,
			auto: 1000,
            speed: 1000,
		});
	});
</script>