<!DOCTYPE html>
<html>
    <head> 
		 @include('adminarea.include.head') {{-- Load Head --}}
    </head>
	<body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
            	 @include('adminarea.include.header') {{-- Load Header --}}
            </header>
			<?php use Illuminate\Support\Facades\Redirect;
				  use Symfony\Component\HttpFoundation\Session\Session1;
			if(!Session::get('admin_user'))
			{
				return Redirect::away(url('/adminarea/login'))->send();
			}
			?>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            	@include('adminarea.include.sidebar') {{-- Load Sidebar --}}
            <!-- /.sidebar -->
            </aside>
           
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            	<div class="col-sm-12 col-md-12 col-xs-12 main_content_area">
                	<div class="row">
            			@yield('content')
                    </div>
                </div>
            </div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
                @include('adminarea.include.footer') {{-- Load Footer --}}
			</footer>
          	<!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                @include('adminarea.include.right-sidebar') {{-- Load Right-sidebar --}}
            </aside>
          	<!-- /.control-sidebar -->
          	<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
          	<div class="control-sidebar-bg"></div>
        </div>
		<!-- ./wrapper -->
    </body>
</html>