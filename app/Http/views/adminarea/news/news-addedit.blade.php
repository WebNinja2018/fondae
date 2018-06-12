@extends('adminarea.home')
@section('content')
@include('adminarea.news.news-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#summary_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
	
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

<?php use App\Http\Models\News;
$newsID=Input::get('newsID')?Input::get('newsID'):'0';
if($newsID==0){
	$newsID=old('newsID')?old('newsID'):'';	
}
$newsTitle=old('newsTitle')?old('newsTitle'):'';
$categoryID=old('categoryID')?old('categoryID'):'';
$author=old('author')?old('author'):'';
$newsDate=old('newsDate')?date('m/d/Y',strtotime(old('newsDate'))):'';
$summary=old('summary')?old('summary'):'';
$body=old('body')?old('body'):'';
$imgFileName_news=old('imgFileName_news')?old('imgFileName_news'):'';
$weblink=old('weblink')?old('weblink'):'';
$featured=old('featured')?old('featured'):0;
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$pageTitle=old('pageTitle')?old('pageTitle'):'';
$description=old('description')?old('description'):'';
$metaKeyword=old('metaKeyword')?old('metaKeyword'):'';
$isActive=old('isActive')?old('isActive'):1;


$srach_newsTitle=Input::get('srach_newsTitle')?Input::get('srach_newsTitle'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}

if($newsID != NULL && $newsID >0)
{
	if(isset($getsinglenews))
	{
		$newsTitle=$getsinglenews->newsTitle;
		$categoryID=$getsinglenews->categoryID;
		$author=$getsinglenews->author;
		$newsDate=date('m/d/Y',strtotime($getsinglenews->newsDate));
		$summary=$getsinglenews->summary;
		$body=$getsinglenews->body;
		$imgFileName_news=$getsinglenews->imgFileName_news;
		$newsImage=$getsinglenews->newsImage;
		$weblink=$getsinglenews->weblink;
		$featured=$getsinglenews->featured;
		$displayOrder=$getsinglenews->displayOrder;
		$pageTitle=$getsinglenews->pageTitle;
		$description=$getsinglenews->description;
		$metaKeyword=$getsinglenews->metaKeyword;
		$isActive=$getsinglenews->isActive;
	}
}
?>

<ol class="breadcrumb">
    <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ url('/') }}/adminarea/news">News Management</a></li>
    <li class="active">@if($newsID != NULL && $newsID >0) Edit @else Add @endif News </a></li>
