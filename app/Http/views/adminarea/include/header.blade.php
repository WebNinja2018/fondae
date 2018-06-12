<!-- Logo -->
    <a href="{{ url('/') }}/adminarea" class="logo">
      <!-- mini logo for sidebar mini 50x60 pixels -->
      <span class="logo-mini"><img src="{!! url('/frontend/images/Charity-logo_03.png') !!}" alt="cahrity LOGO" height="20px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>&nbsp;Fondae</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
		<!--
		<a href="#" class="ion ion-drag" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="sr-only">Toggle navigation</span>
			<span class="sr-only">Toggle navigation</span>
		</a> -->
		<div class="collapse_menubtn">
			<a href="#" data-toggle="offcanvas" role="button">
				 <i class="fa fa-bars" aria-hidden="true"></i>
			</a>
        </div>
		
		<?php /*?><div class="collapse navbar-collapse header_topmenu">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> News <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">News</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Link <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Link Category</a></li>
						<li><a href="#">Link</a></li>
					</ul>
				</li>
				<li>
					<a href="#"> services </a>
				</li>
				<li>
					<a href="#"> Slideshow </a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Faq's <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">FAQ Category</a></li>
						<li><a href="#">FAQ</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Media <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="#"> Staff </a>
						</li>
						<li>
							<a href="#"> Testimonials </a>
						</li>
						<li>
							<a href="#"> Gallery </a>
						</li>
						<li>
							<a href="#"> Video </a>
						</li>
					</ul>
				</li>
				
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Portfolio <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Portfolio Category</a></li>
						<li><a href="#">Portfolio</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Reports <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Newsletter</a></li>
					<li><a href="#">Request Services Report</a></li>
					<li><a href="#">Applyjob List</a></li>
				</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Admin Management <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">User Management</a></li>
						<li><a href="#">Role Management</a></li>
						<li><a href="#">Menu Manager</a></li>
						<li><a href="#">Common Messages</a></li>
						<li><a href="#">Global Setting</a></li>
						<li><a href="#">Email Setting</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> Job <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Job Category</a></li>
						<li><a href="#">Job Posting</a></li>
					</ul>
				</li>
			</ul>
		</div><?php */?>

		<div class="collapse navbar-collapse header_topmenu">
			<ul class="nav navbar-nav">
				<?php
					  use App\Http\Models\Adminmenu;
					  $adminmenu= new Adminmenu;
					  $TopMenu=$adminmenu->getAllParent(0,1,session()->get('admin_role'));
				?>
				@foreach( $TopMenu['data'] as $menu )
				<?php $subMenu=$adminmenu->getAllParent($menu->menuID,1,session()->get('admin_role'));?>
				<li class="dropdown">
					<a href="@if( $menu->menuLink=='javascript:;' )javascript:; class="dropdown-toggle" data-toggle="dropdown" @else {{url('/')}}/adminarea/{{$menu->menuLink}} @endif"  > {{$menu->menuName}}</a>
					@if( $subMenu['rows']>0 )
					<ul class="dropdown-menu" role="menu">
						@foreach( $subMenu['data'] as $submenu )
						<li><a href="{{url('/')}}/adminarea/{{$submenu->menuLink}}">{{$submenu->menuName}}</a></li>
						@endforeach
					</ul>
					@endif
				</li>
				@endforeach	
			</ul>
		</div>
		<div class="my_accountarea">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
				   <li class="dropdown user user_menu_profile">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  <i class="fa fa-user"></i>
					</a>
					<ul class="dropdown-menu">
					 <?php /*?> <li><a href=""><i class="fa fa-picture-o"></i> My profile</a></li>
					  <li class="divider"></li>
					  <li><a href="javascript:alert('Coming Soon !');"><i class="fa fa-cog"></i> Admin Settings</a></li>
					  <li class="divider"></li><?php */?>
					  <li>
						<ul class="dropdown-menu">
							<li><a href=""><i class="fa fa-picture-o"></i> My profile</a></li>
							<li class="divider"></li>
						</ul>
					  </li>
					  
					  <li><a href="{{ url('/') }}/adminarea/changepassword"><i class="fa fa-pencil-square-o"></i> Change Password</a></li>
					  <li class="divider"></li>
					  <li><a href="{{ url('/') }}" target="_blank"><i class="fa fa-picture-o"></i>Main Site</a></li>
					  <li class="divider"></li>
					  <li><a href="{{ url('/') }}/adminarea/logout"><i class="fa fa-sign-in"></i>Sign out</a></li>
                      <li class="divider"></li>
					  <li><a href="javascript:fun_edit();"><i class="fa fa-user-o"></i>My Profile</a></li>
					  
					</ul>
				  </li>
				  
				  <?php /*?><li class="user_menu_profile">
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				  </li><?php */?>
				</ul>
			</div>
		</div>
    </nav>
    
    <form role="form" name="frm_user_addedit_header" id="frm_user_addedit_header" method="post" action="{{ url('/') }}/adminarea/customer/addeditcustomer">
        <input type="hidden" class="form-control" name="customerID" id="customerID" value="{{ session()->get('admin_user') }}">
        <input type="hidden" name="redirects_to" value="{{ url('/') }}/adminarea">
    </form>
    <script>
		function fun_edit()
		{
			var frmobj=window.document.frm_user_addedit_header;
			frmobj.action="{{ url('/') }}/adminarea/customer/addeditcustomer";
			frmobj.submit();
		}
	</script>
    