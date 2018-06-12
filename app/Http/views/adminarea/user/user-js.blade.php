@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_user_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					roleID: 
					{
						message: 'Please select role',
						validators: 
							{
								notEmpty:{message: 'Please select role.'},
							}
					},
					firstName: 
					{
						message: 'Please enter first name',
						validators: 
							{
								notEmpty:{message: 'Please enter first name.'},
							}
					},
					
					lastName: 
					{
						message: 'Please enter last name',
						validators: 
							{
								notEmpty:{message: 'Please enter last name.'},
							}
					},
					
					email: 
					{
						message: 'Please enter email',
						validators: 
							{
								notEmpty:{message: 'Please enter email.'},
								emailAddress: {message: 'Please enter valid email.'},
							}
					},
					password: 
					{
						message: 'Please enter password',
						validators: 
							{
								notEmpty:{message: 'Please enter password.'},
							}
					},
				}
    });
});
</script>
@endif
<script type="text/javascript">
function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_user_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_user_list.action="{{ url('/') }}/adminarea/user/index";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_user_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_user_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/user/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/user/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_user_list;
	frmobj.srach_firstName.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/user/index";
	frmobj.submit();
}

function fun_edit(userID)
{
	var frmobj=window.document.frm_user_list;
	frmobj.userID.value=userID;
	frmobj.action="{{ url('/') }}/adminarea/user/addedituser";
	frmobj.submit();
}

function fun_userSearch(srach_firstName)
{
	var frmobj=window.document.frm_user_list;
	frmobj.srach_firstName.value=srach_firstName;
	frmobj.action="{{ url('/') }}/adminarea/user/index";
	frmobj.submit();
}

function fun_single_delete(userID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/user/singledelete",
			data: "userID=" + userID,
			success: function(total){
			$("#ID_"+userID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(userID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/user/singlestatus",
		data: "userID=" + userID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+userID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+userID).html("Active");
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
	alert(count);
	if(count > 0)
	{
		frmobj=window.document.frm_user_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_user_list.action="{{ url('/') }}/adminarea/user/index";
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
		  frmobj=window.document.frm_user_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_user_list.action="{{ url('/') }}/adminarea/user/index";
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