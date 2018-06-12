<div class="section background-opacity page-title set-height-top">
    <div class="container">
        <div class="page-title-wrapper">
            <!--.page-title-content-->
            <h1 class="captions">{{ strtolower($qGetPagesResult[0]->pageName) }}</h1>
            <ol class="breadcrumb">
				<?php /*?>Leval 1 [START]<?php */?>
                <li><a href="{{url('/')}}">Home</a></li>

				<?php /*?>Leval 2 [START]<?php */?>
				@if($filename =='conference')
					<li><a href="{{url('/audio-conference')}}">Audio Conference</a></li>
				@elseif($filename =='staff_details')
					<li><a href="{{url('/staff')}}">Staff</a></li>
				@elseif($filename =='myprofile' || $filename =='orderhistory'|| $filename =='orderdetail'|| $filename =='billinginfo'|| $filename =='shippinginfo'|| $filename =='change-password')
					<li><a href="{{url('/dashboard')}}">My Account</a></li>
				@endif

				<?php /*?>Leval 3 [START]<?php */?>
				@if($filename =='orderdetail')
					<li><a href="{{url('/orderhistory')}}">Donation History</a></li>
				@endif

				<?php /*?>Leval 4 [START]<?php */?>
                <li class="active">{{ strtolower($qGetPagesResult[0]->pageName) }}</li>
            </ol>
        </div>
    </div>
</div>