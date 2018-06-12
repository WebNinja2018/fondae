@include('adminarea.product.product_size.product_size-js')
@if(Session::has('productPriceError'))<div class="alert-danger">{{ Session::get('productPriceError') }}</div>@endif

<?php
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
}
?>
<form name="frm_prodcut_price" id="frm_prodcut_price"  action="{{url('/')}}/adminarea/product_price/saveproductprice" method="post" class="form-horizontal" enctype="multipart/form-data" >
    <input type="hidden" class="form-control" name="isBack" id="isBack" value="">
	<input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
    <input type="hidden" name="sizeID" value="{{$sizeID}}" id="sizeID" />
	<input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
        <div class="box">
           <div class="property_add">
                <div class="box-body">	
                    <div class="form-group">
                        <div class="col-md-12">&nbsp;</div>
                        <div style="float:right;">
                            <a class="" href="javascript:fun_addeditsize(0,{{$productID}});" title="Add Size"><b>Add Product Options</b></a> <?php /*?>&nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addeditsize(0,0);" title="Add Genral Size"><b>Add General Size</b></a> &nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addedititeam(0,{{$productID}});" title="Add Genral Product Iteam"><b>Add product Item</b></a> &nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addedititeam(0,0);" title="Add Genral Size"><b>Add General Item</b></a><?php */?>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Options</label>
                            </div>
                            <?php /*?><div class="col-md-2">
                                <label>Item</label>
                            </div><?php */?>
                            <div class="col-md-3">
                                <label>Avalible Quntity</label>
                            </div>
                             @if($priceCategoryRecordCount > 0)
                                @foreach($qGetPriceCategory as $resultPriceCategory)
                                    <div class="col-md-3">
                                        <label>{{$resultPriceCategory->categoryname}}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="priceID[]" maxlength="10" id="priceID" value="0" title="Price">
                            <div class="col-md-3">
                                <select id="productSizeID22"  onchange="fun_getItem(this.value,0,{{$productID}});" name="sizeID[]" class="form-control productSizeID">
                                    <option value="">Product Options</option>
                                    <?php if($prodcutSizeRecordCount > 0){
                                            foreach($qGetProductSizeData as $resultProductSizeData){?>
                                                <option value="{{$resultProductSizeData->sizeID}}">{{$resultProductSizeData->sizeName}}</option>
                                    <?php }
                                            }?>
                                </select>
                            </div>
                            <?php /*?><div class="col-md-2">
                                   <select id="productItemID[]" name="itemID[]" class="form-control productItemID">
                                    <option value="">Product Item</option>
                                    @if($prodcutIteamRecordCount > 0)
                                        @foreach($qGetProductIteamData as $resultProductIteamData)
                                            <option value="{{$resultProductIteamData->itemID}}">{{$resultProductIteamData->itemName}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div><?php */?>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="quantity[]" maxlength="10" id="quantity" placeholder="Product Quantity" value="" title="Quantity">
                            </div>
                            @if($priceCategoryRecordCount > 0)
                                @foreach($qGetPriceCategory as $resultPriceCategory)
                                    <div class="col-md-3">
                                        <input type="hidden" class="form-control" name="categoryID[]" maxlength="10" id="categoryID" value="{{$resultPriceCategory->categoryID}}" title="Price">
                                        <input type="text" class="form-control getCategoryForValidation" name="categoryID_{{$resultPriceCategory->categoryID}}[]" maxlength="10" id="categoryID" placeholder="Product Price" value="" title="Price">
                                    </div>
                                @endforeach
                            @endif
                            <button type="button" class="btn btn-default addButton" style="margin-left:10px;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="form-group hide removeRow" id="optionTemplate">
                            <input type="hidden" class="form-control" name="priceID[]" maxlength="10" id="priceID" value="0" title="Price">
                            <div class="col-md-3">
                                <select id="productSizeID" name="sizeID[]"  onchange="fun_getItem(this.value,0,{{$productID}});" class="form-control productSizeID">
                                    <option value="">Product Options</option>
                                    <?php if($prodcutSizeRecordCount > 0){
                                                foreach($qGetProductSizeData as $resultProductSizeData){?>
                                                    <option value="{{$resultProductSizeData->sizeID}}">{{$resultProductSizeData->sizeName}}</option>
                                            <?php }
                                    }?>
                                </select>
                            </div>
                            <?php /*?><div class="col-md-2">
                                   <select id="productItemID1" name="itemID[]" class="form-control productItemID">
                                    <option value="">Product Item</option>
                                    <?php if($prodcutIteamRecordCount > 0){
                                            foreach($qGetProductIteamData as $resultProductIteamData){?>
                                            <option value="{{$resultProductIteamData->itemID}}">{{$resultProductIteamData->itemName}}</option>
                                        <?php }
                                    } ?>
                                </select>
                            </div><?php */?>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="quantity[]" maxlength="10" id="quantity" placeholder="Product Quantity" value="" title="Quantity">
                            </div>
                            @if($priceCategoryRecordCount > 0)
                                @foreach($qGetPriceCategory as $resultPriceCategory)
                                    <div class="col-md-3">
                                        <input type="text" class="form-control getCategoryForValidation" name="categoryID_{{$resultPriceCategory->categoryID}}[]" maxlength="10" id="categoryID" placeholder="Product Price" value="" title="Price">
                                    </div>
                                @endforeach
                            @endif
                            <button type="button" class="btn btn-default removeButton" style="margin-left:10px;"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
           </div>
           <div class="box-footer">
                <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                     <div class="col-xs-12 col-md-12 col-sm-12">                     
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_size(1)">Save And Back</button>
                        <button type="submit" class="btn btn-warning waves-effect waves-light" name="save">Submit</button>
                        <button class="btn btn-primary waves-effect waves-light m-l-5" type="button" onclick="fun_back_size(0)">Back</button>
                    </div>
                </div>
            </div>
           <div class="box-body">	
                <div class="col-md-12" role="main">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Product Options</th>
                                    <?php /*?><th width="20%">Product Item</th><?php */?>
                                    <th>Product Price</th>
                                    <th>Product Quantity</th>
                                    <?php /*?><th width="20">Product Category</th><?php */?>
                                    <th>Price Status</th>
                            	</tr>
                            </thead>
                            <tbody>
                            @if($prodcutPriceRecordCount > 0)
                                @foreach($qGetProductPriceData as $resultProductPriceData)
                                    <tr id="priceID_{{$resultProductPriceData->priceID}}">
                                        <td>
                                            <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete_price({{$resultProductPriceData->priceID}});" title="Delete"></a>&nbsp;&nbsp;
                                            <a class="glyphicon glyphicon-pencil" href="javascript:fun_edit({{$resultProductPriceData->priceID}},{{$resultProductPriceData->priceProductID}});" title="Delete"></a>
                                        </td>
                                        <td>{{$resultProductPriceData->sizeName}}</td>
                                       <?php /*?> <td>{{$resultProductPriceData->itemName}}</td><?php */?>
                                        <td>{{Config::get('config.priceSign','$')}} {{$resultProductPriceData->price}}</td>
                                        <td>{{$resultProductPriceData->quantity}}</td>
                                        <?php /*?><td>{{$resultProductPriceData->categoryname}}</td><?php */?>
                                        <td>
                                            <a href="javascript:fun_single_status_price({{$resultProductPriceData->priceID}});">
                                                <span id="status_{{$resultProductPriceData->priceID}}">
                                                    @if($resultProductPriceData->priceStatus==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                           		 @else
                                    <tr>
                                        <td colspan="7" style="text-align:center;">Recoed Not Found</td>
                                    </tr>
                            	@endif
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>
       </div>
</form>