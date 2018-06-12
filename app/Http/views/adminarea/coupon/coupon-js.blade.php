<?php $couponID=Input::get('couponID')?Input::get('couponID'):'0'; ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#frm_coupon_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					couponName: 
					{
						message: 'Please enter coupon name.',
						validators: 
							{
								notEmpty:{message: 'Please enter coupon name.'},
							}
					},
					couponCode: 
					{
						message: 'Please Enter Coupon Code.',
						validators: 
							{
								notEmpty:{message: 'Please enter coupon code.'},
							}
					},
					discountRate: 
					{
						message: 'Please Enter Discount Rate.',
						validators: 
							{
								notEmpty:{message: 'Please enter quantity.'},
							}
					},
					useLimit: 
					{
						message: 'Please Enter Use Limit.',
						validators: 
							{
								notEmpty:{message: 'Please enter use limit.'},
							}
					},
					
				}
    });
});

function fun_changeOrder()
{
	var frmobj=window.document.frm_coupon_list;
	frmobj.action="{{ url('/') }}/adminarea/coupon/couponorder";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_coupon_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_coupon_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_coupon_list.action="{{ url('/') }}/adminarea/coupon/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_coupon_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/coupon/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/coupon/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_coupon_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/coupon/index";
	frmobj.submit();
}

function fun_edit(couponID)
{
	var frmobj=window.document.frm_coupon_list;
	frmobj.couponID.value=couponID;
	frmobj.action="{{ url('/') }}/adminarea/coupon/addeditcoupon";
	frmobj.submit();
}

function fun_couponSearch(srach_name)
{
	var frmobj=window.document.frm_coupon_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/coupon/index";
	frmobj.submit();
}

function fun_single_delete(couponID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/coupon/singledelete",
			data: "couponID=" + couponID,
			success: function(total){
			$("#ID_"+couponID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(couponID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/coupon/singlestatus",
		data: "couponID=" + couponID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+couponID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+couponID).html("Active");
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
		frmobj=window.document.frm_coupon_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_coupon_list.action="{{ url('/') }}/adminarea/coupon/index";
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
			  frmobj=window.document.frm_coupon_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_coupon_list.action="{{ url('/') }}/adminarea/coupon/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(couponID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/coupon/imagedelete",
			data: "couponID=" + couponID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>
 