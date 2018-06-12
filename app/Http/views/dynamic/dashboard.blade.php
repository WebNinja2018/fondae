<?php
use Illuminate\Support\Facades\Custom; 
Custom::checkLogin();  //"Custom Funcation" is in path :vendor/laravel/framework/src/Illuminate/Support/Facades/Custom.php
?>
<div class="myaccount_dashboard">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h2 class="username">Welcome to Your Account {{Session::get('firstName')}} {{Session::get('lastName')}}</h2>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>My Profile</h4>
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="caption">
                        <p>Manage your profile information</p>
                         <a class="btn btn-account video-btn-right pull-right" href="{{url('/myprofile')}}"><span><b>Update Profile</b></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Donation History</h4>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <div class="caption">
                        <p>View and manage your Donation Detail</p>
                         <a class="btn btn-account video-btn-right pull-right" href="{{url('/orderhistory')}}"><span><b>View Donation</b></span></a>
                    </div>
                </div>
            </div>
            <?php /*?><div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Billing Information</h4>
                        <i class="fa fa-money" aria-hidden="true"></i>
                    </div>
                    <div class="caption ">
                        <p>View and manage your Billing Information</p>
                         <a class="btn btn-account video-btn-right pull-right" href="{{url('/billinginfo')}}"><span><b>Billing Detail</b></span></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Shipping Information</h4>
                        <i class="fa fa-truck" aria-hidden="true"></i>
                    </div>
                    <div class="caption">
                        <p>View and manage your shipping information</p>
                         <a class="btn btn-account video-btn-right pull-right"  href="{{url('/shippinginfo')}}"><span><b>Shipping Detail</b></span></a>
                    </div>
                </div>
            </div><?php */?>
            <!--<div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Update Address</h4>
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </div>
                    <div class="caption">
                        <p>View and Update your Address info</p>
                         <a class="btn btn-account video-btn-right pull-right"  href="update_add.html"><span><b>Update Address</b></span></a>
                    </div>
                </div>
            </div>-->
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Change Password</h4>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </div>
                    <div class="caption ">
                        <p>View and change your password</p>
                         <a class="btn btn-account video-btn-right pull-right"  href="{{url('/change-password')}}"><span><b>Update Password</b></span></a>
                    </div>
                </div>
            </div>
        
            <?php /*?><div class="col-xs-6 col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="myaccount_dashboardtitle">
                        <h4>Sign Out</h4>
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </div>
                    <div class="caption ">
                        <p>Signout your account</p>
                         <a class="btn btn-account video-btn-right pull-right"  href="{{url('/signup/logout')}}"><span><b>Sign Out</b></span></a>
                    </div>
                </div>
            </div><?php */?>
         </div>
    </div>
</div>
