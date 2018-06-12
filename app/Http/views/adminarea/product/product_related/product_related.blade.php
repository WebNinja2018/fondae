<?php use App\Http\Models\Category_model;
$category= new Category_model;  ?>
<script type="text/javascript">
function re_fun_subcategory(parentID,checked,obj)
	{
		
		var categoryID = $('#categoryID').val();
		//var productID = $('#productID').val();
		var productID = $('#productID').val();
		
		if(categoryID!=parentID && parentID>0)
	{
		$('#parentCategoryID').val(parentID);
		var dropdown = $('#dropdown').val();
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				$( "#parentCategoryID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/product/re_subcategory1",
		   data: "parentCategoryID="+parentID+"&obj="+obj+"&checked="+checked+"&productID="+productID,
		   success: function(result){
			   if(result)
			   {
				  // alert(result);
				   var tmp = Number(obj)+Number(1);
				   $('#dropdown').val(tmp);
				  // $( "#sortable" ).append( result );
				   document.getElementById('sortable').innerHTML=result;
				   
			   }
		   }
		 });
	}
	
	else if(parentID == 0 && (obj==1 || obj.length==0))
	{
		var dropdown = $('#dropdown').val();
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				$( "#parentCategoryID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		var tmp2 = Number(obj)-Number(1);
		$('#dropdown').val(tmp2);
		
		parentID = $('#parentCategoryID_'+tmp2).val();
		
		$('#parentCategoryID').val(parentID);
	}
	}
	
	function re_fun_subsubcategoryLast(subsubcategoryID)
	{
		
		var categoryID = $('#parentCategoryID_1').val();
		
		var subcategoryID = $('#parentCategoryID_1').val();
		var productID = $('#productID').val();
		
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/product/re_subsubcategoryLast",
		   data: "categoryID="+categoryID+"&subcategoryID="+subcategoryID+"&subsubcategoryID="+subsubcategoryID+"&productID="+productID,
		   success: function(result){
			 
			   if(result)
			   {
				   document.getElementById('sortable').innerHTML=result;
			   }
		   }
		 });
	}
	
	function funAddRecomand(obj)
	{
		
		var categoryID = $('#parentCategoryID_1').val();
		var subcategoryID = $('#re_subcategoryid').val();
		
		if( obj.checked==true )
		{
			var isadd=1;
		}
		else
		{
			var isadd=0;
		}
		var productID = $('#productID').val();
		
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/product/addeditRecomand",
		   data: "categoryID="+categoryID+"&subcategoryID="+subcategoryID+"&productID="+productID+"&rec_productID="+obj.value+"&isadd="+isadd,
		   success: function(result){
			   if(result)
			   {
				   var arrayresult = result.split('^^');
				   document.getElementById('sortable').innerHTML=arrayresult[0];
				   document.getElementById('sortable1').innerHTML=arrayresult[1];
			   }
		   }
		 });
	}
</script>
<?php
$categoryID=Input::get('categoryID')?Input::get('categoryID'):'0';
if($categoryID==0){
	$categoryID=old('categoryID')?old('categoryID'):'';	
}?>
 <div class="col-md-12">
    <div class="form-group">
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
    <table cellpadding="3" cellspacing="0" width="100%" BORDER="0" class="grid">
        <tr class="">
          <td class="boldtext" valign="top" style="width:40%;">
              <table cellpadding="3" cellspacing="0" border="0" width="100%" >
                  <tr>
                  <td><div class="form-group">
                            <label for="categoryname" class="col-sm-4 control-label" style="width:36%;">Parent Category</label>
                            <div class="col-md-8" id="parentDropdowns2" style="width:60%;">
                                <select id="parentCategoryID_1" class="form-control" onchange="re_fun_subcategory(this.value,0,1)">
                                        <option value="">Select</option>
                                    <?php $getMainCategory = $category->getByMainCategory(3); ?>
									@foreach($getMainCategory as $MainCategory)
                                        <option value="{{$MainCategory->categoryID}}">{{$MainCategory->categoryname}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                 </td>

<?php /*?>                  <td><div class="inputtext"><b>Category<b></div></td>
                  <td>
                    <div class="inputpart" style="margin:0 0 5px 0;">
                      <select name="re_srch_cat" id="re_srch_cat" onchange="re_fun_subcategory(this.value);" class="form-control">
                          <option value="">Select</option>
                          <?php $re_getMainCat = $category->getByMainCategory(3);?>
                          @foreach($re_getMainCat as $re_resMainCat)
                          <option value="{{$re_resMainCat->categoryID}}" @if(Input::get('re_srch_cat')==$re_resMainCat->categoryID) "selected='selected'" @endif>{{$re_resMainCat->categoryname}}</option>
                          @endforeach
                      </select>
                    </div>
                  </td>
                  </tr><?php */?>
                 <?php /*?> <tr>
                     <td><div class="inputtext"><b>Sub Category</b></div></td>
                     <td>
                          <div class="inputpart">
                            <div id="re_subcatdropdown">
                               <select name="re_subcategoryid" id="re_subcategoryid" onchange="re_fun_subsubcategory(this.value)" class="form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                          </div>
                     </td>
                  </tr><?php */?>
                  <tr>
                     <td colspan="2">
                        <div id="sortable" style="float:left;width:70%; font-weight:bold; margin:5px 105px; 0 0;">
                        </div>
                     </td>
                  </tr>
              </table>
          </td>
          <td style="width:60%; padding:0 10px;" valign="top">
               <div class="col-md-8">
               <div class="row">
              	<h4 style="margin:0 0 10px;0">Related Product Items</h4>
                </div>
               </div>
              <div id="sortable1" style="float:left;width:100%;border:2px dotted #ccc;">
                  @foreach($recommandProduct['data'] as $data)
                         <div style="width:70%;float:left;margin:10px 0;border:1px dotted #ccc;">
                            <div style="width:auto;float:left;margin-right:5px;">
                                <input type="checkbox" value="{{ @$data->productID}}" onclick="funAddRecomand(this)" checked="checked" />
                            </div>
                            
                               @if(strlen($data->mainimage)>0)
                                   <img src="{{ url('/') }}/upload/product/images/{{$data->productID}}/{{$data->mainimage}}" width="60" height="60" style="float:left;" />
                               @else
                                   <img src="{{ url('/') }}/images/no-images.png" width="60" height="60" style="float:left;" />
                               @endif
                            <div style="width:100%;float:left; margin:0 10px 0 10px;">
                                 ProductName : {{@$data->productName}}<br />
                                 ItemNumber : {{@$data->itemnumber}}
                            </div>
                         </div>
                 @endforeach
              </div>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="dotline" ></td>
        </tr>
    </table>	
    </div>
   </div>

<script>
  @if($categoryID != NULL && $categoryID >0)
	  @for($k=0 $k < count($str_array); $k++)
		  <?php $j=$k+1; ?>
		  @if(isset($str_array[$j])) $checked = $str_array[$j] @else $checked = 0 @endif
		  setTimeout(function(){
				  re_fun_subcategory({{$str_array[$k]}},{{$checked}},{{$j}});
		  },500);
	  @endfor
  @endif
</script>