@include('adminarea.product.product_size.product_size-js')
@if(Session::has('productPriceError'))<div class="alert-danger">{{ Session::get('productPriceError') }}</div>@endif

<?php
$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
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

function fun_golive()
{
    var frmobj=window.document.frm_golive;
    frmobj.action= "{{url('/')}}/adminarea/product_price/saveproductgolive";
    frmobj.submit();
}
</script>


<form name="frm_golive" id="frm_golive"  action="{{url('/')}}/adminarea/product_price/saveproductgolive" method="post" class="form-horizontal" enctype="multipart/form-data" >
    <input type="hidden" class="form-control" name="isBack" id="isBack" value="">
    <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
    <input type="hidden" name="sizeID" value="{{$sizeID}}" id="sizeID" />
    <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >    
</form>



<form name="frm_prodcut_price" id="frm_prodcut_price"  action="{{url('/')}}/adminarea/product_price/saveproductprice" method="post" class="form-horizontal" enctype="multipart/form-data" >
    <input type="hidden" class="form-control" name="isBack" id="isBack" value="">
    <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
    <input type="hidden" name="sizeID" value="{{$sizeID}}" id="sizeID" />
    <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
    
    <?php if($tab==2){ $tab=3; }?>
    <input type="hidden" name="tab" id="tab" value="{{$tab}}" >
        <div class="box">
           <div class="property_add">
                <div class="box-body">  
                    <div class="form-group">
                        <div class="col-md-12">&nbsp;</div>
                        <div style="float:right;">
                            <?php /*?><a class="" href="javascript:fun_addeditsize(0,{{$productID}});" title="Add Size"><b>Add Event Options</b></a> &nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addeditsize(0,0);" title="Add Genral Size"><b>Add General Size</b></a> &nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addedititeam(0,{{$productID}});" title="Add Genral Product Iteam"><b>Add product Item</b></a> &nbsp;|&nbsp;
                            <a class="" href="javascript:fun_addedititeam(0,0);" title="Add Genral Size"><b>Add General Item</b></a><?php */?>
                        </div>

                        <div class="col-md-12">&nbsp;</div>
                        <div class="form-group">
                           
                            <div class="col-md-3">
                                <label>Reward Option Type</label><br>
                                 <SPAN style="font-size: 11px; ">(one event reward is mandatory to go live)</SPAN>
                            </div>
                            <div class="col-md-6">
                                <select id="eventType"  onchange="fun_eventType(this.value);" name="eventType[]" class="form-control" required>
                                    <option value="1">Paid</option>
                                    
                                    <option value="3">Event</option>
                                </select>
                            </div>
                        </div>
