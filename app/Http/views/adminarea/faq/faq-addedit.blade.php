@extends('adminarea.home')
@section('content')
@include('adminarea.faq.faq-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#answer').redactor({
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

<?php use App\Http\Models\Faq;
$faqID=Input::get('faqID')?Input::get('faqID'):'0';
if($faqID==0){
	$faqID=old('faqID')?old('faqID'):'';	
}
$question=old('question')?old('question'):'';
$answer=old('answer')?old('answer'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;

$srach_question=Input::get('srach_question')?Input::get('srach_question'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($faqID != NULL && $faqID >0)
{
	if(isset($getsinglefaq))
	{
		$question=$getsinglefaq->question;
		$answer=$getsinglefaq->answer;
		$displayOrder=$getsinglefaq->displayOrder;
		$isActive=$getsinglefaq->isActive;
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/faq">Faq Management</a></li>
        <li class="active">@if($faqID != NULL && $faqID >0) Edit @else Add @endif FAQ </a></li>
    </ol>
     @include('adminarea.include.message')
    <form name="frm_faq_addedit" id="frm_faq_addedit"  action="{{ url('/') }}/adminarea/faq/savefaq" method="post" class="form-horizontal" >
        <input type="hidden" class="form-control" name="faqID" id="faqID" value="{{ $faqID }}">
        <input type="hidden" name="srach_question" id="srach_question" value="{{ $srach_question }}" >
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
                        <h2>@if($faqID != NULL && $faqID >0) Edit @else Add @endif FAQ</h2>
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
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">FAQ Category <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-10 col-md-10 col-xs-10">
                                                    <?php 
                                                        if(isset($qGetCheckedCategory))
                                                         {
                                                             $array_qGetCheckedCategory='';
                                                             foreach($qGetCheckedCategory as $qGetCheckedCategory)
                                                             {
                                                                $array_qGetCheckedCategory[] = $qGetCheckedCategory->categoryID;
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
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">FAQ Question <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="question" maxlength="200" id="question" value="{{ $question }}" placeholder="FAQ Question">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Answer <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <textarea id="answer" name="answer" class="form-control">{{ $answer }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <input type="text" class="form-control" name="displayOrder" id="displayOrder" maxlength="4" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
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
       </section>
       <!-- end add pages--> 
    </form>
@endsection
