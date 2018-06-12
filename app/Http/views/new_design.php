<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>

<body data-spy="scroll" data-target="#fixed-collapse-navbar">
<div id="loader-container">
    <div class='loader'></div>
</div>

<!--Header-->
<section id="top_header">    
    @include('include.header')
    <div id="navigation" data-spy="affix" data-offset-top="98">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                  <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fixed-collapse-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <!-- <a class="navbar-brand" href="#">Brand</a> -->
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    @include('include.topmenu')
                  </div><!-- /.container-fluid -->
                </nav>
            </div>
        </div>
    </div>
</section>
<!--Top Banner-->

@include('include.slider')

<div id="project-tab">
	@include('include.home-nearproject')
</div>
<!-- Help Section Carousel -->
<div id="help">
    @include('include.home-featuredproject')
</div>
<div>
    <div class="container">
        <div class="row">
            <div class="main text-left">
                <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">Blogs</h3>
            </div>
            <div class="help_base">
                <div class="col-sm-5 testimonial-image">
                    <img src="{{asset('img/coming-soon.jpg')}}" alt="">
                </div>
                <div class="col-sm-7 testimonial-info">
                    <h4>Read newest posts from Fondae Blog</h4>
                    <h5>By <b>Fondae Team</b></h5> 
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec libero nulla. Suspendisse malesuada imperdiet mauris a luctus. Cras molestie tincidunt turpis et posuere. Vivamus varius fermentum ornare.</p>
                    <p class="header_bottom"><a href="#">Read More</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div>
    <div class="container">
        <div class="row">
            <div class="main text-center">
                <a href="{{url('/faq')}}">
                    <img src="{{asset('img/need_tips.png')}}" alt="">
                </a>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div id="popular-project">
 	@include('include.home-popularproject')
</div>

@include('include.footer')
@include('include.footer-js')
</body>
</html>