  <link rel="stylesheet" href="{{ url('/components/css/skins/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ url('/components/css/style.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ url('/components/css/responsive.css') }}" >
  <link rel="stylesheet" href="{{ url('/components/css/bootstrap.min.css') }}">
  <script src="{{url('/components/js/app.min.js') }}" type="text/javascript"></script>


<script src="{{url('/components/js/jquery-1.11.3.min.js') }}" type="text/javascript"></script>
<script src="{{url('/components/js/jquery.validate.js') }}" type="text/javascript"></script>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
	$.validator.setDefaults({
			submitHandler12: function() { window.document.frm_product_addeditsize.submit()}
		});
		$().ready(function() {
			
		$("#frm_product_addeditsize").validate({
			ignore: ":hidden",
			rules: {
				sizeName:{required: true},
				sizeNumber:{required: true}	
				
			},
			messages: {
				sizeName: { required: "Please enter Option"},
				sizeNumber: { required: "Please enter Size Number"}
				
				}
			});
		});

</script>
@endif
<style>
#TB_title { height:40px; color:#fff;}
</style>
<?php
	$sizeID=Input::get('sizeID')?Input::get('sizeID'):'0';
	if($sizeID==0){
		$sizeID=old('sizeID')?old('sizeID'):'';	
	}
	$sizeName=old('sizeName')?old('sizeName'):'';
	$sizeNumber=old('sizeNumber')?old('sizeNumber'):'';
	
    $productID=Input::get('productID')?Input::get('productID'):'0';
	if($productID==0){
		$productID=old('productID')?old('productID'):'';	
	}

	$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
	if(strlen($redirects_to)==0){
	$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
	}
	if(isset($sizeID) && $sizeID > 0)
	{
		if(isset($getSizeData))
		{
			$sizeID=$getSizeData->itemID;
			$sizeName=$getSizeData->itemName;
			$sizeNumber=$getSizeData->sizeNumber;
			$productID=$getSizeData->productID;
		}
	}	
?>
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
<body class="hold-transition skin-green sidebar-mini">
    <section class="content-header top_header_content">
	<form name="frm_product_addeditsize" id="frm_product_addeditsize" action="{{ url('/') }}/adminarea/product_size/savesize" method="post">
        <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
        <input type="hidden" name="sizeID" id="sizeID" value="{{$sizeID}}" />
    	@if(Session::has('productsizeError'))<div class="alert-danger">{{ Session::get('productsizeError') }}</div>@endif
        <div class="box">
            <div class="property_add">
            	<div class="box-body">
                    <div class="form-group">
                        <label for="price" class="col-sm-2 col-md-2 col-xs-4 control-label">Product Options <span class="mandatory_field">*</span></label>
                        <div class="col-sm-6 col-md-6 col-xs-8">
                            <input type="text" class="form-control" style="border-radius:0px;" name="sizeName" maxlength="100" id="sizeName" placeholder="Product Options" value="{{$sizeName}}">
                        </div>
                    </div>
                 </div>
            </div>
			<div class="box-footer">
                <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                     <div class="col-xs-12 col-md-12 col-sm-12">
                        <button type="submit" name="save" class="btn btn-primary waves-effect waves-light m-l-5">Submit</button>
                        <button class="btn btn-warning waves-effect waves-light" type="button" onclick="window.parent.tb_remove()">Back</button>
            		</div>
                </div>
            </div>
		</form>
  </section>
</body>