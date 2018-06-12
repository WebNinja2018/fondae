<?php use App\Http\Models\Product_size;?>
 @include('adminarea.include.head') {{-- Load Head --}}
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
	$('#frm_product_addeditprice').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                sizeID: {
                    message: 'Please select Options.',
						validators: 
						{
							notEmpty:{message: 'Please select Options.'}
						}
                },
				itemID: {
							message: 'Please select Iteam.',
							validators: 
							{
								notEmpty:{message: 'Please select Iteam.'}
							}
                },
				quantity: {
                  		message: 'Please enter Quantity',
						validators: 
							{
								notEmpty:{message: 'Please enter Quantity.'}
							}
                }
				 
            }
        })
</script>
@endif
<script>
$(document).ready(
	function()
	{
		$('#description').redactor({
			imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
			fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
		});
	}
);
</script>
<style>
#TB_title { height:40px; color:#fff;}
</style>

<?php
	$priceID=Input::get('priceID')?Input::get('priceID'):'0';
	if($priceID==0){
		$priceID=old('priceID')?old('sizeID'):'';	
	}
	$sizeID=old('sizeID')?old('sizeID'):'';
	$quantity=old('quantity')?old('quantity'):'';
	$categoryID=old('categoryID')?old('categoryID'):'';
	$price=old('price')?old('price'):'';
	$itemID=old('itemID')?old('itemID'):'';
	$isActive=old('isActive')?old('isActive'):1;
	$description=old('description')?old('description'):'';
	$eventType=old('eventType')?old('eventType'):'';
	$unpaidOption=old('unpaidOption')?old('unpaidOption'):'';
	
    $productID=Input::get('productID')?Input::get('productID'):'0';
	if($productID==0){
		$productID=old('productID')?old('productID'):'';	
	}

	$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
	if(strlen($redirects_to)==0){
	$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
	}

	if(isset($priceID) && $priceID > 0)
	{
		if(isset($qGetPriceData))
		{
			$sizeID=$qGetPriceData[0]->sizeID;
			$sizeName=$qGetPriceData[0]->sizeName;
			$quantity=$qGetPriceData[0]->quantity;
			$price=$qGetPriceData[0]->price;
			$categoryID=$qGetPriceData[0]->categoryID;
			$itemID=$qGetPriceData[0]->itemID;
			$isActive=$qGetPriceData[0]->priceStatus;
			
		}
	}
	
	$sizeinfo=	Product_size::find($sizeID);
	$description=$sizeinfo->description;
	$eventType=$sizeinfo->eventType;
	$unpaidOption=$sizeinfo->unpaidOption;
?>
<body class="hold-transition skin-green sidebar-mini">
    <section class="content-header top_header_content">

	<form name="frm_product_addeditprice" id="frm_product_addeditprice" action="{{ url('/') }}/adminarea/product_price/updateprice" method="post">
		<input type="hidden" name="priceID" id="priceID" value="{{$priceID}}" />
        <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
		<input type="hidden" class="form-control" name="itemID" id="itemID" value="{{$itemID}}">
		<input type="hidden" class="form-control" name="categoryID" id="categoryID" value="{{$categoryID}}">
        <input type="hidden" class="form-control" name="sizeID" id="sizeID" value="{{$sizeID}}">

    	@if(Session::has('productsizeError'))<div class="alert-danger">{{ Session::get('productsizeError') }}</div>@endif
        <div class="form-group">
            <label for="price" class="col-xs-4 control-label">Event Option Type</label>
            <div class="col-xs-6">
                <select id="eventType"  onchange="fun_eventType(this.value);" name="eventType" class="form-control productSizeID">
                    <option value="1" @if($eventType==1) selected @endif>Paid</option>
                    <option value="2" @if($eventType==2) selected @endif>UnPaid</option>
                </select>
            </div>
        </div>
		<div class="form-group">
        	<label for="price" class="col-xs-4 control-label">Event Options  <span class="mandatory_field">*</span></label>
            <div class="col-xs-6">
            	<input type="text" class="form-control" name="sizeName" style="border-radius:0px;" maxlength="100" id="sizeName" placeholder="Size Name" value="{{$sizeName}}">
            </div>
            <?php /*?><div class="col-xs-6">
            	<select id="productSizeID" name="sizeID" class="form-control productSizeID" style="border-radius:0px;">
                    <option value="">Product Size</option>
                    @if($prodcutSizeRecordCount > 0)
                            @foreach($qGetProductSizeData as $resultProductSizeData)
                                <option value="{{$resultProductSizeData->sizeID}}" @if($resultProductSizeData->sizeID==$sizeID)selected="selected" @endif>{{$resultProductSizeData->sizeName}}</option>
                            @endforeach
                    @endif
                </select>
            </div><?php */?>
        </div>
        <script>fun_eventType({{$eventType}})</script>
        <div class="form-group">
        	<label for="price" class="col-xs-4 control-label">Quantity <span class="mandatory_field">*</span></label>
            <div class="col-xs-6">
            	<input type="text" class="form-control" name="quantity"  style="border-radius:0px;" maxlength="100" id="quantity" placeholder="Quantity" value="{{$quantity}}">
            </div>
        </div>
        
		<div class="form-group" id="paidOption"  @if($eventType==2) style="display:none" @endif>
        	<label for="price" class="col-xs-4 control-label">Price  <span class="mandatory_field">*</span></label>
            <div class="col-xs-6">
            	<input type="text" class="form-control" name="price" style="border-radius:0px;" maxlength="100" id="price" placeholder="Price" value="{{$price}}">
                <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="For unlimited please leave field blank">
            </div>
        </div>
    
        <div class="form-group" id="unpaidOption" @if($eventType==1) style="display:none" @endif>
            <label for="price" class="col-xs-4 control-label">Event Option Type</label>
            <div class="col-xs-6">
                <select id="unpaidOption" name="unpaidOption" class="form-control productSizeID">
                    <option value="1" @if($unpaidOption==1) selected @endif>Email</option>
                    <option value="2" @if($unpaidOption==2) selected @endif>Facebook</option>
                    <option value="3" @if($unpaidOption==3) selected @endif>Tweeter</option>
                    <option value="3" @if($unpaidOption==4) selected @endif>Instagram</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="price" class="col-xs-4 control-label">Description</label>
            <div class="col-md-6" style="padding-top: 25px;">
                <textarea id="description" name="description">{{$description}}</textarea>
            </div>
        </div>
       <div class="form-group">
        	<label class="check_btn col-xs-4 control-label"></label>
            <div class="col-xs-6">
                <input style="margin-right:10px; margin-top:0px;" type="checkbox" value="1" @if($isActive==1) checked='checked' @endif name="isActive">IsActive?</label>
            </div>
        </div>
		<div class="form-group">
            <div class="col-xs-12 button">
                <button type="submit" name="save"  class="btn btn-primary waves-effect waves-light m-l-5">Submit</button>
                <button  class="btn btn-Warning waves-effect waves-light m-l-5" type="button" onclick="window.parent.tb_remove()">Back</button>
            </div>
        </div>
	</form>
  </section>
</body>
<script>
function fun_eventType(type)
{
	if(type==2)
	{
	   $("#paidOption").hide( "slow" );
	   $("#unpaidOption").show( "slow" );
	}else{
	   $("#paidOption").show( "slow" );
	   $("#unpaidOption").hide( "slow" );
	}
	
}
</script>