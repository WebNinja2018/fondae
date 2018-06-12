@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_role_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					name: 
					{
						message: 'Please Enter Role Name',
						validators: 
							{
								notEmpty:{message: 'Please enter role name.'},
							}
					},
					
				}
    });
});
</script>
@endif
<script type="text/javascript">

function fun_back()
{
	var frmobj=window.document.frm_role_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_role_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_role_list.action="{{ url('/') }}/adminarea/role/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_role_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/role/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/role/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_role_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/role/index";
	frmobj.submit();
}

function fun_edit(roleID)
{
	var frmobj=window.document.frm_role_list;
	frmobj.roleID.value=roleID;
	frmobj.action="{{ url('/') }}/adminarea/role/addeditrole";
	frmobj.submit();
}

function fun_roleSearch(srach_firstName)
{
	var frmobj=window.document.frm_role_list;
	frmobj.srach_name.value=srach_firstName;
	frmobj.action="{{ url('/') }}/adminarea/role/index";
	frmobj.submit();
}

function fun_single_delete(roleID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/role/singledelete",
			data: "roleID=" + roleID,
			success: function(total){
			$("#ID_"+roleID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(roleID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/role/singlestatus",
		data: "roleID=" + roleID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+roleID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+roleID).html("Active");
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
		frmobj=window.document.frm_role_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_role_list.action="{{ url('/') }}/adminarea/role/index";
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
			  frmobj=window.document.frm_role_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_role_list.action="{{ url('/') }}/adminarea/role/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/

</script>