<?php /*?><script src="<?php echo base_url();?>js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('fe_url');?>js/jquery.validate.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>bootstrap/css/bootstrap.min_blue.css" rel="stylesheet"><?php */?>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
	$.validator.setDefaults({
			submitHandler2: function() { window.document.frm_product_quantityaddedit.submit()}
		});
		$().ready(function() {
			
		$("#frm_product_item").validate({
			ignore: ":hidden",
			rules: {
					sizeID:{required: true},
					itemName:{required: true}
				
			},
			messages: {
					sizeID:{required: "Please select size."},
					itemName: { required: "Please enter Iteam Name."}
				}
			});
		});
</script>
@endif
<style>
	body { background:none; }
	.control-label { margin:5px 0 0 0; }
	.col-sm-offset-2 col-sm-10 { margin:0 20px; 0 0px; }
	.button { margin:20px 0 0 0; text-align:center; } 
	.button input[type="submit"], .button .btn-default { float:none; display:inline-block;}
	.alert-danger{ background:none; margin:0px 2px 10px 120px; font-weight:bold;}
	.form-group{ float:left; width:100%;}
	.error{color:#F00; font-size:10px;}
</style>  

<?php
$itemID=Input::get('itemID')?Input::get('itemID'):'0';
if($itemID==0){
	$itemID=old('itemID')?old('itemID'):'';	
}
$itemName=old('itemName')?old('itemName'):'';
$sizeID=old('sizeID')?old('sizeID'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
}

if(isset($itemID) && $itemID > 0)
{
	if(isset($getsingleItem))
	{
		$itemID=$getsingleItem->itemID;
		$itemName=$getsingleItem->itemName;
		$productID=$getsingleItem->productID;
		$sizeID=$getsingleItem->sizeID;
	}
}
?>

	<form name="frm_product_item" id="frm_product_item" action="{{ url('/') }}/adminarea/product_item/saveitem" method="post">
    <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
    <input type="hidden" name="itemID" id="itemID" value="{{$itemID}}" />
	<input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
	@if(Session::has('flash_message'))
    	<div class="alert-danger">{{ Session::get('flash_message') }}</div>
    @endif
    
        <div class="form-group">
            <label for="price" class="col-xs-5 control-label">Product Size*</label>
            <div class="col-xs-6">
              <select id="sizeID" name="sizeID" class="form-control">
                    <option value="">= = = Product Size = = =</option>
                    @if($sizeRecordCount > 0)
						@foreach($qGetSizeData as $resultSizeData)
							<option value="{{$resultSizeData->sizeID}}" @if($sizeID==$resultSizeData->sizeID) selected="selected" @endif>{{$resultSizeData->sizeName}}</option>	
						@endforeach
					@endif
              </select>
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="col-xs-5 control-label">Product Item*</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="itemName" maxlength="100" id="itemName" placeholder="Product Item" value="{{$itemName}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 button">
                <button type="submit" name="save" class="btn btn-default btn-primary">Submit</button>
                <button class="btn btn-default" type="button" onclick="window.parent.tb_remove()">Close</button>
            </div>
        </div>
	</form>