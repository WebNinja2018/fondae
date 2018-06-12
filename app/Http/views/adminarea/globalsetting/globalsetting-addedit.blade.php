@extends('adminarea.home')
@section('content')
@include('adminarea.globalsetting.globalsetting-js')

<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#globalsettingvalue1').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>


<?php use App\Http\Models\Globalsetting;

$globalsettingID=Input::get('globalsettingID')?Input::get('globalsettingID'):'0';

if($globalsettingID==0){
	$globalsettingID=old('globalsettingID')?old('globalsettingID'):'';	
}
$globalsettingname=old('globalsettingname')?old('globalsettingname'):'';
$globalsettingvalue=old('globalsettingvalue')?old('globalsettingvalue'):'';
$isActive=old('isActive')?old('isActive'):1;
$textTypeID=old('textTypeID')?old('textTypeID'):'';
$valuetype=old('valuetype')?old('valuetype'):'';

$srach_name=old('srach_name')?old('srach_name'):'';
$startDate=old('startDate')? date('m/d/Y',strtotime(old('startDate'))):'';
$endDate=old('endDate')? date('m/d/Y',strtotime(old('endDate'))):'';
$srch_status=old('srch_status')?old('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($globalsettingID != NULL && $globalsettingID >0)
{
	if(isset($getsingleglobalsetting))
	{
		$globalsettingID=$getsingleglobalsetting->globalsettingID;
		$globalsettingname=$getsingleglobalsetting->globalsettingname;
		$globalsettingvalue=$getsingleglobalsetting->globalsettingvalue;
		$textTypeID=$getsingleglobalsetting->textTypeID;
		$valuetype=$getsingleglobalsetting->valuetype;
		$isActive=$getsingleglobalsetting->isActive;
		
	}
}
?>

  	<ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/globalsetting">Global Setting Management</a></li>
        <li class="active">@if($globalsettingID != NULL && $globalsettingID >0) Edit @else Add @endif Global Setting </a></li>
    </ol>
    <section class="content-header top_header_content">
    	<div class="nav-tabs-custom">
             @include('adminarea.include.message')
             <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#general_tab" role="tab" data-toggle="tab">General Tab</a></li>
            </ul>
       </div>
		<div class="tab-content">
    <!---general information[start]--->
        <div class="tab-pane active" id="general_tab">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="row">
                    <form name="frm_globalsetting_addedit" id="frm_globalsetting_addedit"  action="{{ url('/') }}/adminarea/globalsetting/saveglobalsetting" method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <input type="hidden" class="form-control" name="globalsettingID" id="globalsettingID" value="{{ $globalsettingID}}">
                    <input type="hidden" name="srach_name" id="srach_name" value="{{ $srach_name}}" >
                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate}}" >
                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate}}" >
                    <input type="hidden" name="srch_status" id="srch_status" value="1" >
                   <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                    <!--start add user -->
                        <div class="box">
                            <div class="property_add">
                                <!-- strat box header-->
                                <div class="box-title with-border">
                                    <h2>@if($globalsettingID != NULL && $globalsettingID >0) Edit @else Add @endif Global Setting</h2>
                                </div>
                                <!-- end box -header -->
                                <!-- strat box-body area-->
                                    <!-- start general & seo tab-->
                                     <div class="tab-content">
                                         <div class="active tab-pane">
                                            <div class="addunit_forms">
                                                <div class="box-body">
                                                   <div class="form-group">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Global Setting Name <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" data-error="First Name is required." name="globalsettingname" id="globalsettingname" maxlength="50" value="<?php echo $globalsettingname;?>" placeholder="Variable Name">
															</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Text Type</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="radio" name="textTypeID" onclick="funMessageType(1)" value="1" <?php if($textTypeID==1){echo "checked='checked'";} ?> /> <span class="label_color">Text Box</span>&nbsp;&nbsp;
                                                                <input type="radio" name="textTypeID" onclick="funMessageType(2)" value="2" <?php if($textTypeID==2){echo "checked='checked'";} ?>/> <span class="label_color">Text Area</span>
                                                                <?php /*?><input type="radio" name="textTypeID" onclick="funMessageType(3)" value="3" <?php if($textTypeID==3){echo "checked='checked'";} ?>/> <span class="label_color">File</span><?php */?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="globalvalue1">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Description <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                          						<input type="text" class="form-control" name="globalsettingTextvalue" id="globalsettingvalue" maxlength="100" placeholder="Description" value="<?php if($textTypeID==1){ echo $globalsettingvalue; } else { } ?>">
                                                            </div>
                                                        </div>

														<div class="form-group" id="globalvalue2">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Description <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                        						<textarea id="globalsettingvalue1" name="globalsettingTextareavalue"><?php if($textTypeID==2){ echo $globalsettingvalue; } else { } ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Select Priority:</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <select name="valuetype[]" class="form-control" multiple="multiple">
                                                                    <option value="high">HIgh</option> 
                                                                    <option value="low">Low</option> 
                                                                    <option value="medium">Medium</option> 
                                                                </select>
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
                   <!-- end add pages--> 
                </form>
                </div>
            </div>
        </div>
    <!---general information[end]---> 
	</div>
   </section>
   <script type="text/javascript">
    	funMessageType({{ $textTypeID }});
   </script> 
@endsection
