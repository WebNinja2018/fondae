@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_customer_addedit').bootstrapValidator({
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
	frmobj=window.document.frm_customer_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_customer_list.action="{{ url('/') }}/adminarea/customer/index";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_customer_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_customer_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/customer/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/customer/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_customer_list;
	frmobj.srach_firstName.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/customer/index";
	frmobj.submit();
}

function fun_edit(customerID)
{
	var frmobj=window.document.frm_customer_list;
	frmobj.customerID.value=customerID;
	frmobj.action="{{ url('/') }}/adminarea/customer/addeditcustomer";
	frmobj.submit();
}

function fun_customerSearch(srach_firstName)
{
	var frmobj=window.document.frm_customer_list;
	frmobj.srach_firstName.value=srach_firstName;
	frmobj.action="{{ url('/') }}/adminarea/customer/index";
	frmobj.submit();
}

function fun_single_delete(customerID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/customer/singledelete",
			data: "customerID=" + customerID,
			success: function(total){
			$("#ID_"+customerID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(customerID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/customer/singlestatus",
		data: "customerID=" + customerID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+customerID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+customerID).html("Active");
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
		frmobj=window.document.frm_customer_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_customer_list.action="{{ url('/') }}/adminarea/customer/index";
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
		  frmobj=window.document.frm_customer_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_customer_list.action="{{ url('/') }}/adminarea/customer/index";
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