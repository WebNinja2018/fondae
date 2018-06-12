@extends('adminarea.home')
@section('content')

<?php $userID = Session::get('admin_user'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#frm_changepassword_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
				oldpassword:{
					message: 'Please Insert Your Old Password',
					validators: 
						{
							notEmpty:{message: 'Please Insert Your Old Password'},
							remote: {
										type: 'POST',
										url: "{{ url('/') }}/adminarea/changepassword/checkpassword",
										message: 'Please enter correct old password.',
										delay: 1000
							}
							
						}
				},
				newpassword: 
				{
					message: 'Please Insert Your New password Password',
					validators: 
						{
							notEmpty:{message: 'Please Insert Your New password Password'},
							
						}
				},
				confirmpassword: 
				{
					message: 'Please Insert Your Confirm password Password',
					validators: 
						{
							notEmpty:{message: 'Please Insert Your Confirm password Password'},
							identical: {field: 'newpassword',message: 'The password and its confirm are not the same'}
						}
				}
			}
    });
});

function fun_back()
{
	var frmobj=window.document.frm_changepassword_addedit;
	frmobj.action="{{ url('/') }}/adminarea/home";
	frmobj.submit();
}	
</script>

<ol class="breadcrumb">
    <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li  class="active">Change Password</li>
</ol>


@include('adminarea.include.message')
<form name="frm_changepassword_addedit" id="frm_changepassword_addedit"  action="{{ url('/') }}/adminarea/changepassword/change_password" method="post" class="form-horizontal" enctype="multipart/form-data" >
    <section class="content-header top_header_content">
        <div class="box">
            <div class="property_add">
                <!-- strat box header-->
                <div class="box-title with-border">
                    <h2>Change Password </h2>
                </div>
             <!-- end box -header -->
                <!-- strat box-body area-->
                    <!-- start general & seo tab-->
                     <div class="tab-content">
                         <div class="active tab-pane">
                            <div class="addunit_forms">
                                <div class="box-body">
                                     <div class="form-group">
                                          <label for="question" class="col-sm-2 control-label">Old Password *</label>
                                          <div class="col-md-4">
                                            <input type="password" class="form-control" name="oldpassword" maxlength="100" id="oldpassword" value="" placeholder="Old Password">
                                          </div>
                                     </div>
                                     <div class="form-group">
                                          <label for="question" class="col-sm-2 control-label">New Password *</label>
                                          <div class="col-md-4">
                                            <input type="password" class="form-control" name="newpassword" maxlength="100" id="newpassword" value="" placeholder="New Password">
                                          </div>
                                     </div>
                                     <div class="form-group">
                                          <label for="question" class="col-sm-2 control-label">Confirm Password *</label>
                                          <div class="col-md-4">
                                            <input type="password" class="form-control" name="confirmpassword" maxlength="100" id="confirmpassword" value="" placeholder="Confirm Password">
                                          </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
                    <!-- end general & seo tab-->
                <!-- end box-body area-->
             </div>
            <!-- strat box footer area-->
            <div class="box-footer">
                <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                     <div class="col-xs-12 col-md-12 col-sm-12">
                        <!--<button class="btn btn-warning waves-effect waves-light">Submit</button>-->
                        <input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Submit">
                        <button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back()">Back</button>
                     </div>
                </div>
              </div>
            <!-- end box-footer area-->
        </div>
        </div>
    </section>
</form>
                    
@endsection