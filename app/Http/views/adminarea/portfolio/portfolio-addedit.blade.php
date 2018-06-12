@extends('adminarea.home')
@section('content')
@include('adminarea.portfolio.portfolio-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#body_content').redactor({
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
<script type="application/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

<?php use App\Http\Models\Portfolio;
$portfolioID=Input::get('portfolioID')?Input::get('portfolioID'):'0';
if($portfolioID==0){
	$portfolioID=old('portfolioID')?old('portfolioID'):'';	
}
$portfolioTitle=old('portfolioTitle')?old('portfolioTitle'):'';
$categoryID=old('categoryID')?old('categoryID'):'';
$body=old('body')?old('body'):'';
$imgFileName_portfolio=old('imgFileName_portfolio')?old('imgFileName_portfolio'):'';
$featured=old('featured')?old('featured'):0;
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;

$pageTitle=old('pageTitle')?old('pageTitle'):'';
$description=old('description')?old('description'):'';
$metaKeyword=old('metaKeyword')?old('metaKeyword'):'';

$srach_portfolioTitle=Input::get('srach_portfolioTitle')?Input::get('srach_portfolioTitle'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($portfolioID != NULL && $portfolioID >0)
{
	if(isset($getsingleportfolio))
	{
		$portfolioTitle=$getsingleportfolio->portfolioTitle;
		$categoryID=$getsingleportfolio->categoryID;
		$body=$getsingleportfolio->body;
		$imgFileName_portfolio=$getsingleportfolio->imgFileName_portfolio;
		$featured=$getsingleportfolio->featured;
		$displayOrder=$getsingleportfolio->displayOrder;
		$isActive=$getsingleportfolio->isActive;
		
		$pageTitle=$getsingleportfolio->pageTitle;
		$description=$getsingleportfolio->description;
		$metaKeyword=$getsingleportfolio->metaKeyword;
		
	}
}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/portfolio">Portfolio Management</a></li>
        <li class="active">@if($portfolioID != NULL && $portfolioID >0) Edit @else Add @endif Portfolio </a></li>
    </ol>
    <section class="content-header top_header_content">
        <div class="nav-tabs-custom">
             @include('adminarea.include.message')
             <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#general_tab" role="tab" data-toggle="tab">General Tab</a></li>
                <?php if($portfolioID != 0){ ?>
                <li><a href="#meta_tab" role="tab" data-toggle="tab">Meta Information</a></li>
                <li><a href="#image_tab" role="tab" data-toggle="tab">Image</a></li>
                <?php } ?>
            </ul>
       </div>
        <div class="tab-content">
        <!---general information[start]--->
            <div class="tab-pane active" id="general_tab">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="row">
                        <form name="frm_portfolio_addedit" id="frm_portfolio_addedit"  action="{{ url('/') }}/adminarea/portfolio/saveportfolio" method="post" class="form-horizontal" enctype="multipart/form-data" >
                        <input type="hidden" class="form-control" name="portfolioID" id="portfolioID" value="{{ $portfolioID}}">
                        <input type="hidden" class="form-control" name="itemID" id="itemID" value="{{ $portfolioID}}">
                        <input type="hidden" name="imagesTypeID" id="imagesTypeID" value="{{ @$imagesTypeID}}" />
                        <input type="hidden" name="srach_portfolioTitle" id="srach_portfolioTitle" value="{{ $srach_portfolioTitle}}" >
                        <input type="hidden" name="startDate" id="startDate" value="{{ $startDate}}" >
                        <input type="hidden" name="endDate" id="endDate" value="{{ $endDate}}" >
                        <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status}}" >
                        <input type="hidden" name="imgFileName_portfolio_old" id="imgFileName_portfolio_old" value="{{ $imgFileName_portfolio}}" >
                        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                        <!--start add user -->
                            <div class="box">
                                <div class="property_add">
                                    <!-- strat box header-->
                                    <div class="box-title with-border">
                                        <h2>@if($portfolioID != NULL && $portfolioID >0) Edit @else Add @endif Portfolio</h2>
                                    </div>
                                    <!-- end box -header -->
                                    <!-- strat box-body area-->
                                        <!-- start general & seo tab-->
                                         <div class="tab-content">
                                             <div class="active tab-pane">
                                                <div class="addunit_forms">
                                                    <div class="box-body">
                                                       <div class="form-group-main">
                                                           <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Portfolio Category <span class="mandatory_field">*</span></label>
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
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Portfolio Title <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="portfolioTitle" maxlength="100" id="portfolioTitle" value="{{ $portfolioTitle}}" placeholder="Enter Portfolio Title">
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Body</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea id="body_content" name="body">{{ $body}}</textarea>
                                                                </div>
                                                            </div>
                                                              
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Portfolio Image <span class="mandatory_field">*</span></label>
                                                                <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input class="form-control" name="imgFileName_portfolio" maxlength="200" id="imgFileName_portfolio" type="file" value="" />
                                                                    <input type="hidden" name="portfolioImage_old" value="{{ $imgFileName_portfolio}}" />
                                                                     @if(strlen($imgFileName_portfolio)>0)
                                                                        <span id="image"><a href="javascript:fun_remove_thumb({{ $portfolioID }},'{{ $imgFileName_portfolio }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                                            <img src="{{ url('/') }}/upload/portfolio/{{ $imgFileName_portfolio }}" height="180" width="180" />
                                                                        </span>
                                                                     @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Featured</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <label class="radio-inline">
                                                                        <input type="radio" value="1"  <?php if($featured==1){ echo "checked='checked'";} ?> name="featured">&nbsp;Yes
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" value="0"  <?php if($featured==0){ echo "checked='checked'";} ?> name="featured">&nbsp;No
                                                                    </label>
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
                                            <button class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back()">Back</button>
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
        @if($portfolioID != 0)
        <!---meta information[start]--->
            <div class="tab-pane fade" id="meta_tab">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <form name="frm_portfolio_meta" id="frm_portfolio_meta"  action="{{ url('/') }}/adminarea/portfolio/saveMetaKeyword" method="post" class="form-horizontal" enctype="multipart/form-data" >
                            <input type="hidden" class="form-control" name="portfolioID" id="portfolioID" value="{{ $portfolioID}}">
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                            <!--start add user -->
                                <div class="box">
                                    <div class="property_add">
                                        <!-- strat box-body area-->
                                            <!-- start general & seo tab-->
                                             <div class="tab-content">
                                                 <div class="active tab-pane">
                                                    <div class="addunit_forms">
                                                        <div class="box-body">
                                                           <div class="form-group">
                                                           
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Title <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="pageTitle" id="pageTitle" maxlength="70" placeholder="Enter Portfolio Title" value="{{ $pageTitle }}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Description</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea rows="3" class="form-control" placeholder="Description" maxlength="300"  name="description" id="description">{{ $description }}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Meta Keywords</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea rows="3" class="form-control" placeholder="Meta Keywords" maxlength="300"  name="metaKeyword" id="metaKeyword">{{ $metaKeyword }}</textarea>
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
                           <!-- end add pages--> 
                        </form>
                      </div>
                 </div>
            </div>
        <!---meta information[end]--->
        <!---Image Tab[Start]--->
            <div class="tab-pane fade" id="image_tab">
            <?php $data['itemID'] = $portfolioID;
                  $data['imagesTypeID'] = 3;
                  //view('adminarea.images.images',$data);
                  //echo View::make('adminarea.images.images', $data);
                  echo view('adminarea.images.images',$data)->render(); 
            ?>
            </div>      
        <!---Image Tab[end]--->
        @endif
        </div>
    </section>    
@endsection
