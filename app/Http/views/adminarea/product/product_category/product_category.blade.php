<?php use App\Http\Models\Product;
 use App\Http\Models\Category_model;
$product= new Product;  
$category= new Category_model;  
if(isset($qGetCheckedCategory)){
	 $array_qGetCheckedCategory='';
	 foreach($qGetCheckedCategory as $qGetCheckedCategory)
	 {
		$array_qGetCheckedCategory[] = $qGetCheckedCategory->categoryID;
	 }
	$array = array($qGetCheckedCategory);
}

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
}?>
<form name="frm_product_category" id="frm_product_category"  action="{{ url('/') }}/adminarea/product/saveproductcategory" method="post" class="form-horizontal" enctype="multipart/form-data" >
    <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}"> 
    <input type="hidden" class="form-control" name="productName" id="productName" value="{{$productName}}">
    <input type="hidden" name="backtocategory" id="backtocategory" value="" />
    <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
<div class="box">
    <div class="property_add">
        <div id="parentDropdowns">
            <div class="addunit_forms">
                <div class="box-body">
                    <ul class="mainul">
                    	@foreach($qGetAllCategory as $categoryList)
                            <li style="padding:10px 0px 0 0px;">
                                <input id="categoryID" class="parent" type="checkbox" name="categoryname[]" value="{{$categoryList->categoryID}}" 
                                    @if(count($qGetCheckedCategory)>0) 
                                        @for($i=0;$i < count($array_qGetCheckedCategory);$i++) 
                                            @if($array_qGetCheckedCategory[$i]==@$categoryList->categoryID) 
                                                checked="checked"  
                                            @endif 
                                        @endfor 
                                    @endif />
								<p class="maincategory">{{$categoryList->categoryname}}</p>

								<?php 
								$categoryData=array(
										'isActive'=>1,
										'parentCategoryID'=>$categoryList->categoryID
								); 
								//$subresult= $category->getByAttributesQuery($categoryData);
								$subresult['data']= $category->where($categoryData)->get();
								$subresult['recordCount']=count($subresult['data']);
								?>
                                @if($subresult['recordCount']>0)
                                    <ul  style="padding:0 0 0 15px;">
                                        @foreach($subresult['data'] as $subCategoryList)
                                        	<li style="padding:10px 0px 0 0px;">
                                                <input class="child" type="checkbox" name="categoryname[]" value="{{$subCategoryList->categoryID}}" 
                                                @if(count($qGetCheckedCategory)>0) 
                                                    @for($i=0;$i < count($array_qGetCheckedCategory);$i++)
                                                        @if($array_qGetCheckedCategory[$i]==@$subCategoryList->categoryID) 
                                                            checked="checked"
                                                        @endif
                                                    @endfor
                                                @endif/>{{$subCategoryList->categoryname}}
                                                <?php 
												$categoryData=array(
														'isActive'=>1,
														'parentCategoryID'=>$subCategoryList->categoryID
												); 
												//$getSubSubCategory=$category->getByAttributesQuery($categoryData);
												$getSubSubCategory['data']= $category->where($categoryData)->get();
												$getSubSubCategory['recordCount']=count($getSubSubCategory['data']);
												?>
												@if($getSubSubCategory['recordCount']>0)
                                                    <ul>
                                                        @foreach($getSubSubCategory['data'] as $subsubCategory)
                                                            <li style="margin:0 0 0 40px;">
                                                                <input class="child" type="checkbox" name="categoryname[]" value="{{$subsubCategory->categoryID}}" 
                                                                @if(count($qGetCheckedCategory)>0) 
                                                                    @for($i=0;$i < count($array_qGetCheckedCategory);$i++)
                                                                        @if($array_qGetCheckedCategory[$i]==@$subsubCategory->categoryID)
                                                                                checked="checked"
                                                                        @endif
                                                                    @endfor
                                                                @endif/>{{$subsubCategory->categoryname}}
																<?php 
																$categoryData=array(
																		'isActive'=>1,
																		'parentCategoryID'=>$subsubCategory->categoryID
																); 
																//$getFourLEvelCategory=$category->getByAttributesQuery($categoryData);
																$getFourLEvelCategory['data']= $category->where($categoryData)->get();
																$getFourLEvelCategory['recordCount']=count($getFourLEvelCategory['data']);
																?>
                                                                @if($getFourLEvelCategory['recordCount']>0)
                                                                    <ul>
                                                                        @foreach($getFourLEvelCategory['data'] as $FourLEvelCategory)
                                                                            <li>
                                                                                <input class="child" type="checkbox" name="categoryname[]" value="{{$FourLEvelCategory->categoryID}}" 
                                                                                @if(count($qGetCheckedCategory)>0) 
                                                                                    @for($i=0;$i < count($array_qGetCheckedCategory);$i++)
                                                                                        @if($array_qGetCheckedCategory[$i]==@$FourLEvelCategory->categoryID)
                                                                                            checked="checked" 
                                                                                        @endif
                                                                                    @endfor
                                                                                @endif/>{{$FourLEvelCategory->categoryname}}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>   
            </div> 
        </div>
    </div>
    <div class="box-footer">
        <div class="col-xs-12 col-md-12 col-sm-12 text-left">
             <div class="col-xs-12 col-md-12 col-sm-12">
                <button type="submit"  name="saveback" onclick="fun_backCategory(1);" class="btn btn-default btn-primary">Submit And Back</button>
                <button type="submit" class="btn btn-default btn-primary">Submit</button>
                <button class="btn btn-default" type="button" onclick="fun_back()">Back</button>
        	</div>
        </div>
    </div>
</div>
</form>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_product_category').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					'categoryname[]': 
					{
						message: 'Please Select Product Category',
						validators: 
							{
								notEmpty:{message: 'Please Select Product Category.'},
							}
					}
						
				}
    });
});
</script>
@endif
<script type="text/javascript">
	function fun_backCategory(backtocategory)
	{
		var frmobj=window.document.frm_product_category;
		var backtocategory=document.getElementById('backtocategory').value=1;
		frmobj.action="{{ url('/') }}/adminarea/product/saveproductcategory";
		document.getElementById('frm_product_category').submit();
	}
</script>