@extends('adminarea.home')
@section('content')
@include('adminarea.product.product-js')

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#shortDescription').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
	
	$(document).ready(
		function()
		{
			$('#longDescription').redactor({
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

<?php use App\Http\Models\Product;
$productID=Input::get('productID')?Input::get('productID'):'0';
if($productID==0){
	$productID=old('productID')?old('productID'):'';	
}
$categoryID=old('categoryID')?old('categoryID'):'';
$parentID=old('parentID')?old('parentID'):'0';
$sizeID=old('sizeID')?old('sizeID'):'0';
$productName=old('productName')?old('productName'):'';
$city=old('city')?old('city'):'';
$shortDescription=old('shortDescription')?old('shortDescription'):'';
$longDescription=old('longDescription')?old('longDescription'):'';
$keywordDescription=old('keywordDescription')?old('keywordDescription'):'';
$isActive=old('isActive')?old('isActive'):1;
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$url_title=old('url_title')?old('url_title'):'';
$itemnumber=old('itemnumber')?old('itemnumber'):'';
$pageTitle=old('pageTitle')?old('pageTitle'):'';
$metaKeyword=old('metaKeyword')?old('metaKeyword'):'';
$metaDescription=old('metaDescription')?old('metaDescription'):'';
$isFeatured=old('isFeatured')?old('isFeatured'):0;
$availabilityStatus=old('availabilityStatus')?old('availabilityStatus'):'';
$prodcutImage=old('prodcutImage_old')?old('prodcutImage_old'):'';
$altimage=old('altimage')?old('altimage'):'';
$reviewID=old('reviewID')?old('reviewID'):0;
$producttype=old('producttype')?old('producttype'):'';
$price=old('price')?old('price'):'';


$productDate= old('productDate')?date('m/d/Y',strtotime(old('productDate'))):date('m/d/Y');
$productExpiredDate= old('productExpiredDate')?date('m/d/Y',strtotime(old('productExpiredDate'))):date('m/d/Y');
$productStartTime=old('productStartTime')?old('productStartTime'):'';
$productEndTime=old('productEndTime')?old('productEndTime'):'';

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
}


if($productID != NULL && $productID >0)
{
	if(isset($getsingleproduct))
	{
		$productName=$getsingleproduct->productName;
		$shortDescription=$getsingleproduct->shortDescription;
		$prodcutImage=$getsingleproduct->prodcutImage;
		$availabilityStatus=$getsingleproduct->availabilityStatus;
		$altimage=$getsingleproduct->altimage;
		$city=$getsingleproduct->city;
		$longDescription=$getsingleproduct->longDescription;
		$keywordDescription=$getsingleproduct->keywordDescription;
		$isFeatured=$getsingleproduct->isFeatured;
		$isActive=$getsingleproduct->isActive;
		$displayOrder=$getsingleproduct->displayOrder;
		$pageTitle=$getsingleproduct->pageTitle;
		$metaDescription=$getsingleproduct->metaDescription;
		$metaKeyword=$getsingleproduct->metaKeyword;
		$url_title=$getsingleproduct->url_title;
		$itemnumber=$getsingleproduct->itemnumber;
		$producttype=$getsingleproduct->producttype;
		$productDate=$getsingleproduct->productDate;
		$productExpiredDate=$getsingleproduct->productExpiredDate;
		$productStartTime=$getsingleproduct->productStartTime;
		$productEndTime=$getsingleproduct->productEndTime;
		$price=$getsingleproduct->price;
	}

}
?>

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ url('/') }}/adminarea/product">Event Management</a></li>
        <li class="active">@if($productID != NULL && $productID >0) Edit @else Add @endif Event </a></li>
    </ol>
    <section class="content-header top_header_content">
    	<div class="nav-tabs-custom">
             @include('include.message')
             <ul class="nav nav-tabs" role="tablist">
                   <li class="active"><a href="#general_tab" role="tab" data-toggle="tab">General Tab</a></li>
                   <?php if($productID != 0  && $CategorytypeID != Config::get('config.packageCategorytypeID','12')){ ?>
                      <?php /*?><li><a href="#category_tab" role="tab" data-toggle="tab">Category Selection</a></li><?php */?>
                      <li><a href="#size_tab" role="tab" data-toggle="tab">Reward options</a></li>
                      <li><a href="#meta_tab" role="tab" data-toggle="tab">Meta Information</a></li>
                      <?php /*?><li><a href="#related_tab" role="tab" data-toggle="tab">Related Product</a></li>
                      <li><a href="#review_tab" role="tab" data-toggle="tab">Customer Reviews</a></li><?php */?>
                      <li><a href="#order_tab" role="tab" data-toggle="tab">Donation Information</a></li>
                      <li><a href="#reward_tab" role="tab" data-toggle="tab">Reward Information</a></li>
                  <?php } ?>
            </ul>
       </div>
        <div class="tab-content">
        <!---general information[start]--->
            <div class="tab-pane active" id="general_tab">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="row">
                        <form name="frm_product_addedit" id="frm_product_addedit"  action="{{ url('/') }}/adminarea/product/saveproduct" method="post" class="form-horizontal" enctype="multipart/form-data" >
                        <input type="hidden" class="form-control" name="isBack" id="" value="">
                        <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
                        <input type="hidden" class="form-control" name="itemID" id="itemID" value="{{$productID}}">
                        <input type="hidden" name="sizeID" id="sizeID" value="{{@$sizeID}}" />
                        <input type="hidden" name="imagesTypeID" id="imagesTypeID" value="{{@$imagesTypeID}}" />
                        <input type="hidden" name="srach_name" id="srach_name" value="{{$srach_name}}" >
                        <input type="hidden" name="startDate" id="startDate" value="{{$startDate}}" >
                        <input type="hidden" name="endDate" id="endDate" value="{{$endDate}}" >
                        <input type="hidden" name="srch_status" id="srch_status" value="{{$srch_status}}" >
                        <input type="hidden" name="dropdown" id="dropdown" value="1" />
                        <input type="hidden" name="parentID" id="parentID" value="{{$parentID}}" />
						<input type="hidden" value="{{$CategorytypeID}}" name="CategorytypeID" />
                        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
                        <!--start add user -->
                            <div class="box">
                                <div class="property_add">
                                    <!-- strat box header-->
                                    <div class="box-title with-border">
                                        <h2>@if($productID != NULL && $productID >0) Edit @else Add @endif Event</h2>
                                    </div>
                                    <!-- end box -header -->
                                    <!-- strat box-body area-->
                                        <!-- start general & seo tab-->
                                         <div class="tab-content">
                                             <div class="active tab-pane">
                                                <div class="addunit_forms">
                                                    <div class="box-body">
                                                       <div class="form-group-main">
                                                       
                                                            <?php /*?>Product Category Only This Project[Start]<?php */?>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Event Category <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <?php /*?><?php 
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
                                                                    @endforeach<?php */?>
                                                                    
                                                                    <?php if($checkedCategoryRecordCount>0)
                                                                         {
                                                                             $categoryID=$qGetCheckedCategory[0]->categoryID;
                                                                            
                                                                         }
                                                                    ?>
                                                                    <select name="categoryID" class="form-control" id="categoryID">
                                                                        <option selected="selected" value="">==Select Event Category==</option>
                                                                        @foreach($qGetAllCategory as $GetAllCategory)
                                                                        <option value="{{$GetAllCategory->categoryID}}" @if($GetAllCategory->categoryID==$categoryID)selected="selected"@endif>{{ $GetAllCategory->categoryname }}</option>
                                                                        @endforeach
                                                                     </select>
                                                                </div>
                                                            </div>
                                                            <?php /*?>Product Category Only This Project[End]<?php */?>
    
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Event Name <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="productName" maxlength="100" id="productName" value="{{$productName}}" placeholder="Product Name">
                                                                </div>
                                                            </div>
                                                            
                                                            <?php /*?><div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Itemnumber <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="itemnumber" maxlength="20" id="itemnumber" placeholder="Itemnumber" value="{{$itemnumber}}">
                                                                </div>
                                                            </div><?php */?>
                                                            
                                                            <?php /*?><div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Availability Status <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <select name="availabilityStatus" class="form-control" id="availabilityStatus">
                                                                        <option selected="selected" value="">==Select Availability Status==</option>
                                                                        <option value="0" @if($availabilityStatus==0)selected="selected"@endif>Event Running</option>
                                                                        <option value="1" @if($availabilityStatus==1)selected="selected"@endif>Event Close</option>


                                                                     </select>
                                                                </div>
                                                            </div><?php */?>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Main Image <span class="mandatory_field">*</span></label>
                                                                <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="Image must be smaller than 300*400">
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input class="form-control" name="prodcutImage" maxlength="200" id="prodcutImage" type="file" value="" />
                                                                    <input type="hidden" name="prodcutImage_old" value="{{$prodcutImage}}" />
                                                                     @if(strlen($prodcutImage)>0)
                                                                        <span id="image"><a href="javascript:fun_remove_thumb({{ $productID }},'{{ $prodcutImage }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                                            <img src="{{ url('/') }}/upload/product/mainimages/{{ $prodcutImage }}" height="180" width="180" />
                                                                        </span>
                                                                     @endif
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Image Alt Tag</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="altimage" maxlength="200" id="altimage" placeholder="Image Alt Tag" value="{{ $altimage }}" >
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Short Description</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea id="shortDescription" name="shortDescription">{{ $shortDescription}}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Long Description</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea id="longDescription" name="longDescription">{{ $longDescription}}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">City <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="city" maxlength="200" id="city" placeholder="City" value="{{ $city }}" required >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Goal <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="number" class="form-control" name="price" maxlength="200" id="price" placeholder="Goal" value="{{ $price }}" required >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Date <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                      <div class="input-group">
                                                                        <div id="sandbox-container">
                                                                            <input type="text" name="productDate" id="productDate" class="form-control" maxlength="20" placeholder="Date" value="{{ date('m/d/Y',strtotime($productDate))}}">
                                                                        </div>
                                                                          <script type="text/javascript">
                                                                                $('#sandbox-container input').datepicker({
                                                                                format: 'mm/dd/yyyy',
                                                                                keyboardNavigation: false,
                                                                                forceParse: false,
                                                                                //startDate: new Date(), 
                                                                                autoclose: true
                                                                                })
                                                                            </script>
                                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
											
                                                             <?php /*?><div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">StartTime</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                      <div class="input-group">
                                                                        <select name="productStartTime" class="form-control">
                                                                            <?php for($i=0;$i<=23;$i++){?>
                                                                            <option value="<?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00')))); ?>" <?php if($productStartTime == @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00'))))){echo "selected='selected'";}?> >
                                                                                <?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00')))); ?>
                                                                            </option>
                                                                            <?php $j = $i + 1; ?>
                                                                            <option value="<?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes')))); ?>" <?php if($productStartTime == @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes'))))){echo "selected='selected'";}?>>
                                                                               <?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes')))); ?>
                                                                            </option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                              <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">End Time</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                      <div class="input-group">
                                                                        <select name="productEndTime" class="form-control">
                                                                            <?php for($i=0;$i<=23;$i++){?>
                                                                            <option value="<?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00')))); ?>" <?php if($productEndTime == @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00'))))){echo "selected='selected'";}?> >
                                                                                <?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00')))); ?>
                                                                            </option>
                                                                            <?php $j = $i + 1; ?>
                                                                            <option value="<?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes')))); ?>" <?php if($productEndTime == @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes'))))){echo "selected='selected'";}?>>
                                                                               <?php echo @date('g:i A', strtotime(@date('g:i A', strtotime($i.':00' . '+30 minutes')))); ?>
                                                                            </option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                              </div>
															<div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Expired Date <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                      <div class="input-group">
                                                                        <div id="sandbox-container2">
                                                                            <input type="text" name="productExpiredDate" id="productExpiredDate" class="form-control" maxlength="20" placeholder="Expired Date" value="{{ date('m/d/Y',strtotime($productExpiredDate))}}">
                                                                        </div>
                                                                          <script type="text/javascript">
                                                                                $('#sandbox-container2 input').datepicker({
                                                                                format: 'mm/dd/yyyy',
                                                                                keyboardNavigation: false,
                                                                                forceParse: false,
                                                                                //startDate: new Date(), 
                                                                                autoclose: true
                                                                                })
                                                                            </script>
                                                                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div><?php */?>
														
                                                            
     								@if(Session::get('admin_role')==1)		
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Display Order <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
    							   
    							   
    							   <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Featured</label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <label class="radio-inline">
                                                                        <input type="radio" value="1"  <?php if($isFeatured==1){ echo "checked='checked'";} ?> name="isFeatured">&nbsp;Yes
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" value="0"  <?php if($isFeatured==0){ echo "checked='checked'";} ?> name="isFeatured">&nbsp;No
                                                                    </label>
                                                                </div>
                                                            </div>
    							   												
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label"></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
                                                                </div>
                                                            </div> 
                                                            @endif
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
                                            <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5"  onclick="fun_back_ganaral(1);" >Save As Draft</button>
                                            <input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Go Live">
                                            <button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_ganaral(0)">Back</button>
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
        @if($productID != 0)
        <?php /*?><!---Product Category Tab[Start]--->
            <div class="tab-pane fade" id="category_tab">
            <?php $data['productID'] = $productID;
                  $data['productName'] = $productName;
                  $data['qGetAllCategory'] = $qGetAllCategory;
                  $data['qGetCheckedCategory'] = $qGetCheckedCategory;
                  echo view('adminarea.product.product_category.product_category',$data)->render(); 
            ?>
            </div>      
        <!---Product Category Tab[end]--->
    <?php */?>
        <!---Product Size Tab[Start]--->
            <div class="tab-pane fade" id="size_tab">
            <?php $data['productID'] = $productID;
                  $data['sizeID'] = $sizeID;
    
                  $data['qGetPriceCategory'] = $qGetPriceCategory;
                  $data['priceCategoryRecordCount'] = $priceCategoryRecordCount;
    
                  $data['qGetProductSizeData'] = $qGetProductSizeData;
                  $data['prodcutSizeRecordCount'] = $prodcutSizeRecordCount;
    
                  $data['qGetProductIteamData'] = $qGetProductIteamData;
                  $data['prodcutIteamRecordCount'] = $prodcutIteamRecordCount;
    
                  $data['qGetProductPriceData'] = $qGetProductPriceData;
                  $data['prodcutPriceRecordCount'] = $prodcutPriceRecordCount;
                  echo view('adminarea.product.product_size.product_size',$data)->render(); 
            ?>
            </div>      
        <!---Product Size Tab[end]--->
    
        <!---Image Tab[Start]--->
            <div class="tab-pane fade" id="image_tab">
            <?php $data['itemID'] = $productID;
                  $data['imagesTypeID'] = Config::get('config.productImageTypeID','4');
                  echo view('adminarea.images.images',$data)->render(); 
            ?>
            </div>      
        <!---Image Tab[end]--->
        
        <!---File Tab[Start]--->
            <div class="tab-pane fade" id="file_tab">
            <?php $data['itemID'] = $productID;
                  $data['fileTypeID'] = Config::get('config.productFileTypeID','4');
                  echo view('adminarea.file.file',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]--->
    
        <!---Product Meta Description Tab[Start]--->
            <div class="tab-pane fade" id="meta_tab">
            <?php $data['productID'] = $productID;
                  $data['metaDescription'] = $metaDescription;
                  $data['pageTitle'] = $pageTitle;
                  $data['metaKeyword'] = $metaKeyword;
                  $data['keywordDescription'] = $keywordDescription;
                  $data['redirects_to'] = $redirects_to;
                  echo view('adminarea.product.product_metakeyword.product_metakeyword',$data)->render(); 
            ?>
            </div>      
        <!---Product Meta Description Tab[end]--->
    
    	 <!---Order Tab[Start]--->
            <div class="tab-pane fade" id="order_tab">
            <?php $data['itemID'] = $productID;
				  $data['qGetProductOrderData'] = $qGetProductOrderData;
                  $data['prodcutOrderRecordCount'] = $prodcutOrderRecordCount;
				  //dd($data['qGetProductOrderData']);
                  echo view('adminarea.product.order',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]--->
        
        <!---Order Tab[Start]--->
            <div class="tab-pane fade" id="reward_tab">
            <?php $data['itemID'] = $productID;
				  $data['qGetProductRewardData'] = $qGetProductRewardData;
                  $data['prodcutRewardRecordCount'] = $prodcutRewardRecordCount;
				  //dd($data['qGetProductOrderData']);
                  echo view('adminarea.product.reward',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]--->
        <?php /*?><!---Product Related Tab information[START]--->
        <div class="tab-pane" id="related_tab">
            <?php echo view('adminarea.product.product_related.product_related',$data)->render(); ?>
        </div>
        <!---Product Related Tab information[END]--->
    
        <!---Product Review Tab[START]--->
        <div class="tab-pane" id="review_tab">
            <?php $data['GetSingleProductReview'] =$GetSingleProductReview;
                  echo view('adminarea.product.product_review.product_review',$data)->render(); ?>
        </div>
        <!---Product Review Tab[END]---><?php */?>
        @endif
        </div>
    </section>
@endsection