</ol>
<section class="content-header top_header_content">
    <div class="nav-tabs-custom">
         @include('adminarea.include.message')
         <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#general_tab" role="tab" data-toggle="tab">General Tab</a></li>
            <?php if($newsID != 0){ ?>
            <li><a href="#meta_tab" role="tab" data-toggle="tab">Meta Information</a></li>
            <li><a href="#image_tab" role="tab" data-toggle="tab">Image</a></li>
            <li><a href="#file_tab" role="tab" data-toggle="tab">File</a></li>
            <?php } ?>
        </ul>
   </div>
    <div class="tab-content">
        <!---general information[start]--->
        <div class="tab-pane active" id="general_tab">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="row">
                    <form name="frm_news_addedit" id="frm_news_addedit"  action="{{ url('/') }}/adminarea/news/savenews" method="post" class="form-horizontal" enctype="multipart/form-data" >
                    <input type="hidden" class="form-control" name="newsID" id="newsID" value="{{ $newsID}}">
                    <input type="hidden" class="form-control" name="itemID" id="itemID" value="{{ $newsID}}">
                    <input type="hidden" name="imagesTypeID" id="imagesTypeID" value="{{ @$imagesTypeID}}" />
                    <input type="hidden" name="srach_newsTitle" id="srach_newsTitle" value="{{ $srach_newsTitle}}" >
                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate}}" >
                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate}}" >
                    <input type="hidden" name="srch_status" id="srch_status" value="{{ $srch_status}}" >
                    <input type="hidden" name="imgFileName_news_old" id="imgFileName_news_old" value="{{ $imgFileName_news}}" >
                    <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                    <!--start add user -->
                        <div class="box">
                            <div class="property_add">
                                <!-- strat box header-->
                                <div class="box-title with-border">
                                    <h2>@if($newsID != NULL && $newsID >0) Edit @else Add @endif News</h2>
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
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label">News Category <span class="mandatory_field">*</span></label>
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
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">News Title <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" name="newsTitle" maxlength="100" id="newsTitle" value="{{ $newsTitle}}" placeholder="Enter News Title">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Author <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" name="author" maxlength="100" id="author" placeholder="Enter Author Name" value="{{ $author}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">News Date <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                  <div class="input-group">
                                                                    <div id="sandbox-container">
                                                                        <input type="text" name="newsDate" id="newsDate" class="form-control" maxlength="20" placeholder="News Date" value="{{ $newsDate}}">
                                                                    </div>
                                                                      <script type="text/javascript">
                                                                            $('#sandbox-container input').datepicker({
                                                                            format: 'mm/dd/yyyy',
                                                                            keyboardNavigation: false,
                                                                            forceParse: false,
                                                                            endDate: new Date(), 
                                                                            autoclose: true
                                                                            })
                                                                            .on('changeDate', function(e) {
                                                                              // Revalidate the date field
                                                                              $('#frm_news_addedit').data('bootstrapValidator').revalidateField('newsDate');
                                                                            });

                                                                        </script>
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Summary</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <textarea id="summary_content" name="summary">{{ $summary}}</textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Body</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <textarea id="body_content" name="body">{{ $body}}</textarea>
                                                            </div>
                                                        </div>
                                                          
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">News Image <span class="mandatory_field">*</span></label>
                                                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input class="form-control" name="imgFileName_news" maxlength="200" id="imgFileName_news" type="file" value="" />
                                                                <input type="hidden" name="newsImage_old" value="{{ $imgFileName_news}}" />
                                                                 @if(strlen($imgFileName_news)>0)
                                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $newsID }},'{{ $imgFileName_news }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                                        <img src="{{ url('/') }}/upload/news/{{ $imgFileName_news }}" height="180" width="180" />
                                                                    </span>
                                                                 @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Web Link</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" name="weblink" maxlength="200" id="weblink" placeholder="http://" value="{{ $weblink }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Display Order <span class="mandatory_field">*</span></label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Featured</label>
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
                                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left"></label>
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
                                        <button class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_general_tab()">Back</button>
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
        @if($newsID != 0)
        <!---meta information[start]--->
            <div class="tab-pane fade" id="meta_tab">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <form name="frm_news_meta" id="frm_news_meta"  action="{{ url('/') }}/adminarea/news/saveMetaKeyword" method="post" class="form-horizontal" enctype="multipart/form-data" >
                            <input type="hidden" class="form-control" name="newsID" id="newsID" value="{{ $newsID}}">
                            <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                            <!--start add user -->
                                <div class="box">
                                    <div class="property_add">
                                        <!-- strat box-body area-->
                                            <!-- start general & seo tab-->
                                             <div class="tab-content">
                                                 <div class="active tab-pane">
                                                    <div class="addunit_forms">
                                                        <div class="box-body">
                                                           <div class="form-group_main">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Page Title <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="pageTitle" id="pageTitle" maxlength="70" placeholder="Enter News Title" value="{{ $pageTitle }}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Description</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea rows="3" class="form-control" placeholder="Description" maxlength="300"  name="description" id="description">{{ $description }}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Meta Keywords</label>
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
                                                <button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_mata()">Back</button>
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
            <?php $data['itemID'] = $newsID;
                  $data['imagesTypeID'] = 2;
                  //view('adminarea.images.images',$data);
                  //echo View::make('adminarea.images.images', $data);
                  echo view('adminarea.images.images',$data)->render(); 
            ?>
            </div>      
        <!---Image Tab[end]--->
        <!---File Tab[Start]--->
            <div class="tab-pane fade" id="file_tab">
            <?php $data['itemID'] = $newsID;
                  $data['fileTypeID'] = 2;
                  echo view('adminarea.file.file',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]--->
        @endif
    </div>
</section>
@endsection
