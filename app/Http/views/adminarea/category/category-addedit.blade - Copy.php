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
$categorytypeID=old('categorytypeID')?old('categorytypeID'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):'';
$isFeatured=old('isFeatured')?old('isFeatured'):'';
$pageTitle=old('pageTitle')?old('pageTitle'):'';
$pageMetaKeyword=old('pageMetaKeyword')?old('pageMetaKeyword'):'';
$pageDescription=old('pageDescription')?old('pageDescription'):'';
$content=old('content')?old('content'):'';
$imagename=old('imagename')?old('imagename'):'';
$tmp = "";

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
		$pageTitle=$getsingleCategory->pageTitle;
		$pageMetaKeyword=$getsingleCategory->pageMetaKeyword;
		$pageDescription=$getsingleCategory->pageDescription;
		$content=$getsingleCategory->content;
		$imagename=$getsingleCategory->imagename;
		
		function fun_getparent($id)
		{
			global $tmp;
			$q_select_row = @mysql_query("SELECT parentCategoryID FROM category WHERE categoryID=".$id);
			$q_get_result = @mysql_fetch_row($q_select_row);

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
    <div class="right_side" role="main">
		<div class="center_container">
			<ul class="breadcrumb">
			  <li><a href="{{ url('/') }}/home">Home</a></li>
			  @if($categorytypeID==1)
              <li><a href="{{ url('/') }}/news/newscategory">Category Management</a></li>
			  @elseif($categorytypeID==5)
              <li><a href="{{ url('/') }}/blog/blogcategory">Category Management</a></li>
			  @elseif($categorytypeID==9)
              <li><a href="{{ url('/') }}/portfolio/portfoliocategory">Category Management</a></li>
              @elseif($categorytypeID==2)
              <li><a href="{{ url('/') }}/faq/faqcategory">Category Management</a></li>
              @elseif($categorytypeID==4)
              <li><a href="{{ url('/') }}/links/linkscategory">Category Management</a></li>
              @elseif($categorytypeID==3)
              <li><a href="{{ url('/') }}/product/productcategory">Category Management</a></li>
              @elseif($categorytypeID==6)
              <li><a href="{{ url('/') }}/event/eventcategory">Category Management</a></li>
              @endif
              <li class="active">@if($categoryID != NULL && $categoryID >0) Edit @else Add @endif Category </a></li>
			</ul>
		</div>
        <div class="panel row">
          <div class="panel-body">
            <div class="col-md-13" role="main">
                <div class="panel panel-default">

				  @include('adminarea.include.message')
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php if($categoryID != NULL && $categoryID >0){ echo "Edit";}else{ echo "Add";} ?> Category </a></h3>
                  </div>
                      
					<div class="col-md-12" role="main">
						<div class="col-md-12" role="main">&nbsp;</div>
						<div class="row">
							<form name="frm_category_addedit" id="frm_category_addedit1"  action="{{ url('/') }}/adminarea/category/savecategory" method="post" class="form-horizontal" enctype="multipart/form-data" >
                                <input type="hidden" class="form-control" name="categoryID" id="categoryID" value="{{ $categoryID }}">
                                <input type="hidden" class="form-control" name="categorytypeID" id="categorytypeID" value="{{ $categorytypeID }}">
                                <input type="hidden" class="form-control" name="categorytypePath" id="categorytypePath" value="{{ $categorytypePath }}">
                                <input type="hidden" class="form-control" name="addcategorytypePath" id="addcategorytypePath" value="{{ $addcategorytypePath }}">
                                <input type="hidden" name="parentCategoryID" id="parentCategoryID" value="{{ $parentCategoryID }}" />
                                <input type="hidden" name="dropdown" id="dropdown" value="1" />
								{!! Form::hidden('redirects_to', URL::previous()) !!}
                                
                                <ul class="nav nav-tabs" role="tablist">
									<li class="active"><a href="##salable_tab" role="tab" data-toggle="tab">General Tab</a></li>
								</ul>
								 <div class="tab-content">
									<div class="tab-pane active" id="salable_tab">
										<!--================================Category Form Start=====================================-->
										  <div class="form-group">
											<label for="" class="col-sm-2 control-label">&nbsp;</label>
											<div class="col-md-4">&nbsp;</div>
										  </div>
										  
                                          @if( $getMainCategoryType->isMultipleCategory==1 )
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Parent Category</label>
                                                <div class="col-md-4" id="parentDropdowns">
                                                    <select id="parentCategoryID_1" class="form-control" onchange="funGetChild(this.value,0,1)">
                                                        	<option value="">Select</option>
                                                        @foreach($getMainCategory as $MainCategory)
                                                            <option value="{{ $MainCategory->categoryID }}" @if($MainCategory->categoryID==$parentCategoryID) selected="selected" @endif >{{ $MainCategory->categoryname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isCategoryName==1 )
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Category Name *</label>
                                                <div class="col-md-4">
                                                  <input type="text" class="form-control" name="categoryname" id="categoryname" maxlength="200" value="{{ $categoryname }}" placeholder="Category Title">
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isContentEditorText==1 )
                                          	  <div class="form-group">
                                                <label for="summary" class="col-sm-2 control-label">Content </label>
                                                <div class="col-md-7">
                                                <textarea id="category_content" name="content">{{ $content }}</textarea>  
                                                </div>
                                              </div>
                                          @endif
										  
                                          @if( $getMainCategoryType->isImage==1 )
                                              <div class="form-group">
                                                <label for="image" class="col-sm-2 control-label">Image</label>
												<img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                <div class="col-md-2">
                                                  <input type="file" class="form-control" name="imagename" id="imagename" placeholder="Display Order" value="">
                                                  <input type="hidden" name="imagesName_old" value="{{ $imagename }}" />
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
                                                <label for="displayOrder" class="col-sm-2 control-label">Display Order</label>
                                                <div class="col-md-2">
                                                  <input type="text" class="form-control" name="displayOrder" id="displayOrder" maxlength="4" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                </div>
                                              </div>
                                          @endif
										  
                                         @if( $getMainCategoryType->isactive==1 )
                                              <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                  <div class="checkbox">
                                                    <label>
                                                      <input type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive"> IsActive?
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isFeatured==1 )
                                              <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                  <div class="checkbox">
                                                    <label>
                                                      <input type="checkbox" value="1" @if($isFeatured==1) checked='checked' @endif name="isFeatured"> isFeatured
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isPageTitle==1 )
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Page Title </label>
                                                <div class="col-md-4">
                                                  <input type="text" class="form-control" name="pageTitle" id="pageTitle" maxlength="70" value="{{ $pageTitle }}" placeholder="Page Title">
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isPageMetaKeyword==1 )
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Meta Keyword </label>
                                                <div class="col-md-4">
                                                	<textarea name="pageMetaKeyword" class="form-control" id="pageMetaKeyword">{{ $pageMetaKeyword }}</textarea>
                                                </div>
                                              </div>
                                          @endif
                                          
                                          @if( $getMainCategoryType->isPageDescription==1 )
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Page Description </label>
                                                <div class="col-md-4">
                                                	<textarea name="pageDescription" class="form-control" id="pageDescription">{{ $pageDescription }}</textarea>
                                                </div>
                                              </div>
                                          @endif
                                          
										  <div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
											  <button type="submit" class="btn btn-default btn-primary">Submit</button>
											  <button class="btn btn-default" type="button" onclick="fun_back()">Back</button>
											</div>
										  </div>
										<!--================================Category Form Start=====================================-->
									</div>
									<div class="tab-pane" id="salon_tab">
										<div class="col-md-12">
											<h2>Images Will Goes Here</h2>
										</div>
									</div>
									<div class="tab-pane" id="accessory_tab">
										<div class="col-md-12">
											<h2>Files Will Goes Here</h2>
										</div>
									</div>
								 </div>
							</form>
						</div>
					</div>
                </div>
             </div>
          </div>
        </div>
    </div>
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
