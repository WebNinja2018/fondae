@extends('adminarea.home')
@section('content')
@include('adminarea.customer.customer-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#bio').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<?php use App\Http\Models\Customer;
$customerID=Input::get('customerID')?Input::get('customerID'):'0';
if($customerID==0){
	$customerID=old('customerID')?old('customerID'):'';	
}
$roleID=old('roleID')?old('roleID'):'';
$firstName=old('firstName')?old('firstName'):'';
$lastName=old('lastName')?old('lastName'):'';
$email=old('email')?old('email'):'';
$password=old('password')?old('password'):'';
$isActive=old('isActive')?old('isActive'):1;
$facebookConnect=old('facebookConnect')?old('facebookConnect'):'';
$location=old('location')?old('location'):'';
$bio=old('bio')?old('bio'):'';
$imgName=old('imgName')?old('imgName'):'';

$srach_firstName=Input::get('srach_firstName')?Input::get('srach_firstName'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($customerID != NULL && $customerID >0)
{
	if(isset($getsingleCustomers))
	{
		$roleID=$getsingleCustomers->roleID;
		$firstName=$getsingleCustomers->firstName;
		$lastName=$getsingleCustomers->lastName;
		$email=$getsingleCustomers->email;
		$password=$getsingleCustomers->password;
		$isActive=$getsingleCustomers->isActive;
		$facebookConnect=$getsingleCustomers->facebookConnect;
		$location=$getsingleCustomers->location;
		$bio=$getsingleCustomers->bio;
		$imgName=$getsingleCustomers->imgName;
	}
}

?>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        @if(session()->get('admin_role')==1)
        <li><a href="{{ url('/') }}/adminarea/customer">Customer Management</a></li>
        @endif
        <li class="active">@if($customerID != NULL && $customerID >0) Edit @else Add @endif Customer </a></li>
    </ol>
    @include('adminarea.include.message')
    <form name="frm_customer_addedit" id="frm_customer_addedit"  action="{{ url('/') }}/adminarea/customer/savecustomer" method="post" class="form-horizontal"  enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="customerID" id="customerID" value="{{ $customerID }}">
        <input type="hidden" name="pageno" value="{{ $pageno }}" />
        <input type="hidden" name="srach_firstName" id="srach_firstName" value="{{ $srach_firstName }}" >
        <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status }}" >
        <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}" >
        <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}" >
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
        <!--start add customer -->
        <section class="content-header top_header_content">
        	<div class="box">
                <div class="property_add">
                    <!-- strat box header-->
                    <div class="box-title with-border">
                        <h2>@if($customerID != NULL && $customerID >0) Edit @else Add @endif Customer </h2>
                    </div>
                 <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       @if(session()->get('admin_role')==1)
                                       <div class="form-group">
                                            <input type="hidden"  name="propertyUniqueID" id="propertyUniqueID" maxlength="50" value="">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Role Name</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <select name="roleID" class="form-control">
                                                    <option value="">= = =Select Role= = =</option>
                                                    @foreach($getRole as $displayRole)
                                                        <option value="{{ $displayRole->roleID }}" @if($displayRole->roleID == $roleID)  selected="selected" @endif>{{ $displayRole->name }}</option>
                                                    @endforeach
                                              </select>
                                            </div>
                                        </div>
                                        @else
                                        	<input type="hidden"  name="propertyUniqueID" id="propertyUniqueID" maxlength="50" value="">
                                            <input type="hidden"  name="roleID" id="roleID" maxlength="50" value="{{ $roleID }}">
                                        @endif
                                        <div class="form-group">
                                        	<label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">First Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input type="text" class="form-control" name="firstName" id="firstName" maxlength="100" value="{{ $firstName }}" placeholder="First Name">
                                        	</div>
                                        </div>
                                        <div class="form-group">
                                           <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Last Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="lastName" id="lastName" maxlength="100" value="{{ $lastName }}" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Email <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                @if($customerID >0 && $customerID == 1)
                                                 <input type="hidden" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email">
                                                 <input type="text" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email" disabled="disabled">
                                                 @else
                                                  <input type="text" class="form-control" name="email" id="email" maxlength="100" value="{{$email}}" placeholder="Email">
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image </label>
                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input class="form-control" name="imgName" maxlength="200" id="imgName" type="file" value="" />
                                          		<input type="hidden" name="imgName_old" value="{{ $imgName}}" />
												 @if(file_exists(public_path().'/upload/customer/'.$imgName) && strlen($imgName)>0 )
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $customerID }},'{{ $imgName }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                        <img src="{{ url('/') }}/upload/customer/{{ $imgName }}" height="180" width="180" />
                                                    </span>
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Facebook Connect </label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="facebookConnect" id="facebookConnect" maxlength="100" value="{{ $facebookConnect }}" placeholder="Facebook Connect">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Your Location </label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="location" id="location" maxlength="100" value="{{ $location }}" placeholder="Your Location">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Biography</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea id="bio" name="bio"><?php echo $bio;?></textarea>
											</div>
                                        </div>
                                        @if($customerID == 0)
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Password <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="password" class="form-control" name="password" id="password" maxlength="100" placeholder="Password" value="{{ $password }}">
                                            </div>
                                        </div>
                                        @endif
                                        <input type="hidden" class="form-control" name="old_password" id="old_password" maxlength="100" value="{{ $password }}">
                                        <div class="form-group">
                                             <div class="col-sm-offset-2 col-sm-10">
                                             <div class="col-sm-6 col-md-6 col-xs-9">
                                               <label class="check_btn">
                                                  <input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1 || !$customerID) checked='checked' @endif name="isActive"> IsActive?
                                                </label>
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
       <!-- end add pages--> 
    </form>
@endsection