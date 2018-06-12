<?php $testimonialsID=Input::get('testimonialsID')?Input::get('testimonialsID'):'0'; ?>
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_testimonials_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					clientName: 
					{
						message: 'Please enter client name.',
						validators: 
							{
								notEmpty:{message: 'Please enter client name.'},
							}
					},
					designation: 
					{
						message: 'Please enter designation.',
						validators: 
							{
								notEmpty:{message: 'Please enter designation.'},
							}
					},
					displayOrder: 
					{
						message: 'Please enter display order.',
						validators: 
							{
								
								notEmpty:{message: 'Please enter display order.'},
								digits: {message: 'Display order can only contain numeric value.'},
								
							}
					},
					details: 
					{
						message: 'Please enter details.',
						validators: 
							{
								notEmpty:{message: 'Please enter details.'},
							}
					},
					<?php if($testimonialsID==0){ ?>
					testimonial_img: {
						validators: {
							notEmpty:{message: 'Please select testimonial Image.'},
							file: {
							extension: 'jpeg,jpg,png,gif',
							type: 'image/jpeg,image/png,image/gif',
							message: 'The selected file is not valid.'
							}
						}
					},	
					<?php } ?>	
				}
    });
});

function fun_changeOrder()
{
	var frmobj=window.document.frm_testimonials_list;
	frmobj.action="{{ url('/') }}/adminarea/testimonials/testimonialsorder";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_testimonials_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_testimonials_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_testimonials_list.action="{{ url('/') }}/adminarea/testimonials/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_testimonials_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/testimonials/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/testimonials/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_testimonials_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/testimonials/index";
	frmobj.submit();
}

function fun_edit(testimonialsID)
{
	var frmobj=window.document.frm_testimonials_list;
	frmobj.testimonialsID.value=testimonialsID;
	frmobj.action="{{ url('/') }}/adminarea/testimonials/addedittestimonials";
	frmobj.submit();
}

function fun_testimonialsSearch(srach_name)
{
	var frmobj=window.document.frm_testimonials_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/testimonials/index";
	frmobj.submit();
}

function fun_single_delete(testimonialsID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/testimonials/singledelete",
			data: "testimonialsID=" + testimonialsID,
			success: function(total){
			$("#ID_"+testimonialsID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(testimonialsID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/testimonials/singlestatus",
		data: "testimonialsID=" + testimonialsID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+testimonialsID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+testimonialsID).html("Active");
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
		frmobj=window.document.frm_testimonials_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_testimonials_list.action="{{ url('/') }}/adminarea/testimonials/index";
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
			  frmobj=window.document.frm_testimonials_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_testimonials_list.action="{{ url('/') }}/adminarea/testimonials/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(testimonialsID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/testimonials/imagedelete",
			data: "testimonialsID=" + testimonialsID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>
 