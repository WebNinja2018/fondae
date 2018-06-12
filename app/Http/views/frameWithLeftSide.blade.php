<!DOCTYPE html>
<!-- saved from url=(0035)# -->
<html lang="en" class="">
<head>
	@include('include.head')
</head>

<body>
<!-- start header area -->
<header>
    @include('include.header')
    @include('include.topmenu')
</header>
<!-- end header area -->

<div id="wrapper-content">
	<!-- PAGE WRAPPER-->
	<div id="page-wrapper">
		<!-- MAIN CONTENT-->
		<div class="main-content">
			<!-- CONTENT-->
			<div class="content">
				 @include('include.breadcrums')  {{-- Include Breadcumbs. --}}
				<!--INTRO EDUGATE-->
				<div class="section intro-edu">
					<div class="container">
						<div class="intro-edu-wrapper">
                            <div class="col-md-3 col-sm-4 col-xs-12 content_left">
                                @include('include.leftside')
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12 content_right">
                             @if($qGetPagesResult[0]->pageContentType==1 || $qGetPagesResult[0]->pageContentType==3)
                                    {!! $qGetPagesResult[0]->pageContent !!} {{-- Coding For Page Type Content.--}}
                             @endif
 
                             @if($qGetPagesResult[0]->pageContentType==2 || $qGetPagesResult[0]->pageContentType==3)
                                    @include('dynamic.'.$filename)
                             @endif
                            </div>
						</div>
					</div>
				</div>
				
				
				
				<!-- SLIDER LOGO-->
				
			</div>
		</div>
	</div>
	<!-- BUTTON BACK TO TOP-->
	<div id="back-top">
		<a href="#top">
			<i class="fa fa-angle-double-up"></i>
		</a>
	</div>
</div>

<!-- FOOTER-->
<footer>
@include('include.footer')
</footer>
<!-- FOOTER-->
<!-- JS-->
@include('include.footer-js')
<!-- JS-->
</body>
</html>

