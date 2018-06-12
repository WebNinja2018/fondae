<?php $linksID=Input::get('linksID')?Input::get('linksID'):'0'; ?>

@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
	$('#frm_links_addedit').bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
					'categoryID[]': 
					{
						message: 'Please Select Category',
						validators: 
							{
								notEmpty:{message: 'Please select category.'},
							}
					},
					name: 
					{
						message: 'Please Enter Name',
						validators: 
							{
								notEmpty:{message: 'Please enter name.'},
							}
					},
					
					linksImage: {
						message: 'Please Select Image',
						validators: 
							{
								<?php if($linksID==0) {?>
									notEmpty:{message: 'Please Select Image.'},
								<?php } ?>
								file: 
								{
									extension: 'jpeg,jpg,png,gif',
									type: 'image/jpeg,image/png,image/gif',
									message: 'The selected file is not valid.'
								}
							}
					},
					
					displayOrder: 
					{
						message: 'Please Enter Display Order',
						validators: 
							{
								notEmpty:{message: 'Please enter display order.'},
							}
					},
					weblink: {
						validators: {
							//uri: {
//								message: 'The website address is not valid'
//							}
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
	var frmobj=window.document.frm_links_list;
	frmobj.action="{{ url('/') }}/adminarea/links/linksorder";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_links_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_links_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_links_list.action="{{ url('/') }}/adminarea/links/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_links_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/links/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/links/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_links_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/links/index";
	frmobj.submit();
}

function fun_edit(linksID)
{
	var frmobj=window.document.frm_links_list;
	frmobj.linksID.value=linksID;
	frmobj.action="{{ url('/') }}/adminarea/links/addeditlinks";
	frmobj.submit();
}

function fun_linksSearch(srach_name)
{
	var frmobj=window.document.frm_links_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/links/index";
	frmobj.submit();
}

function fun_single_delete(linksID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/links/singledelete",
			data: "linksID=" + linksID,
			success: function(total){
			$("#ID_"+linksID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(linksID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/links/singlestatus",
		data: "linksID=" + linksID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+linksID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+linksID).html("Active");
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
		frmobj=window.document.frm_links_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_links_list.action="{{ url('/') }}/adminarea/links/index";
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
			  frmobj=window.document.frm_links_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_links_list.action="{{ url('/') }}/adminarea/links/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(linksID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/links/imagedelete",
			data: "linksID=" + linksID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}

</script>
 