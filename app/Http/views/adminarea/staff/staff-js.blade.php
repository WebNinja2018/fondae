<?php $staffID=Input::get('staffID')?Input::get('staffID'):'0';?>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_staff_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					//'categoryID[]': {
//						validators: {
//							notEmpty: {
//								message: 'The category field is required.'
//							}
//						}
//					},

					firstname: 
					{
						message: 'Please Enter First Name',
						validators: 
							{
								notEmpty:{message: 'Please enter first name.'},
							}
					},
					
					lastname: 
					{
						message: 'Please Enter Last Name',
						validators: 
							{
								notEmpty:{message: 'Please enter last name.'},
							}
					},
					
					position: 
					{
						message: 'Please Enter Position',
						validators: 
							{
								notEmpty:{message: 'Please enter position.'},
							}
					},
					email: 
					{
						message: 'Please Enter email',
						validators: 
							{
								notEmpty:{message: 'Please enter email.'},
								emailAddress:{message: 'Please enter valid email.'},
							}
					},
					@if($staffID==0)
					imgFileName_staff:
					{
                		validators: 
						{
							notEmpty:{message: 'Please select Image.'},
							file: 
							{
								extension: 'jpeg,jpg,png,gif',
								type: 'image/jpeg,image/png,image/gif',
								message: 'The selected file is not valid.'
                    		}
                		}
            		},
					@endif
					telephone: 
					{
						message: 'Please Enter telephone',
						validators: 
							{
								notEmpty:{message: 'Please Enter telephone'},
								numeric:{message: 'Please enter only numeric value.'},
							}
					},
					alt_telephone: 
					{
						message: 'Please Enter telephone',
						validators: 
							{
								numeric:{message: 'Please enter only numeric value.'},
							}
					},
					bio: 
					{
						message: 'Please Enter bio',
						validators: 
							{
								notEmpty:{message: 'Please enter bio.'},
							}
					}
			}
    });
});
</script>
@endif
<script type="text/javascript">
function fun_changeOrder()
{
	var frmobj=window.document.frm_staff_list;
	frmobj.action="{{ url('/') }}/adminarea/staff/stafforder";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_staff_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_staff_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_staff_list.action="{{ url('/') }}/adminarea/staff/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_staff_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/staff/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/staff/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_staff_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/staff/index";
	frmobj.submit();
}

function fun_edit(staffID)
{
	var frmobj=window.document.frm_staff_list;
	frmobj.staffID.value=staffID;
	frmobj.action="{{ url('/') }}/adminarea/staff/addeditstaff";
	frmobj.submit();
}

function fun_staffSearch(srach_name)
{
	var frmobj=window.document.frm_staff_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/staff/index";
	frmobj.submit();
}

function fun_single_delete(staffID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/staff/singledelete",
			data: "staffID=" + staffID,
			success: function(total){
			$("#ID_"+staffID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(staffID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/staff/singlestatus",
		data: "staffID=" + staffID,
		success: function(result){
			
			if(result == 0)
			{
				$('#status_'+staffID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+staffID).html("Active");
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
		frmobj=window.document.frm_staff_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_staff_list.action="{{ url('/') }}/adminarea/staff/index";
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
			  frmobj=window.document.frm_staff_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_staff_list.action="{{ url('/') }}/adminarea/staff/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(staffID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/staff/imagedelete",
			data: "staffID=" + staffID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>