<?php 
$productID=Input::get('productID')?Input::get('productID'):'0';

if(!isset($CategorytypeID)){
	$CategorytypeID=Config::get('config.productCategorytypeID','3');
}

if($CategorytypeID==Config::get('config.productCategorytypeID','3')){
	$actionPath="index";
}else{
	$actionPath="package";
}
?>
<script type="text/javascript">
/*Here open popup of view all product detail*/
function fun_viewproductdetail(productID)
{
	tb_show("","{{ url('/') }}/adminarea/product/viewproductdetail?d=&c=&productID="+productID+"&popup=true&KeepThis=true&height=500&width=1000&TB_iframe=true");
}
</script>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_product_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					categoryID: 
					{
						message: 'Please Select Category',
						validators: 
							{
								notEmpty:{message: 'Please select category.'},
							}
					},
					staffID: 
					{
						message: 'Please Select Staff',
						validators: 
							{
								notEmpty:{message: 'Please select Staff.'},
							}
					},
					productName: 
					{
						message: 'Please Enter Product Name',
						validators: 
							{
								notEmpty:{message: 'Please enter product name.'},
							}
					},
					//itemnumber: 
					//{
					//	message: 'Please Enter Itemnumber',
					//	validators: 
					//		{
					//			notEmpty:{message: 'Please enter itemnumber.'},
					//		}
					//},
					//availabilityStatus: 
					//{
					//	message: 'Please select availability status',
					//	validators: 
					//		{
					//			notEmpty:{message: 'Please select availability status.'},
					//		}
					//},
					  
					productDate: 
					{
						message: 'Please select Product Date.',
						validators: 
							{
								notEmpty:{message: 'Please select Product Date.'},
								//date: {
//											max: 'productExpiredDate'
//									  }
							}
					},	
					productExpiredDate: 
					{
						message: 'Please select Product Expired Date.',
						validators: 
							{
								notEmpty:{message: 'Please select Product Expired Date.'},
								//date: {
//											min: 'productDate'
//									  }
							}
					},	
					
				}
    });
	
});
</script>
@endif
<script type="text/javascript">
function fun_changeOrder()
{
	var frmobj=window.document.frm_product_list;
	frmobj.action="{{ url('/') }}/adminarea/product/productorder";
	frmobj.submit();
}
function fun_back_ganaral(isBack)
{
	var frmobj=window.document.frm_product_addedit;
	if(isBack==0){	
		frmobj.action= frmobj.redirects_to.value;
		frmobj.submit();
	}else{
		frmobj.isBack.value=isBack;
		frmobj.action="{{ url('/') }}/adminarea/product/saveproduct";
	}
	frmobj.submit();
}
function fun_back_mainimage(isBack)
{
	var frmobj=window.document.frm_news_mainImage;
	
	if(isBack==0){	
		frmobj.action= frmobj.redirects_to.value;
		frmobj.submit();
	}else{
		frmobj.isBack.value=isBack;
		frmobj.action="{{ url('/') }}/adminarea/product/saveMainImage";
	}
	frmobj.submit();
}
function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_product_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_product_list.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
	frmobj.submit();
}


function fun_search(perpage)
{
	
	var frmobj=window.document.frm_product_list;
	frmobj.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
	frmobj.submit();
}
function fun_reset()
{
	var frmobj=window.document.frm_product_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
	frmobj.submit();
}

function fun_edit(productID)
{
	var frmobj=window.document.frm_product_list;
	frmobj.productID.value=productID;
	frmobj.action="{{ url('/') }}/adminarea/product/addeditproduct";
	frmobj.submit();
}
function fun_productSearch(srach_name)
{
	var frmobj=window.document.frm_product_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
	frmobj.submit();
}
function fun_single_delete(productID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/product/singledelete",
			data: "productID=" + productID,
			success: function(total){
			$("#ID_"+productID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(productID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/product/singlestatus",
		data: "productID=" + productID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+productID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+productID).html("Active");
			}
		}
	});
}
/******************* CHECK ALL CHECKBOX *****************/

jQuery(document).ready(function($)
{
	$('#checkall').click(function()
	{
		$(':checkbox').each(function()
		{
			if(this.checked)
			{
				this.checked = false;
			}
			else
			{
				this.checked = true;
			}
		});
		return false;
	}); 
}); 
/***************** DATE PICKER ******************/

/***************** MULTIPLE ACTIVE ******************/
function fun_active_inactive(status)
{
	var count = $(":checkbox:checked").length;
	if(count > 0)
	{
		frmobj=window.document.frm_product_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_product_list.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
		frmobj.submit();
	}
	else
	{
		alert('Please select atleast one record.');
	}
}	
/****************** MULTIPLE INAVTIVE ***************/

/****************** MULTIPLE DELETE *************/
	function fun_multipleDelete()
	{
	  var count = $(":checkbox:checked").length;
	  if(count > 0)
	  {
		  var status = confirm("Are you sure want to delete this record?");
		  if(status==true)
		  {
			  frmobj=window.document.frm_product_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_product_list.action="{{ url('/') }}/adminarea/product/{{$actionPath}}";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
	
function funGetChild(parentID,checked,obj) 
{
	
	var productID = $('#productID').val();
	
	if(productID!=parentID && parentID>0)
	{
		$('#parentID').val(parentID);
		var dropdown = $('#dropdown').val();
		
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				$( "#parentID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/product/getChildPages",
		   data: "parentID="+parentID+"&obj="+obj+"&checked="+checked,
		   success: function(result){
			   if(result)
			   {
				   var tmp = Number(obj)+Number(1);
				   $('#dropdown').val(tmp);
				   $( "#parentDropdowns" ).append( result );
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
				$( "#parentID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		var tmp2 = Number(obj)-Number(1);
		$('#dropdown').val(tmp2);
		
		parentID = $('#parentID_'+tmp2).val();
		
		$('#parentID').val(parentID);
	}
}
/***************** MULTIPLE ACTIVE ******************/
	$(document).ready(function(){
	$('#longDescription_content').redactor({
		imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
		fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
	});
	
	$('#shortDescription_content').redactor({
		imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
		fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
	});
	
	$('#keywordDescription_content').redactor({
		imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
		fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
	});

	function fun_single_status_review(reviewID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/product/singlereviewstatus",
			data: "reviewID=" + reviewID,
			success: function(result){
				if(result == 0)
				{
					$('#status_'+reviewID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+reviewID).html("Active");
				}
			}
		});
	}
	function fun_single_delete_review(reviewID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/product/singlereviewdelete",
				data: "reviewID=" + reviewID,
				success: function(total){ 
				$("#ID_"+reviewID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}

	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#rowTab a[href="' + activeTab + '"]').tab('show');
    }
	
});
</script>