@extends('adminarea.home')
@section('content')
@include('adminarea.staff.staff-js')
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#bio_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<script type="application/javascript">

  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php use App\Http\Models\Staff;
$staffID=Input::get('staffID')?Input::get('staffID'):'0';
if($staffID==0){
	$staffID=old('staffID')?old('staffID'):'';	
}

$categoryID=old('categoryID')?old('categoryID'):'0';
$firstname=old('firstname')?old('firstname'):'';
$lastname=old('lastname')?old('lastname'):'';
$position=old('position')?old('position'):'';
$email=old('email')?old('email'):'';
$telephone=old('telephone')?old('telephone'):'';
$telephone_type=old('telephone_type')?old('telephone_type'):'';
$alt_telephone_type=old('alt_telephone_type')?old('alt_telephone_type'):'';
$alt_telephone=old('alt_telephone')?old('alt_telephone'):'';
$bio=old('bio')?old('bio'):'';
$imgFileName_staff=old('imgFileName_staff')?old('imgFileName_staff'):1;
$firstname_public=old('firstname_public')?old('firstname_public'):1;
$lastname_public=old('lastname_public')?old('lastname_public'):1;
$position_public=old('position_public')?old('position_public'):1;
$email_public=old('email_public')?old('email_public'):1;
$telephone_public=old('telephone_public')?old('telephone_public'):1;
$alt_telephone_public=old('alt_telephone_public')?old('alt_telephone_public'):1;

$bio_public=old('bio_public')?old('bio_public'):1;
$image_public=old('image_public')?old('image_public'):1;
$alttag=old('alttag')?old('alttag'):'';
$facebook=old('facebook')?old('facebook'):'';
$google=old('google')?old('google'):'';
$twitter=old('twitter')?old('twitter'):'';

