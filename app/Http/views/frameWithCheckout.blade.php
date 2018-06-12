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
				
				<div class="section section-padding list-categories">
                    <div class="container">
                        <div class="course-syllabus">
                            <div class="check_out">
                                <div class="row">
									 <!-- start ckeck_out left area-->
                                     @if($qGetPagesResult[0]->pageContentType==1 )
                                        <div class="inner_only_content">
                                        {!! $qGetPagesResult[0]->pageLongDescription !!} {{-- Coding For Page Type Content.--}}
                                        </div>
                                     @endif
                                        
                                     @if($qGetPagesResult[0]->pageContentType==3)
                                            {!! $qGetPagesResult[0]->pageLongDescription !!} {{-- Coding For Page Type Content.--}}
                                     @endif
         
                                     @if($qGetPagesResult[0]->pageContentType==2 || $qGetPagesResult[0]->pageContentType==3)
                                            @include('dynamic.'.$filename)
                                     @endif
									 <!-- end ckeck_out left area-->
                                     <!-- start check_out right area-->
                                     <div class="col-sm-5 col-md-4 col-xs-12 col-lg-4 pull-right">
                                     		@include('include.cart-rightside')  {{-- Include cart-rightside. --}}
                                     </div>
                                     <!-- end check_out right area-->
								</div>
							</div>
						</div>
					</div>
                </div>  

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