@extends('adminarea.home')
@section('content')
@include('adminarea.category.category-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#category_content').redactor({
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
<?php
$categoryID=Input::get('categoryID')?Input::get('categoryID'):'0';
if($categoryID==0){
	$categoryID=old('categoryID')?old('categoryID'):'';	
}
$parentCategoryID=old('parentCategoryID')?old('parentCategoryID'):'';
$categoryname=old('categoryname')?old('categoryname'):'';
//$categorytypeID=old('categorytypeID')?old('categorytypeID'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;
$isFeatured=old('isFeatured')?old('isFeatured'):'';

$explore_page=old('explore_page')?old('explore_page'):'';


$pageTitle=old('pageTitle')?old('pageTitle'):'';
$pageMetaKeyword=old('pageMetaKeyword')?old('pageMetaKeyword'):'';
$pageDescription=old('pageDescription')?old('pageDescription'):'';
$content=old('content')?old('content'):'';
$imagename=old('imagename')?old('imagename'):'';
$classname=old('classname')?old('classname'):'';
$tmp = "";

$srach_categoryname=Input::get('srach_categoryname')?Input::get('srach_categoryname'):'';
$srach_parentcategoryname=Input::get('srach_parentcategoryname')?Input::get('srach_parentcategoryname'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($categoryID != NULL && $categoryID >0)
{
	if(isset($getsingleCategory))
	{
		$categoryname=$getsingleCategory->categoryname;
		$parentCategoryID=$getsingleCategory->parentCategoryID;
		$categorytypeID=$getsingleCategory->categorytypeID;
		$displayOrder=$getsingleCategory->displayOrder;
		$isActive=$getsingleCategory->isActive;
		$isFeatured=$getsingleCategory->isFeatured;

    $explore_page = $getsingleCategory->explore_page;


		$pageTitle=$getsingleCategory->pageTitle;
		$pageMetaKeyword=$getsingleCategory->pageMetaKeyword;
		$pageDescription=$getsingleCategory->pageDescription;
		$content=$getsingleCategory->content;
		$imagename=$getsingleCategory->imagename;
		$classname=$getsingleCategory->classname;
		
		function fun_getparent($id)
		{
			global $tmp;
			//$q_select_row = @mysql_query("SELECT parentCategoryID FROM category WHERE categoryID=".$id);
			//$q_get_result = @mysql_fetch_row($q_select_row);

      $q_get_result = DB::table('category')->select('parentCategoryID')->where('categoryID',$id)->first();

			if($q_get_result[0] > 0)
			{
				$tmp = $q_get_result[0].",".$tmp;
				fun_getparent($q_get_result[0]);
			}
			else
			{
				$_SESSION['str2']=$tmp;
			}
		}
		fun_getparent($parentCategoryID);
		
		$str_str = strrev(substr(strrev($_SESSION['str2']),1));
		$str_array = explode(",",$str_str);
		
		if($parentCategoryID>0 && $str_array[0]>0)
		{
			array_push($str_array,$parentCategoryID);
		}
		if($str_array[0]>0)
		{
			$parentCategoryID=$str_array[0];
		}
	}
}

?>

     <ol class="breadcrumb">
            <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
            @if($categorytypeID==1)
			<?php $categoryName= "News";?>
            <li><a href="{{ url('/') }}/adminarea/news/newscategory">News Category Management</a></li>
			 @elseif($categorytypeID==2)
			<?php $categoryName= "FAQ";?>
            <li><a href="{{ url('/') }}/adminarea/faq/faqcategory">FAQ Category Management</a></li>
			 @elseif($categorytypeID==3)
			<?php $categoryName= "Product";?>
            <li><a href="{{ url('/') }}/adminarea/product/productcategory">Product Category Management</a></li>
			 @elseif($categorytypeID==4)
			<?php $categoryName= "Link";?>
            <li><a href="{{ url('/') }}/adminarea/links/linkscategory">Link Category Management</a></li>
            <?php /*?>@elseif($categorytypeID==5)
			<?php $categoryName= "Blog";?>
            <li><a href="{{ url('/') }}/adminarea/blog/blogcategory">Blog Category Management</a></li><?php */?>
			@elseif($categorytypeID==6)
			<?php $categoryName= "Event";?>
            <li><a href="{{ url('/') }}/adminarea/event/eventcategory">Event Category Management</a></li>
			@elseif($categorytypeID==7)
			<?php $categoryName= "Contact";?>
            <li><a href="{{ url('/') }}/adminarea/contact/contactcategory">Contact Category Management</a></li>
			@elseif($categorytypeID==8)
			<?php $categoryName= "Services";?>
            <li><a href="{{ url('/') }}/adminarea/services/servicescategory">Services Category Management</a></li>
            @elseif($categorytypeID==5)
			<?php $categoryName= "Portfolio";?>
            <li><a href="{{ url('/') }}/adminarea/portfolio/portfoliocategory">Portfolio Category Management</a></li>
			@elseif($categorytypeID==10)
			<?php $categoryName= "Staff";?>
            <li><a href="{{ url('/') }}/adminarea/staff/staffcategory">Staff Category Management</a></li>
            @endif
			<li class="active">@if($categoryID != NULL && $categoryID >0) Edit @else Add @endif Category </a></li>
        </ol>
     @include('adminarea.include.message')
    <form name="frm_category_addedit" id="frm_category_addedit1"  action="{{ url('/') }}/adminarea/category/savecategory" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="categoryID" id="categoryID" value="{{ $categoryID }}">
        <input type="hidden" class="form-control" name="categorytypeID" id="categorytypeID" value="{{ $categorytypeID }}">
        <input type="hidden" class="form-control" name="categorytypePath" id="categorytypePath" value="{{ $categorytypePath }}">
        <input type="hidden" class="form-control" name="addcategorytypePath" id="addcategorytypePath" value="{{ $addcategorytypePath }}">
        <input type="hidden" name="parentCategoryID" id="parentCategoryID" value="{{ $parentCategoryID }}" />
        <input type="hidden" name="dropdown" id="dropdown" value="1" />

		<input type="hidden" name="srach_categoryname" id="srach_categoryname" value="{{ $srach_categoryname }}" >
        <input type="hidden" name="srach_parentcategoryname" id="srach_parentcategoryname" value="{{ $srach_parentcategoryname }}" >
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
                        <h2>@if($categoryID != NULL && $categoryID >0) Edit @else Add @endif {{$categoryName}} category</h2>
                    </div>
                    <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group-main">
                                       @if( $getMainCategoryType->isMultipleCategory==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Parent Category</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <select id="parentCategoryID_1" class="form-control" onchange="funGetChild(this.value,0,1)">
                                                        <option value="">Select</option>
                                                    @foreach($getMainCategory as $MainCategory)
                                                        <option value="{{ $MainCategory->categoryID }}" @if($MainCategory->categoryID==$parentCategoryID) selected="selected" @endif >{{ $MainCategory->categoryname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        
                                      @if( $getMainCategoryType->isContentEditorText==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Category Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="categoryname" id="categoryname" maxlength="200" value="{{ $categoryname }}" placeholder="Category Title">
                                            </div>
                                        </div>
                                       @endif
                                       
                                        @if( $getMainCategoryType->isContentEditorText==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Content</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea id="category_content" name="content">{{ $content }}</textarea> 
                                            </div>
                                        </div>
                                       @endif
                                        
                                       @if( $getMainCategoryType->isImage==1 ) 
                                        <div class="form-group">
                                        	<label for="image" class="col-sm-2 control-label">Image</label>
											<img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                            
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                            	<input type="file" class="form-control" name="imagename" id="imagename" placeholder="Display Order" value="">
                                                <input type="hidden" name="imageName_old" value="{{ $imagename }}" />
                                                @if(strlen($imagename)>0)
                                                    <span id="image"><a href="javascript:fun_remove_thumb({{ $categoryID }},'{{ $imagename }}');"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        <img src="{{ url('/') }}/upload/category/th_{{ $imagename }}" height="180" width="180" />
                                                    </span>
												@endif
                                            </div>
                                        </div>
                                       @endif
                                       
                                       @if( $getMainCategoryType->isDisplayOrder==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Display Order</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" id="displayOrder" maxlength="4" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                       @endif
                                      <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right"></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <label>
                                                  <input type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive"> IsActive?
                                                </label>
                                            </div>
                                        </div>
                                       
                                       


                                       <label class="col-sm-2 col-md-2 col-xs-5 control-label">Select Display section</label>
                                     <div class="form-group">
                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label">Featured section Home page</label>
                                      
                                         <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                                
                                                <input type="radio" value="1"  <?php if($isFeatured==1){ echo "checked='checked'";} ?> name="isFeatured">&nbsp;Yes
                                            </label>

                                        </div>
                                        <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                               
                                                <input type="radio" value="0"  <?php if($isFeatured==0){ echo "checked='checked'";} ?> name="isFeatured">&nbsp;No
                                            </label>

                                        </div>
                                     </div> 
                                      <div class="form-group">
                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label"> Explore Page</label>
                                      
                                          <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                                
                                                <input type="radio" value="1"  <?php if($explore_page==1){ echo "checked='checked'";} ?> name="explore_page">&nbsp;Yes
                                            </label>

                                        </div>
                                        <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                               
                                                <input type="radio" value="0"  <?php if($explore_page==0){ echo "checked='checked'";} ?> name="explore_page">&nbsp;No
                                            </label>

                                        </div>
                                     </div> 
                                       
                                       @if( $getMainCategoryType->isPageTitle==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Meta Keyword </label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea name="pageMetaKeyword" class="form-control" id="pageMetaKeyword">{{ $pageMetaKeyword }}</textarea>
                                            </div>
                                        </div> 
                                       @endif
                                       
                                       @if( $getMainCategoryType->isPageDescription==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Page Description</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea name="pageDescription" class="form-control" id="pageDescription">{{ $pageDescription }}</textarea>
                                            </div>
                                        </div> 
                                       @endif

									   @if( $getMainCategoryType->isPageClass==1 )
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Class</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-child" <?php if($classname=='fa fa-child' || strlen($classname)==0){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-child"></i>&nbsp;Children
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-hospital-o" <?php if($classname=='fa fa-hospital-o'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-hospital-o"></i>&nbsp;Emergencies
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-paw" <?php if($classname=='fa fa-paw'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-paw"></i>&nbsp;Animals
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-youtube-play" <?php if($classname=='fa fa-youtube-play'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-youtube-play"></i>&nbsp;Movie
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-stethoscope" <?php if($classname=='fa fa-stethoscope'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-stethoscope"></i>&nbsp;Medical
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-eye" <?php if($classname=='fa fa-eye'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-eye"></i>&nbsp;Faith
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-list" <?php if($classname=='fa fa-list'){?>checked="checked"<?php }?> />&nbsp;&nbsp;<i class="fa fa-list"></i>&nbsp;All
                                                </div>
                                            </div>
                                        </div>
                                       @endif
                                       
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
                            <button  type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back()">Back</button>
                         </div>
                    </div>
                  </div>
                <!-- end box-footer area-->
                <?php /*?><div class="tab-pane" id="salon_tab">
                    <div class="col-md-12">
                        <h2>Images Will Goes Here</h2>
                    </div>
                </div>
                <div class="tab-pane" id="accessory_tab">
                    <div class="col-md-12">
                        <h2>Files Will Goes Here</h2>
                    </div>
                </div><?php */?>
                </div>
            </div>
       </section>
       <!-- end add pages--> 
    </form>
    
    <script>
		<?php if($categoryID != NULL && $categoryID >0)
			{for($k=0 ; $k<count($str_array); $k++){ 
			$j=$k+1;
			if(isset($str_array[$j])){$checked = $str_array[$j];}else{$checked = 0;}
			?>
			setTimeout(function(){funGetChild(<?php echo $str_array[$k];?>,<?php echo $checked;?>,<?php echo $j;?>);},500);
		<?php }}?>
	</script>
@endsection