$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($staffID != NULL && $staffID >0)
{
	if(isset($getsinglestaff))
	{
		$categoryID=$getsinglestaff->categoryID;
		$firstname=$getsinglestaff->firstname;
		$lastname=$getsinglestaff->lastname;
		$position=$getsinglestaff->position;
		$email=$getsinglestaff->email;
		$telephone=$getsinglestaff->telephone;
		$telephone_type=$getsinglestaff->telephone_type;
		$alt_telephone_type=$getsinglestaff->alt_telephone_type;
		$alt_telephone=$getsinglestaff->alt_telephone;
		$bio=$getsinglestaff->bio;
		$imgFileName_staff=$getsinglestaff->imgFileName_staff;
		$firstname_public=$getsinglestaff->firstname_public;
		$lastname_public=$getsinglestaff->lastname_public;
		$position_public=$getsinglestaff->position_public;
		$email_public=$getsinglestaff->email_public;
		$telephone_public=$getsinglestaff->telephone_public;
		$alt_telephone_public=$getsinglestaff->alt_telephone_public;
		$bio_public=$getsinglestaff->bio_public;
		$image_public=$getsinglestaff->image_public;
		$alttag=$getsinglestaff->alttag;
		$facebook=$getsinglestaff->facebook;
		$google=$getsinglestaff->google;
		$twitter=$getsinglestaff->twitter;
		$displayOrder=$getsinglestaff->displayOrder;
		$isActive=$getsinglestaff->isActive;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/staff">Staff Management</a></li>
        <li class="active">@if($staffID != NULL && $staffID >0) Edit @else Add @endif Staff </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_staff_addedit" id="frm_staff_addedit"  action="{{ url('/') }}/adminarea/staff/savestaff" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="staffID" id="staffID" value="{{ $staffID }}">
        <input type="hidden" name="srach_name" id="srach_name" value="{{ $srach_name }}" >
        <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status }}" >
        <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}" >
        <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}" >
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
        <!--start add user -->
        <section class="content-header top_header_content">
        	<div class="box">
                <div class="property_add">
                    <!-- strat box header-->
                    <div class="box-title with-border">
                        <h2>@if($staffID != NULL && $staffID >0) Edit @else Add @endif Staff</h2>
                    </div>
                    <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group-main">
                                        <?php /*?><div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Staff Category <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-8 col-md-8 col-xs-9">
                                            	<?php 
													if(isset($qGetCheckedCategory))
													 {
														 $array_qGetCheckedCategory='';
														 foreach($qGetCheckedCategory as $qGetCheckedCategory)
														 {
															$array_qGetCheckedCategory[] = $qGetCheckedCategory->categoryid;
														 }
														$array = array($qGetCheckedCategory);
														
													 }
													 
												 ?>
                                                 @foreach($qGetAllCategory as $GetAllCategory)
                                                 <label class="checkbox-inline">
                                                    <input type="checkbox" name="categoryID[]" value="{{ $GetAllCategory->categoryID }}" 
														@if(count($qGetCheckedCategory)>0)
                                                        	@for($i=0;$i<count($array_qGetCheckedCategory);$i++)
                                                            	@if($array_qGetCheckedCategory[$i]==$GetAllCategory->categoryID)
                                                    				checked="checked"
                                                                @endif
                                                            @endfor
                                                        @endif
                                                     />{{ $GetAllCategory->categoryname }}
                                                  </label>
                                                @endforeach
                                            </div>
                                        </div><?php */?>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">First Name<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="firstname" maxlength="50" id="firstname" value="{{ $firstname }}" placeholder="First Name">
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="firstname_public"  type="radio" value="0" @if($firstname_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="firstname_public"  type="radio" value="1" @if($firstname_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Last Name<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="lastname" maxlength="50" id="lastname" value="{{ $lastname }}" placeholder="Last Name">
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="lastname_public"  type="radio" value="0" @if($lastname_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="lastname_public"  type="radio" value="1" @if($lastname_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Position<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="position" maxlength="50" id="position" value="{{ $position }}" placeholder="Position">
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="position_public"  type="radio" value="0" @if($position_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="position_public"  type="radio" value="1" @if($position_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Phone<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-3 col-md-3 col-xs-6">
                                                <input type="text" class="form-control" name="telephone" maxlength="50" id="telephone" value="{{ $telephone }}" placeholder="Phone">
											</div>
											<div class="col-sm-3 col-md-3 col-xs-6">
                                                <select name="telephone_type" id="telephone_type" class="form-control" size="1">
                                                    <option value="0">- - - Type - - -</option>
                                                    <option value="Work" @if($telephone_type == "Work") selected="selected" @endif >- - - Work - - -</option>
                                                    <option value="Home" @if($telephone_type == "Home") selected="selected" @endif >- - - Home - - -</option>
                                                    <option value="Cell" @if($telephone_type == "Cell") selected="selected" @endif >- - - Cell - - -</option>
                                                    <option value="Other" @if($telephone_type == "Other") selected="selected" @endif >- - - Other - - -</option>
                                                </select>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="telephone_public"  type="radio" value="0" @if($telephone_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="telephone_public"  type="radio" value="1" @if($telephone_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Alt Phone</label>
                                            <div class="col-sm-3 col-md-3 col-xs-6">
                                                <input type="text" class="form-control" name="alt_telephone" maxlength="50" id="alt_telephone" value="{{ $alt_telephone }}" placeholder="Alt Phone">
											</div>
											<div class="col-sm-3 col-md-3 col-xs-6">
                                                <select name="alt_telephone_type" id="alt_telephone_type" class="form-control" size="1">
                                                    <option value="0">- - - Type - - -</option>
                                                    <option value="Work" @if($alt_telephone_type == "Work") selected="selected" @endif >- - - Work - - -</option>
                                                    <option value="Home" @if($alt_telephone_type == "Home") selected="selected" @endif >- - - Home - - -</option>
                                                    <option value="Cell" @if($alt_telephone_type == "Cell") selected="selected" @endif >- - - Cell - - -</option>
                                                    <option value="Other" @if($alt_telephone_type == "Other") selected="selected" @endif >- - - Other - - -</option>
                                                </select>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="alt_telephone_public"  type="radio" value="0" @if($alt_telephone_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="alt_telephone_public"  type="radio" value="1" @if($alt_telephone_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Email<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="email" maxlength="50" id="email" value="{{ $email }}" placeholder="Email">
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="email_public"  type="radio" value="0" @if($email_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="email_public"  type="radio" value="1" @if($email_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Image <span class="mandatory_field">*</span></label>
                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input class="form-control" name="imgFileName_staff" maxlength="200" id="imgFileName_staff" type="file" value="" />
                                          		<input type="hidden" name="imgFileName_staff_old" value="{{ $imgFileName_staff}}" />
												 @if(file_exists(public_path().'/upload/staff/'.$imgFileName_staff) && strlen($imgFileName_staff)>0 )
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $staffID }},'{{ $imgFileName_staff }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                        <img src="{{ url('/') }}/upload/staff/{{ $imgFileName_staff }}" height="180" width="180" />
                                                    </span>
                                                 @endif
                                            </div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="image_public"  type="radio" value="0" @if($image_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="image_public"  type="radio" value="1" @if($image_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Alt Tag for Image</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="alttag" maxlength="50" id="alttag" value="{{ $alttag }}" placeholder="Alt Tag for Image">
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Biography<span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea id="bio_content" name="bio"><?php echo $bio;?></textarea>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-7">
                                                <label>
                                                    <input name="bio_public"  type="radio" value="0" @if($image_public== 0) checked="checked" @endif > Unpublished &nbsp;
                                                </label>
                                                <label>
                                                    <input name="bio_public"  type="radio" value="1" @if($image_public== 1) checked="checked" @endif > published 
                                                </label>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Facebook</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="facebook" maxlength="100" id="facebook" placeholder="Facebook" value="{{ $facebook }}">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Google+</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="google" maxlength="100" id="google" placeholder="Google+" value="{{ $google }}">
                                            </div>
                                        </div>
									    <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Twitter</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="twitter" maxlength="100" id="twitter" placeholder="Twitter" value="{{ $twitter }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right"></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
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
