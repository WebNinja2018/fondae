<div class="collapse navbar-collapse" id="fixed-collapse-navbar">
    <ul class="nav navbar-nav">
        <li class="{{ Request::path() == 'explore' ? 'active' : '' }}">
             <a href="{{url('/explore')}}">Explore</a>

        </li>
        <li class="{{ Request::path() == 'about' ? 'active' : '' }}">
            <a href="{{url('/about')}}">How It Works</a>
        </li>  
        <?php if(Session::has('customerID')){?>
       <?php /*?> <li class="{{ Request::path() == '/' ? 'active' : '' }}">
            <a href="{{url('/')}}">Inbox</a>
        </li><?php */?>
        <li class="{{ Request::path() == 'dashboard' ? 'active' : '' }}">
            <a href="{{url('/adminarea')}}">Dashboard</a>
        </li>
        <li>
            <a href="{{url('/signup/logout')}}">Logout</a>
        </li> 
        
           
        <?php }else{ ?>
        <li class="{{ Request::path() == 'Login' ? 'active' : '' }}">
            <a href="{{url('/login-registration')}}">Login/Signup</a>

            <!--a href="{{url('/login-registration')}}">Login/Signup</a-->
        </li>              
        <?php } ?>
    </ul>                     
</div><!-- /.navbar-collapse -->

<!-- Trigger/Open The Modal -->
