
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/ico" href="http://fondae.com/fondae1/components/images/favicon.png" >
    <title>Forgot Password  | Connecting The Crowd And The Funders Through Social Events</title>
    <meta name="description" content="Forgot Password">
    <meta name="keywords" content="Forgot Password">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- start css -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600,400italic,800italic,700italic,300italic,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,300,200,900,800,600,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/w3.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/hover-min.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/prettyPhoto.css">
    <link href="http://fondae.com/fondae1/frontend/css/animate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/loader.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/frontend/css/style.css">
    <link rel="stylesheet" type="text/css" href="http://fondae.com/fondae1/components/front-end/css/ch.css">

    <link type="text/css" rel="stylesheet" href="http://fondae.com/fondae1/components/front-end/css/style.css" id="color-skins" >
    <link type="text/css" rel="stylesheet" href="http://fondae.com/fondae1/components/front-end/css/responsive2.css" id="color-skins" >
    <link type="text/css" rel="stylesheet" href="http://fondae.com/fondae1/components/front-end/css/responsive.css" id="color-skins" >
    <!-- end css -->

    <script src="http://fondae.com/fondae1/components/plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>

    <script src="http://fondae.com/fondae1/components/front-end/js/bootstrap.min.js"></script>
    <script src="http://fondae.com/fondae1/components/front-end/js/jquery-smoothscroll.js"></script>
    <script src="http://fondae.com/fondae1/components/front-end/js/owl.carousel.min.js"></script>
    <style type="text/css">.fancybox-margin{margin-right:17px;}</style>

    <!-- start contact us js -->
    <script src="http://fondae.com/fondae1/components/js/jquery.metadata.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/components/js/jquery.validate.js" type="text/javascript"></script>

    <script src="http://fondae.com/fondae1/components/front-end/js/jquery.maskedinput.js"></script>
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
                'sitekey' : "6LcB2yYUAAAAABqmo9go7_fVtCN9mdljUi7Kibqr", //Replace this with your Site key
                'theme' : 'light',
                'callback': 'verifyCallback'  // optional
            });

            //Render the recaptcha2 on the element with ID "recaptcha2"
            recaptcha2 = grecaptcha.render('recaptcha2', {
                'sitekey' : "6LcB2yYUAAAAABqmo9go7_fVtCN9mdljUi7Kibqr", //Replace this with your Site key
                'theme' : 'light',
                'callback': 'verifyCallback'  // optional
            });
        };
    </script>


    <!-- end contact us js -->

    <script type="text/javascript">
        function delayer(){
            window.location = "http://fondae.com/fondae1/";
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

    <link type="text/css" rel="stylesheet" href="http://fondae.com/fondae1/components/front-end/css/jcarousellite.css">
    <script src="http://fondae.com/fondae1/components/front-end/js/jcarousellite.js"></script>
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
    </script></head>
<body data-spy="scroll" data-target="#fixed-collapse-navbar">
<!--Header-->
<section id="top_header">
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 header_bottom logo text-left">
                    <div class="col-sm-6 contact_info text-right">
                        <a href="http://fondae.com/fondae1"><img src="http://fondae.com/fondae1/frontend/images/Charity-logo_03.png" alt="cahrity LOGO"></a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="navigation" data-spy="affix" data-offset-top="98">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">

                </nav>
            </div>
        </div>
    </div>
</section>
<!--Top Banner-->

<div>
    <div class="container">
        <div class="row">
            <div class="help_base">
                <div class="container">
                    <div class="footer-form wow " data-wow-duration="2s" data-wow-delay="0.4s">


                        <script type="text/javascript">
                            $.validator.setDefaults({
                                submitHandler3: function() { window.document.frm_forgotpassword.submit() }
                            });
                            $.metadata.setType("attr", "validate");
                            $().ready(function() {
                                // validate the comment form when it is submitted
                                $("#frm_forgotpassword").validate({
                                    rules: {
                                        email:  {required: true,email: true},

                                    },
                                    messages: {
                                        email: {required:"Please enter email address.",email:"Please enter correct email address."},
                                    }
                                });
                            });

                        </script>
                        <style>
                            .bg-w-form .form-group { float:left; width:100%;}
                        </style>


                        <div class="contact-main-wrapper">

                            <div class="row">
                                <div class="col-md-10 contact-method">
                                    @if (\Illuminate\Support\Facades\Session::has('message'))
                                        <div class="alert alert-success">
                                            {{ \Illuminate\Support\Facades\Session::get('message') }}
                                        </div>
                                    @endif
                                    <div class="method-item">
                                        <h6><i class="fa fa-envelope"></i> Reset Password</h6>
                                        <form class="bg-w-form my_profile contact-form" name="frm_forgotpassword" id="frm_forgotpassword" method="post" action="{{ route('reset.password',['token' => $token]) }}">
                                            <div class=" col-sm-12 col-md-12 col-xs-12">
                                                {{ csrf_field() }}
                                                <div class="login-form bg-w-form rlp-form">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="control-label form-label">Email <span class="highlight">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                                                        <input type="text" name="email" id="email" value="{{ old('email') }}" maxlength="100" placeholder="Email*" class="form-control" autocomplete="off" aria-describedby="sizing-addon2">
                                                                        @if ($errors->has('email'))

                                                                                <label for="email"  class="error">{{ $errors->first('email') }}</label>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="control-label form-label">Password <span class="highlight">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                                        <input type="password" name="password" id="password" value="" maxlength="100" placeholder="Password*" class="form-control"  aria-describedby="sizing-addon2">
                                                                        @if ($errors->has('password'))

                                                                            <label for="email"  class="error">{{ $errors->first('password') }}</label>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="control-label form-label">Confirm  Password <span class="highlight">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                                        <input type="password" name="password_confirmation" id="password_confirmation" value="" maxlength="100" placeholder="Confirm  Password *" class="form-control"  aria-describedby="sizing-addon2">
                                                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER-->
<footer>
    <div class="clearfix"> </div>
    <!--start abover-footer-->
    <section id="above-footer" class="module parallax parallax-2">
        <div class="">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="col-md-12">
                        <div class="col-md-6 col-sm-12" >
                            <div class="footer">
                                <img src="http://fondae.com/fondae1/frontend/images/Charity-logo_03.png" alt="logo">
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="nav-search">
                                <form name="frm_search" id="frm_search" method="post" action="http://fondae.com/fondae1/search">
                                    <input type="hidden" value="" name="pageFileName">
                                    <input type="text" name="srchByKeyword" id="srchByKeyword" value="" placeholder="Search" class="searchbox">
                                    <button type="submit" class="searchbutton fa fa-search"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 clearfix">
                        <div class="col-md-6 col-sm-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
                            <div class="footer-above">
                                <div class="footer-info-box">
                                    <div class="footer_iconinfo">
                                        <h2>campaigning</h2>
                                        <a href="http://fondae.com/fondae1/adminarea">start a campaign</a><br>
                                        <a href="http://fondae.com/fondae1/explore">Popular Events</a><br>
                                        <a href="http://fondae.com/fondae1/explore">Explore</a><br>
                                        <a href="http://fondae.com/fondae1/Pricing">Pricing</a><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
                            <div class="footer-above">
                                <div class="footer-info-box">
                                    <div class="footer_iconinfo">
                                        <h2>about fondae</h2>
                                        <a href="http://fondae.com/fondae1/about">about us</a><br>
                                        <a href="http://fondae.com/fondae1/blog">Blog</a><br>
                                        <a href="http://fondae.com/fondae1/faq">FAQ</a><br>
                                        <a href="http://fondae.com/fondae1/privacy-policy">Trust & Safety</a><br>
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
                                <script type="text/javascript">
                                    $.validator.setDefaults({
                                        submitHandler12: function() { window.document.frm_newsletter.submit() }
                                    });
                                    $.metadata.setType("attr", "validate");
                                    $().ready(function() {
                                        $("#frm_newsletter").validate({
                                            rules: {
                                                email: {required: true,email:true,remote: {type: 'POST',url: "http://fondae.com/fondae1/action/chackenewsletter",delay: 1000}},
                                            },
                                            messages: {
                                                email: {required:"Please enter email address.",email:"Please enter correct email address.",						                remote:"You are already subscribed !"},
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
                                    //										url: "http://fondae.com/fondae1/action/chackenewsletter",
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

                                <form name="frm_newsletter" id="frm_newsletter" method="post" action="http://fondae.com/fondae1/action/enewsletter">
                                    <input type="text" name="email" maxlength="100" id="name" class="form-control" required autocomplete="off" value="" />
                                    <div class="form-btn">
                                        <button type="submit" name="save" class="hvr-shutter-out-horizontal">Sign Up Now</button>
                                    </div>
                                </form>
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
                            <div class="fb-follow" data-href="https://www.facebook.com/fondae/" data-layout="standard" data-size="small" data-show-faces="true"></div>

                            <div style="padding-top:3px"><a href="http://instagram.com/fondaedotcom"><img src="http://fondae.com/fondae1/img/instagram.png" style="height: 23px" /></a></div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="footer-form wow fadeIn" data-wow-duration="2s" data-wow-delay="0.4s">
                            <div class="top-head">
                                <h1>Contact Us</h1>
                            </div>
                            <div class="form-form">
                                <div class="expMessage"></div>
                                <form id="contactus-form">
                                    <label for="name">Name:</label>
                                    <input type="text" name="formInput[name]" id="name" class="form-control" required>
                                    <label for="email">Email:</label>
                                    <input type="email" name="formInput[email]" id="email" class="form-control" required>
                                    <label for="message">Massage:</label>
                                    <textarea name="formInput[message]" id="message" class="form-control" rows="4"  required></textarea>
                                    <div class="form-btn">
                                        <button type="submit" class="btn btn-default hvr-shutter-out-horizontal">Submit</button>
                                    </div>
                                    <input type="hidden" name="action" value="submitform">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container " >
                    <div class="col-md-12" style=" border-top: thick solid #e8ae00;"></div>
                    <div class="col-sm-2 ">
                        <div style="padding-top: 5px;font: bold;; text-align: left">
                            <a href="http://fondae.com/fondae1/term-of-use">Terms of Use</a>
                        </div>
                    </div>
                    <div class="col-sm-2 ">

                        <div style="padding-top: 5px;font: bold;; text-align: left">
                            <a href="http://fondae.com/fondae1/privacy-policy">Privacy Policy</a>
                        </div>
                    </div>
                    <div class="col-sm-2 ">
                        <div style="padding-top: 5px;font: bold;; text-align: left">
                            <a href="http://fondae.com/fondae1/cookie-policy">Cookie Policy</a>
                        </div>
                    </div>

                    <div class="col-sm-3">&nbsp;</div>
                    <div class="col-sm-3 social_icon text-right">
                        <div class="icon">
                            <a href="https://www.facebook.com/fondae" target="_blank"><i class="fa fa-facebook"></i></a>
                        </div>
                        <div class="icon">
                            <a href="https://twitter.com/fondaedotcom" target="_blank"><i class="fa fa-twitter"></i></a>
                        </div>
                        <div class="icon">
                            <a href="https://www.instagram.com/fondaedotcom/" target="_blank"><i class="fa fa-instagram"></i></a>
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

    <script src="http://fondae.com/fondae1/frontend/js/jquery.prettyPhoto.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/frontend/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/frontend/js/jquery.appear.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/frontend/js/wow.min.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/frontend/js/owl.carousel.min.js" type="text/javascript"></script>
    <script src="http://fondae.com/fondae1/frontend/js/jquery.validate.js"></script>
    <script src="http://fondae.com/fondae1/frontend/js/custom.js" type="text/javascript"></script>
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



</footer>
<!-- FOOTER-->
<!-- JS-->
<!-- JS-->
</body>
</html>