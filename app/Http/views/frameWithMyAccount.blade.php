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
				
				<div class="section">
					<div class="container">
						<div class="section-padding courses">
							<div class="col-md-4 col-sm-4 col-xs-12 myaccount_inner">
                                <div class="col-md-12">
                                    <div class="method-item">
                                        <ul>
                                            <li @if($filename =='myprofile')class="active"@endif><a href="{{url('/myprofile')}}" >My Profile <i class="fa fa-user" aria-hidden="true"></i></a></li>
                                            <li @if($filename =='orderhistory' || $filename =='orderdetail')class="active"@endif><a href="{{url('/orderhistory')}}" >Donation History <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                                            <?php /*?><li @if($filename =='billinginfo')class="active"@endif><a href="{{url('/billinginfo')}}" >Billing Information <i class="fa fa-money" aria-hidden="true"></i></a></li>
                                            <li @if($filename =='shippinginfo')class="active"@endif><a href="{{url('/shippinginfo')}}" >Shipping Information <i class="fa fa-truck" aria-hidden="true"></i></a></li><?php */?>
                                            <li @if($filename =='change-password')class="active"@endif><a href="{{url('/change-password')}}" >Change Password <i class="fa fa-lock" aria-hidden="true"></i></a></li>
											<li><a href="{{url('/signup/logout')}}" >Sign Out <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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