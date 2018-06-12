<?php $__env->startSection('content'); ?>
<?php echo $__env->make('adminarea.product.product-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<style type="text/css">
    .disabled {
        background: #ffadad;
        color: #fff;
    }
</style>
<script type="text/javascript">
    $(document).ready(
        function()
        {
            $('#shortDescription').redactor({
                imageUpload: "<?php echo e(url('/')); ?>/redactor/scripts/image_upload.php",
                fileUpload: "<?php echo e(url('/')); ?>/redactor/scripts/file_upload.php"
            });
        }
    );
    
    $(document).ready(
        function()
        {
            $('#longDescription').redactor({
                imageUpload: "<?php echo e(url('/')); ?>/redactor/scripts/image_upload.php",
                fileUpload: "<?php echo e(url('/')); ?>/redactor/scripts/file_upload.php"
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
use App\Http\Models\Customer;

$productID=Input::get('productID')?Input::get('productID'):'0';


$productdata = Product::where('productID',$productID)->first();
  
if(isset($productdata->createdBy))
{
$customerID=$productdata->createdBy;

$customer = Customer::find($customerID);
  $customer_pk = $customer->stripe_pk;
  $customer_sk = $customer->stripe_sk;

}
else{

  $customer_pk = '';
  $customer_sk = '';
}

if($productID==0){
    $productID=old('productID')?old('productID'):'';    
}
$categoryID=old('categoryID')?old('categoryID'):'';
$parentID=old('parentID')?old('parentID'):'0';
$sizeID=old('sizeID')?old('sizeID'):'0';
$productName=old('productName')?old('productName'):'';
$city=old('city')?old('city'):'';
$shortDescription=old('shortDescription')?old('shortDescription'):'';
$projectDescription=old('projectDescription')?old('projectDescription'):'';
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
$tab=old('tab')?old('tab'):1;
$isDraft=old('isDraft')?old('isDraft'):1;

$eventimage=old('event_img')?old('event_img'):'';
$event_time=old('event_time')?old('event_time'):'';
$display_page=old('display_page')?old('display_page'):'';


$featured_page=old('featured_page')?old('featured_page'):'';
$staff_pics_page=old('staff_pics_page')?old('staff_pics_page'):'';
$popular_page=old('popular_page')?old('popular_page'):'';


$productDate1= old('productDate')?date('m/d/Y',strtotime(old('productDate'))):date('m/d/Y');
$date=date_create($productDate1);
date_add($date,date_interval_create_from_date_string("14 days"));

$productDate=date_format($date,"m/d/Y");
$productExpiredDate= old('productExpiredDate')?date('m/d/Y',strtotime(old('productExpiredDate'))):date('m/d/Y');
$productStartTime=old('productStartTime')?old('productStartTime'):'';
$productEndTime=old('productEndTime')?old('productEndTime'):'';

$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';

$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0)
{
  $redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
}


if($productID != NULL && $productID >0)
{
    if(isset($getsingleproduct))
    {
        $productName=$getsingleproduct->productName;
        $shortDescription=$getsingleproduct->shortDescription;
         $projectDescription=$getsingleproduct->projectDescription;
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

        if(!empty($getsingleproduct->productDate))
        {
          $productDate=$getsingleproduct->productDate;
         
        }
        else
        {
           $productDate=$productDate;
         
        }

        
        $productExpiredDate=$getsingleproduct->productExpiredDate;
        $productStartTime=$getsingleproduct->productStartTime;
        $productEndTime=$getsingleproduct->productEndTime;
        $price=$getsingleproduct->price;
        $tab=$getsingleproduct->tab;
        $isDraft=$getsingleproduct->isDraft;
        $event_time=$getsingleproduct->event_time;
        $eventimage=$getsingleproduct->event_img;

        $display_page=$getsingleproduct->display_page;

        $featured_page=$getsingleproduct->featured_page;
        $staff_pics_page=$getsingleproduct->staff_pics_page;
        $popular_page=$getsingleproduct->popular_page;


    }

    $count_event = DB::table('product_size')->where('productID',$productID)->where('eventType','3')->count();
}
else{

$count_event=0;

}

?>


    <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/')); ?>/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo e(url('/')); ?>/adminarea/product">Event Management</a></li>
        <li class="active"><?php if($productID != NULL && $productID >0): ?> Edit <?php else: ?> Add <?php endif; ?> Event </a></li>
    </ol>
    <section class="content-header top_header_content">
        <div class="nav-tabs-custom">
             <?php echo $__env->make('include.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             <ul class="nav nav-tabs" role="tablist">
                   <li class="active"><a href="#general_tab" role="tab" data-toggle="tab" id='general_tab1'>General Tab</a></li>
                   <?php if($productID != 0  && $CategorytypeID != Config::get('config.packageCategorytypeID','12')){ ?>
                      <li><a href="#mainimage_tab" role="tab" data-toggle="tab" id='mainimage_tab1'>Event Details Tab</a></li>
                      <?php /*?><li><a href="#category_tab" role="tab" data-toggle="tab">Category Selection</a></li><?php */?>
                      <?php if($tab>=2): ?>
                      <li><a href="#size_tab" role="tab" data-toggle="tab" id='size_tab1'>Reward options</a></li>
                      <?php /*?><li><a href="#meta_tab" role="tab" data-toggle="tab">Meta Information</a></li>
                      <li><a href="#related_tab" role="tab" data-toggle="tab">Related Product</a></li>
                      <li><a href="#review_tab" role="tab" data-toggle="tab">Customer Reviews</a></li><?php */?>
                      <li><a href="#order_tab" role="tab" data-toggle="tab">Donation Information</a></li>
                      <li><a href="#reward_tab" role="tab" data-toggle="tab">Reward Information</a></li>
                      <?php endif; ?>
                  <?php } ?>
            </ul>
       </div>
        <div class="tab-content">
        <!----general information[start]---->
            <div class="tab-pane active" id="general_tab">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="row">
                        <form name="frm_product_addedit" id="frm_product_addedit"  action="<?php echo e(url('/')); ?>/adminarea/product/saveproduct" method="post" class="form-horizontal" enctype="multipart/form-data" >
                        <input type="hidden" class="form-control" name="isBack" id="" value="">
                        <input type="hidden" class="form-control" name="productID" id="productID" value="<?php echo e($productID); ?>">
                        <input type="hidden" class="form-control" name="itemID" id="itemID" value="<?php echo e($productID); ?>">
                        <input type="hidden" name="sizeID" id="sizeID" value="<?php echo e(@$sizeID); ?>" />
                        <input type="hidden" name="imagesTypeID" id="imagesTypeID" value="<?php echo e(@$imagesTypeID); ?>" />
                        <input type="hidden" name="srach_name" id="srach_name" value="<?php echo e($srach_name); ?>" >
                        <input type="hidden" name="startDate" id="startDate" value="<?php echo e($startDate); ?>" >
                        <input type="hidden" name="endDate" id="endDate" value="<?php echo e($endDate); ?>" >
                        <input type="hidden" name="srch_status" id="srch_status" value="<?php echo e($srch_status); ?>" >
                        <input type="hidden" name="dropdown" id="dropdown" value="1" />
                        <input type="hidden" name="parentID" id="parentID" value="<?php echo e($parentID); ?>" />
                        <input type="hidden" value="<?php echo e($CategorytypeID); ?>" name="CategorytypeID" />
                        <input type="hidden" name="redirects_to" id="redirects_to" value="<?php echo e($redirects_to); ?>" >
                        <input type="hidden" name="tab" id="tab" value="<?php echo e($tab); ?>" >
                        <input type="hidden" name="productDate" VALUE="<?php echo $productDate; ?>">
                        <input type="hidden" name="url_title" id="url_title" value="<?php echo e($url_title); ?>" >
                        <!--start add user -->
                            <div class="box">
                                <div class="property_add">
                                    <!-- strat box header-->
                                    <div class="box-title with-border">
                                        <h2><?php if($productID != NULL && $productID >0): ?> Edit <?php else: ?> Add <?php endif; ?> Event</h2>
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
                                                                        <?php foreach($qGetAllCategory as $GetAllCategory): ?>
                                                                        <option value="<?php echo e($GetAllCategory->categoryID); ?>" <?php if($GetAllCategory->categoryID==$categoryID): ?>selected="selected"<?php endif; ?>><?php echo e($GetAllCategory->categoryname); ?></option>
                                                                        <?php endforeach; ?>
                                                                     </select>
                                                                </div>
                                                            </div>
                                                            <?php /*?>Product Category Only This Project[End]<?php */?>
    
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Project Name <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="productName" maxlength="100" id="productName" value="<?php echo e($productName); ?>" placeholder="Project Name" required>
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
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Short Description <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="shortDescription" maxlength="100" id="" value="<?php echo e($shortDescription); ?>" placeholder="Short Description " required>
                                                                </div>
                                                            </div>
                                                            
                                                             <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Long Description <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <textarea id="shortDescription" required name="projectDescription"><?php echo e($projectDescription); ?></textarea>
                                                                </div>
                                                            </div>  
                                                           <div class="form-group">
                                     

                                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label">Project Image <span class="mandatory_field">*</span></label>
                                                              <img src="<?php echo e(url('/')); ?>/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="=> Image must be smaller than 300*400 => The product image may not be greater than 1000 KB.">
                                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                                  <input class="form-control" name="prodcutImage" maxlength="200" id="prodcutImage" type="file" value="" onchange="file_check_product();" />
                                                                  <input type="hidden" name="prodcutImage_old" value="<?php echo e($prodcutImage); ?>" />
                                                                  <div id='imagePreview' ></div>
                                                                   <?php if(strlen($prodcutImage)>0): ?>
                                                                      <span id="image"><a href="javascript:fun_remove_thumb(<?php echo e($productID); ?>,'<?php echo e($prodcutImage); ?>');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                                          <img src="<?php echo e(url('/')); ?>/upload/product/mainimages/<?php echo e($prodcutImage); ?>" height="180" width="180" />
                                                                      </span>
                                                                   <?php endif; ?>
                                                                   
                                                              </div>

                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">City <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                <select class="form-control" id='city' required name="city">
                                                                <option selected="true" disabled="disabled">Select City</option>
                                                                  <?php  $datacity=App\City::where('status','1')->get(); ?>
                                                                  <?php foreach($datacity as $showcity): ?>
                                                                    <option 
                                                                     <?php if($city==$showcity->city){ echo 'selected="selected"';} 
                                                                      ?>
                                                                     >
                                                                      <?php echo $showcity->city; ?></option>
                                                                  <?php endforeach; ?>  
                                                                </select>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Goal <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="number" class="form-control" name="price" maxlength="200" id="price" placeholder="Goal" value="<?php echo e($price); ?>" required >
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
                                                        
                                    <?php if(Session::get('admin_role')==1): ?>  
                                      <label class="col-sm-2 col-md-2 col-xs-5 control-label">Select Display section</label>
                                     <div class="form-group">
                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label">Featured section</label>
                                      
                                         <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                                
                                                <input type="radio" value="1"  <?php if($featured_page==1){ echo "checked='checked'";} ?> name="featured_page">&nbsp;Yes
                                            </label>

                                        </div>
                                        <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                               
                                                <input type="radio" value="0"  <?php if($featured_page==0){ echo "checked='checked'";} ?> name="featured_page">&nbsp;No
                                            </label>

                                        </div>
                                     </div> 
                                      <div class="form-group">
                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label">  Staff Pics Section</label>
                                      
                                          <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                                
                                                <input type="radio" value="1"  <?php if($staff_pics_page==1){ echo "checked='checked'";} ?> name="staff_pics_page">&nbsp;Yes
                                            </label>

                                        </div>
                                        <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                               
                                                <input type="radio" value="0"  <?php if($staff_pics_page==0){ echo "checked='checked'";} ?> name="staff_pics_page">&nbsp;No
                                            </label>

                                        </div>
                                     </div> 
                                      <div class="form-group">
                                        <label class="col-sm-2 col-md-2 col-xs-5 control-label">Popular Section </label>
                                      
                                         <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                                
                                                <input type="radio" value="1"  <?php if($popular_page==1){ echo "checked='checked'";} ?> name="popular_page">&nbsp;Yes
                                            </label>

                                        </div>
                                        <div class=" col-md-2 ">
                                            <label class="radio-inline">
                                               
                                                <input type="radio" value="0"  <?php if($popular_page==0){ echo "checked='checked'";} ?> name="popular_page">&nbsp;No
                                            </label>

                                        </div>
                                     </div>  
                                                            <div class="form-group">
                                                                <label class="col-sm-2 col-md-2 col-xs-5 control-label">Display Order <span class="mandatory_field">*</span></label>
                                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                                    <input type="text" class="form-control" name="displayOrder" maxlength="4" id="displayOrder" placeholder="Display Order" value="<?php echo e($displayOrder); ?>" onkeypress="return isNumberKey(event)">
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
                                                                    <label class="check_btn"><input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" <?php if($isActive==1): ?> checked='checked' <?php endif; ?> name="isActive">IsActive?</label>
                                                                </div>
                                                            </div> 


                                                            <?php endif; ?>
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
                                            <?php if($isDraft==1): ?>
                                                <input type="hidden" name="isDraft" id="isDraft" value="1" >
                                                <?php if($tab==4): ?>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5"  onclick="fun_back_ganaral('1');" >Save As Draft</button>

                                                    <?php if( $count_event>0): ?>

                                                       <?php if($customer_pk && $customer_sk): ?> 
                                                      <input type="submit" class="btn btn-warning waves-effect waves-light submit" name="save" value="Go Live">
                                                      <?php endif; ?>
                                                     <?php endif; ?>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5 submit"  onclick="fun_back_ganaral('1');" >Continue</button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <input type="hidden" name="isDraft" id="isDraft" value="0" >
                                                <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5 submit"  onclick="fun_back_ganaral('1');" >Save</button>
                                            <?php endif; ?>
                                            <?php /*?><button type="button" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_ganaral(0)">Back</button><?php */?>
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
        <!----general information[end]----> 
        <?php if($productID != 0): ?>
        <?php /*?><!---Product Category Tab[Start]----->
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
        <!---Product Size Tab[Start]---->
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
                  
                  $data['tab'] = $tab;
                  $data['isDraft'] = $isDraft;
                  $data['url_title'] = $url_title;
                  $data['count_event']=$count_event;

                  $data['customer_pk'] = $customer_pk;
                  $data['customer_sk']=$customer_sk;
                  echo view('adminarea.product.product_size.product_size',$data)->render(); 
            ?>
            </div>      
        <!---Product Size Tab[end]---->
    
        <!---Image Tab[Start]---->
            <div class="tab-pane fade" id="image_tab">
            <?php $data['itemID'] = $productID;
                  $data['imagesTypeID'] = Config::get('config.productImageTypeID','4');
                  $data['tab'] = $tab;
                  echo view('adminarea.images.images',$data)->render(); 
            ?>
            </div>      
        <!---Image Tab[end]--->
        
        <!---File Tab[Start]---->
            <div class="tab-pane fade" id="file_tab">
            <?php $data['itemID'] = $productID;
                  $data['fileTypeID'] = Config::get('config.productFileTypeID','4');
                  $data['tab'] = $tab;
                  echo view('adminarea.file.file',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]----->
        
         <!---Product Main Image Tab[Start]---->
            <div class="tab-pane fade" id="mainimage_tab">
            <?php $data['productID'] = $productID;
                  $data['prodcutImage'] = $prodcutImage;
                  $data['altimage'] = $altimage;
                  $data['longDescription'] = $longDescription;
                  $data['redirects_to'] = $redirects_to;
                  $data['tab'] = $tab;
                  $data['isDraft'] = $isDraft;
                  $data['url_title'] = $url_title;
                  $data['eventimage']=$eventimage;
                  $data['event_time']=$event_time;
                  $data['productDate']=$productDate;
                  $data['isActive']=$isActive;
                  $data['count_event']=$count_event;
                  $data['customer_pk'] = $customer_pk;
                  $data['customer_sk']=$customer_sk;
                  
                  echo view('adminarea.product.product_mainimage.product_mainimage',$data)->render(); 
            ?>
            </div>      
        <!---Product Meta Description Tab[end]--->
        
        <!---Product Meta Description Tab[Start]---->
            <div class="tab-pane fade" id="meta_tab">
            <?php $data['productID'] = $productID;
                  $data['metaDescription'] = $metaDescription;
                  $data['pageTitle'] = $pageTitle;
                  $data['metaKeyword'] = $metaKeyword;
                  $data['keywordDescription'] = $keywordDescription;
                  $data['redirects_to'] = $redirects_to;
                  $data['tab'] = $tab;
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
                  $data['tab'] = $tab;
                  echo view('adminarea.product.order',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]--->
        
        <!---Order Tab[Start]---->
            <div class="tab-pane fade" id="reward_tab">
            <?php $data['itemID'] = $productID;
                  $data['qGetProductRewardData'] = $qGetProductRewardData;
                  $data['prodcutRewardRecordCount'] = $prodcutRewardRecordCount;
                  //dd($data['qGetProductOrderData']);
                  $data['tab'] = $tab;
                  echo view('adminarea.product.reward',$data)->render(); 
                 // view('adminarea.files.files',$data);?>
            </div>  
        <!---File Tab[Start]---->
        <?php /*?><!---Product Related Tab information[START]---->
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
        <?php endif; ?>
        </div>

       
    </section>

    <script type="text/javascript">
        
       function file_check_product()
            {
              var fileInput = document.getElementById('prodcutImage');
                var filePath = fileInput.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if(!allowedExtensions.exec(filePath)){
                    alert('Please upload file having extensions .jpeg/.jpg/.png only.');
                    fileInput.value = '';
                    return false;

                      $("#image").show( "slow" );
                }
                else if (fileInput.files && fileInput.files[0])
                {
                     var size = fileInput.files[0].size;

                            if(size > 1048576)
                            {
                                alert("Maximum file size exceeds");
                                 fileInput.value = '';
                                return false;
                                $("#image").show( "slow" );
                            }
                }
                 else{
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('imagePreview').innerHTML = '<img style="height: 200px; width:200px;" src="'+e.target.result+'"/>';
                              $("#image").hide( "slow" );
                            image
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }

            $( document ).ready(function()
            {
               var tab= $('#tab').val();
               
               if(tab=='1'){

                $('#mainimage_tab1').click();
               }
               
               else if(tab=='2' || tab=='3' || tab=='4'){
                $('#size_tab1').click();
               }
            });
    </script>

    <script type="text/javascript">
      $(document).ready(function (){
            validate();
            $('#categoryID, #productName, #shortDescription, #prodcutImage, #city, #price').change(validate);
        });

      function validate(){

//var giri=$("#shortDescription").text($(this).val().length);
var shortDescription = document.getElementById("shortDescription");


          if ($('#categoryID').val().length   >   0   &&
              $('#productName').val().length  >   0   &&
              $('#prodcutImage').val().length  >   0   &&
              $('#city').val().length  >   0   &&
              $('#price').val().length  >   0   &&

              number(shortDescription.value.length) > number(0)) {
              $(".submit").prop("disabled", false);           
          }
          else {    

          
              $(".submit").prop("disabled", true);
          }
      }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminarea.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>