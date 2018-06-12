<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 header_bottom logo text-left">
                <div class="col-sm-6 contact_info text-right">
                    <a href="{{ url('/')}}"><img src="{{asset('frontend/images/Charity-logo_03.png')}}" alt="cahrity LOGO"></a>
                </div>
                
            </div>     
            <div class="col-sm-8 header_bottom text-right">
            	
                    <?php /*?><a href="tel:1-223-355-2214"><i class="fa fa-phone"></i>Call us: 1-223-355-2214</a><?php */
                    //href="{{ url('/adminarea/home')}}"
                    ?>


					<a class="fondae_btn hvr-shutter-out-horizontal"   href="{{ url('/adminarea/home')}}">
						Host A Fondae
					</a>
                    <div class="nav-search">
                        <form name="frm_search" id="frm_search" method="post" action="{{ url('/search')}}">
                            <input type="hidden" value="" name="pageFileName">
                            <input type="text" name="srchByKeyword" id="srchByKeyword" value="" placeholder="Search" class="searchbox">
                            <button type="submit" class="searchbutton fa fa-search"></button>
                        </form>
                    </div>
                <div class="col-sm-3 social_icon text-right">
                    <div class="icon">
                        <a href="{{Config::get('config.facebook', 'https://www.facebook.com/fondae/')}}" target="_blank"><i class="fa fa-facebook"></i></a>
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
</div>

<?php /*?><div class="header-topbar">
    <div class="container">
        <div class="topbar-left pull-left">
			@if(strlen(Config::get('config.contactEmail'))>0)
            <div class="email">
                <a href="##">
                    <i class="topbar-icon fa fa-envelope-o"></i>
                    <span>{{Config::get('config.contactEmail', 'cs@onlineaudiotraining.com')}}</span>
                </a>
            </div>
			@endif
			@if(strlen(Config::get('config.contactNumber'))>0)
            <div class="hotline">
                <a href="callto:{{Config::get('config.contact', '+1-800-935-3714')}}">
                    <i class="topbar-icon fa fa-phone"></i>
                    <span>{{Config::get('config.contact', '+1-800-935-3714')}} </span>
                </a>
            </div>
			@endif
        </div>
        <div class="topbar-right pull-right">
            <div class="socials">
                <a href="{{Config::get('config.facebook', 'https://www.facebook.com/Onlineaudiotrainings-1884968415068679/')}}" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="{{Config::get('config.google', 'https://plus.google.com/u/0/110296707592332996196')}}" class="google" target="_blank"><i class="fa fa-google-plus"></i></a>
                <a href="{{Config::get('config.twitter', 'https://www.linkedin.com/company/onlineaudiotraining')}}" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                <a href="{{Config::get('config.linkedin', 'https://twitter.com/OnlineaudioOat')}}" class="pinterest" target="_blank"><i class="fa fa-linkedin"></i></a>
                <a href="{{Config::get('config.youtube', 'https://www.youtube.com/channel/UCDVs7p9EbAUDMp0pS13c7Jg')}}" class="blog" target="_blank"><i class="fa fa-youtube"></i></a>
            </div>
			@if(Session::get('customerID') && Session::get('customerType')!= Config::get('config.guestCustomerType',2))
                <div class="group-sign-in">
                	<a href="{{url('/cart')}}" class="login"><i class="fa fa-shopping-cart" aria-hidden="true"></i> </a>
					<a href="{{url('/dashboard')}}" class="login">My Account</a>
                    <a href="{{url('/signup/logout')}}" class="register">logout</a>
                </div>
			@else
                <div class="group-sign-in">
					<a href="{{url('/cart')}}" class="login"><i class="fa fa-shopping-cart" aria-hidden="true"></i> </a>
                    <a href="{{url('/login-registration')}}" class="login">login</a>
                    <a href="{{url('/login-registration')}}" class="register">register</a>
                </div>
			@endif
        </div>
    </div>
</div><?php */?>