<!--option value="2">Social Media</option-->
                        <div class="form-group" id="unpaidOption" style="display:none">
                            <div class="col-md-3">
                                <label>Social platforms</label>
                            </div>
                            <div class="col-md-6">
                                <select id="unpaidOption" onchange="fun_socialtype(this.value);" name="unpaidOption[]" class="form-control productSizeID" >
                                    <option value="1">Email</option>
                                    <option value="2">Facebook</option>
                                    <option value="3">Twitter</option>
                                    <option value="4">Instagram</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id='socialid' style="display: none;">
                            <div class="col-md-3">
                                <label><span id='socialname'></span></label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="socialid[]" maxlength="100" id="sizeName" placeholder="" value="">
                            </div>
                           
                           
                        </div>


                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Reward options Name</label>  <span class="mandatory_field">*</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="sizeName[]" maxlength="100" id="sizeName" placeholder="Reward options Title" value="" required >
                            </div>
                            <input type="hidden" class="form-control" name="priceID[]" maxlength="10" id="priceID" value="0" title="Price">
                           
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Availability  Quantity</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="quantity[]" maxlength="10" id="quantity" placeholder="Availability Quantity" value="" title="Avalible Quantity" >
                            </div>
                            <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="20" title="For unlimited please leave field blank">
                        </div>
                        
                        <div class="form-group" id="paidOption">
                             @if($priceCategoryRecordCount > 0)
                                @foreach($qGetPriceCategory as $resultPriceCategory)
                                    <div class="col-md-3">
                                        <label>{{$resultPriceCategory->categoryname}}</label> <span class="mandatory_field">*</span>
                                    </div>
                                @endforeach
                            @endif
                            
                            @if($priceCategoryRecordCount > 0)
                                @foreach($qGetPriceCategory as $resultPriceCategory)
                                    <div class="col-md-6">
                                        <input type="hidden" class="form-control" name="categoryID[]" maxlength="10" id="categoryID" value="{{$resultPriceCategory->categoryID}}" title="Price">
                                        <input type="text" class="form-control getCategoryForValidation" name="categoryID_{{$resultPriceCategory->categoryID}}[]" maxlength="10" id="categoryID" placeholder="Donation Amount" value="" title="Price">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label>Description</label>
                            </div>
                            <div class="col-md-6">
                                <textarea id="description" name="description[]" required></textarea>
                            </div>
                        </div>
                        <div class="form-group hide removeRow" id="optionTemplate">
                            <input type="hidden" class="form-control" name="priceID[]" maxlength="10" id="priceID" value="0" title="Price">
                            <div class="col-md-3">
                                <select id="productSizeID" name="sizeID[]"  onchange="fun_getItem(this.value,0,{{$productID}});" class="form-control productSizeID">
                                    <option value="">Event Options</option>
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
                        @if($isDraft==1)
                            <input type="hidden" name="isDraft" id="isDraft" value="1" >
                           @if($tab==4)
                                <!--button type="submit" class="btn btn-primary waves-effect waves-light m-l-5"  onclick="fun_back_size(1);" >Save As Draft</button-->
                                <!--input type="button" class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="log reward and continue" onClick="fun_golive();" style="width:196px"-->
                                    @if( $count_event>0)
                                     <input type="submit" class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="Go Live" onClick="fun_golive();" style="width:196px" id='golive' > 
                                     @else
                                        <input class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="Go Live"  style="width:196px"  onclick="alert('one event reward is mandatory to go live')" type="button">
                                     @endif

                                 <input type="hidden" name="isDraft" id="isDraft" value="0"  >
                                     <input type="submit" class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="log reward and continue" onclick="fun_back_size(1);" style="width:196px">

                                    
                            @else
                                <input class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="Go Live"  style="width:196px"  onclick="alert('1 Event type reward is mandatory for Go Live')" type="button">
                                <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5"  onclick="fun_back_size(1);" >Continue</button>
                            @endif
                        @else
                            <input type="hidden" name="isDraft" id="isDraft" value="0" >
                            <input class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="Go Live"  style="width:196px"  onclick="alert('All created Event already live. create new reward for go live again')" type="button">
                             <input type="submit" class="btn btn-warning waves-effect waves-light m-l-5" name="save" value="log reward and continue" onclick="fun_back_size(1);" style="width:196px">
                        @endif
                        <?php /*?><button class="btn btn-primary waves-effect waves-light m-l-5" type="button" onclick="fun_back_size(0)">Back</button><?php */?>
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
                                    <th>Reward options</th>
                                    <?php /*?><th width="20%">Product Item</th><?php */?>
                                    <th>Reward Type</th>
                                    <th>Donation Amount</th>
                                    <th>Reward Unpaid Option</th>
                                    <th>Reward Quantity</th>
                                    <?php /*?><th width="20">Product Category</th><?php */?>
                                    <th>Price Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php //dd($qGetProductPriceData);?>
                            @if($prodcutPriceRecordCount > 0)
                                @foreach($qGetProductPriceData as $resultProductPriceData)
                                    <tr id="priceID_{{$resultProductPriceData->priceID}}">
                                        <td>
                                            <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete_price({{$resultProductPriceData->priceID}});" title="Delete"></a>&nbsp;&nbsp;
                                            <a class="glyphicon glyphicon-pencil" href="javascript:fun_edit({{$resultProductPriceData->priceID}},{{$resultProductPriceData->priceProductID}});" title="Delete"></a>
                                        </td>
                                        <td>{{$resultProductPriceData->sizeName}}
                                        </td>
                                       <?php /*?> <td>{{$resultProductPriceData->itemName}}</td><?php */?>
                                       <td>
                                        @if($resultProductPriceData->eventType==1)Paid @elseif($resultProductPriceData->eventType==3)Event @else Social Media @endif
                                       </td>
                                       <td>@if($resultProductPriceData->eventType!=2){{Config::get('config.priceSign','$')}} {{$resultProductPriceData->price}}@else - @endif
                                       </td>
                                       <td>@if($resultProductPriceData->eventType==2)
                                                @if($resultProductPriceData->unpaidOption==1)
                                                    Email
                                                @elseif($resultProductPriceData->unpaidOption==2)
                                                    Facebook
                                                @elseif($resultProductPriceData->unpaidOption==3)
                                                    Twitter
                                                @elseif($resultProductPriceData->unpaidOption==4)    
                                                    instagram
                                                @endif
                                           @else - @endif</td>
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
                                        <td colspan="7" style="text-align:center;">Record Not Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>
       </div>
</form>