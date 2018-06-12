<link rel="stylesheet" href="{{ url('/components/css/formValidation.css') }}"/>
<script src="{{url('/components/js/formValidation.js') }}" type="text/javascript"></script>
<script src="{{url('/components/js/framework/bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
		$('#frm_prodcut_price').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'sizeID[]': {
                    message: 'Please select Options.',
						validators: 
						{
							notEmpty:{message: 'Please select Options.'}
						}
                },
				'itemID[]': {
							message: 'Please select Iteam.',
							validators: 
							{
								notEmpty:{message: 'Please select Iteam.'}
							}
                }
				//,'quantity[]': {
//                  		message: 'Please enter Quantity',
//						validators: 
//							{
//								notEmpty:{message: 'Please enter Quantity.'}
//							}
//                }
				 <?php if($priceCategoryRecordCount > 0){
					foreach($qGetPriceCategory as $resultPriceCategory){?>
						,'categoryID_{{$resultPriceCategory->categoryID}}[]': {
									message: 'Please enter Price',
									validators: 
										{
											notEmpty:{message: 'Please enter Price.'}
										}
							}
					<?php }
				}?>
            }
        })
		// Add button click handler
        .on('click', '.addButton', function() {
            var categoryID = $(".getCategoryForValidation").attr("name");
			var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $sizeID   = $clone.find('[name="sizeID[]"]');
				$itemID   = $clone.find('[name="itemID[]"]');
				$hours   = $clone.find('[name="hours[]"]');
				$hourly_rate   = $clone.find('[name="hourly_rate[]"]');
				$quantity   = $clone.find('[name="quantity[]"]');
				$categoryID   = $clone.find('[name="'+categoryID+'"]');
			
				

            // Add new field
            $('#frm_prodcut_price').formValidation('addField', $sizeID);
			$('#frm_prodcut_price').formValidation('addField', $itemID);
			$('#frm_prodcut_price').formValidation('addField', $hours);
			$('#frm_prodcut_price').formValidation('addField', $hourly_rate);
			$('#frm_prodcut_price').formValidation('addField', $quantity);
			$('#frm_prodcut_price').formValidation('addField', $categoryID);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var categoryID = $(".getCategoryForValidation").attr("name");
		    var $row    = $(this).parents('.removeRow'),
               	$sizeID   = $row.find('[name="sizeID[]"]');
				$itemID   = $row.find('[name="itemID[]"]');
				$hours   = $row.find('[name="hours[]"]');
				$hourly_rate   = $row.find('[name="hourly_rate[]"]');
				$quantity   = $row.find('[name="quantity[]"]');
				$categoryID   = $row.find('[name="'+categoryID+'"]');

            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#frm_prodcut_price').formValidation('removeField', $sizeID);
			$('#frm_prodcut_price').formValidation('removeField', $itemID);
			$('#frm_prodcut_price').formValidation('removeField', $hours);
			$('#frm_prodcut_price').formValidation('removeField', $hourly_rate);
			$('#frm_prodcut_price').formValidation('removeField', $quantity);
			$('#frm_prodcut_price').formValidation('removeField', $categoryID);
        })
});
	
function fun_addeditsize(sizeID,productID){

tb_show("<h4 style='margin:0px 6px;'>Add Event Options</h4>","{{ url('/') }}/adminarea/product_size/addeditproductsize?sizeID="+sizeID+"&productID="+productID+"&popup=true&KeepThis=true&height=360&width=580&TB_iframe=true");
}
function fun_addedititeam(itemID,productID){
	tb_show("<h4 style='margin:0px 6px;'>Add Event Iteam</h4>","{{ url('/') }}/adminarea/product_item/addeditproductitem?itemID="+itemID+"&productID="+productID+"&popup=true&KeepThis=true&height=360&width=580&TB_iframe=true");
}
function fun_edit(priceID,productID){
	tb_show("<h4 style='margin:0px 6px;'>Edit Event Price</h4>","{{ url('/') }}/adminarea/product_price/addeditproductprice?priceID="+priceID+"&productID="+productID+"&popup=true&KeepThis=true&height=400&width=650&TB_iframe=true");
}

function fun_single_delete_price(priceID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/product_price/singledelete",
			data: "priceID=" + priceID,
			success: function(total){
			$("#priceID_"+priceID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status_price(priceID)
{
	$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/product_price/singlestatus",
			data: "priceID=" + priceID,
			success: function(result){
				if(result == 0)
				{
					$('#status_'+priceID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+priceID).html("Active");
				}
			}
		});
}
function load_dropdown(dropDownType,ID,Name){
	tb_remove();
	if(dropDownType == 1){   
		// popup close and select leatest size in dropdown.
		$('.productSizeID').append( '<option value="'+ID+'" selected="selected">'+Name+'</option>' );
	}
	if(dropDownType == 2){   
		// popup close and select leatest item in dropdown.
		$('.productItemID').append( '<option value="'+ID+'" selected="selected">'+Name+'</option>' );
	}
}

function fun_getItem(sizeID,priceID,productID){
	$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/product_item/getsizeitem",
			 data: "sizeID="+sizeID+"&productID="+productID,
			success: function(result){
				if(priceID > 0){
					$("#productItemID_"+priceID).html(result);
				}else{
					var sizeIDLength = ($('select[name="sizeID[]"]').length);
					var itemLength = $('select[name^="itemID[]"]');
					var sizeLength = $('select[name^="sizeID[]"]');
					for (var i = 0; i < sizeIDLength-1; i++) {
						var selectedSizeID = sizeLength.eq(i).val();
						if(selectedSizeID == sizeID){
							itemLength.eq(i).html(result);
						}
					}
				}
			}
	 });
}
function fun_back_size(isBack)
{
	var frmobj=window.document.frm_prodcut_price;
	if(isBack==0){	
		frmobj.action= frmobj.redirects_to.value;
		frmobj.submit();
	}else{
		
		frmobj.isBack.value=isBack;
		frmobj.action="{{ url('/') }}/adminarea/product_price/saveproductprice";
		//frmobj.submit();
	}
	
}

function save_as_default(isBack)
{
	var frmobj=window.document.frm_prodcut_price;
	
		frmobj.isBack.value=isBack;
		frmobj.action="{{ url('/') }}/adminarea/product_price/saveasdefault";
		//frmobj.submit();
	
	
}

function fun_eventType(type)
{
	if(type==2)
	{
	   $("#paidOption").hide( "slow" );
	   $("#unpaidOption").show( "slow" );

	   fun_socialtype();
	}
	else
	{
	   $("#paidOption").show( "slow" );
	   $("#unpaidOption").hide( "slow" );
	   $("#unpaidOption").hide( "slow" );
	   $("#socialid").hide( "slow" );
	}
}

function fun_socialtype(type)
{
	if(type==1)
	{
		document.getElementById("socialname").innerHTML = "Email Address";

	}
	else if(type==2)
	{
		document.getElementById("socialname").innerHTML = "Facebook URl";
	  
	}
	else if(type==3)
	{
		document.getElementById("socialname").innerHTML = "Twitter ID";
	 
	}
	else if(type==4)
	{
		document.getElementById("socialname").innerHTML = "Instagram ID";
	 
	}
	else
	{
	   document.getElementById("socialname").innerHTML = "Email ID";
	}


	 $("#socialid").show( "slow" );
	
}
</script>