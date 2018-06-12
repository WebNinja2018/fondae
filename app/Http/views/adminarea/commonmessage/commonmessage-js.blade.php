<?php $commonmessageID=Input::get('commonmessageID')?Input::get('commonmessageID'):'0';?>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_global_setting_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					variableName: 
					{
						message: 'Please enter Common Message name.',
						validators: 
							{
								notEmpty:{message: 'Please enter Common Message name.'},
							}
					},
					<?php if($commonmessageID==0){?>
					description: 
					{
						message: 'Please enter Description.',
						validators: 
							{
								notEmpty:{message: 'Please enter Description.'},
							}
					},
					<?php }?>
					
				}
    });
});
</script>
@endif
<script type="text/javascript">
function fun_back()
{
	var frmobj=window.document.frm_commonmessage_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_search(perpage)
{
	
	var frmobj=window.document.frm_commonmessage_list;
	frmobj.submit();
}
function fun_file()
{
	var frmobj=window.document.frm_commonmessage_list;
	frmobj.action="{{ url('/') }}/adminarea/commonmessage/createFile";
	frmobj.submit();
}
function fun_reset()
{
	var frmobj=window.document.frm_commonmessage_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/commonmessage/index";
	frmobj.submit();
}

function fun_edit(commonmessageID)
{
	var frmobj=window.document.frm_commonmessage_list;
	frmobj.commonmessageID.value=commonmessageID;
	frmobj.action="{{ url('/') }}/adminarea/commonmessage/addeditcommonmessage";
	frmobj.submit();
}

function fun_commonmessageSearch(srach_name)
{
	var frmobj=window.document.frm_commonmessage_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/commonmessage/index";
	frmobj.submit();
}
function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_commonmessage_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_commonmessage_list.action="{{ url('/') }}/adminarea/commonmessage/index";
	frmobj.submit();
}

function fun_single_delete(commonmessageID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/commonmessage/singledelete",
			data: "commonmessageID=" + commonmessageID,
			success: function(total){
			$("#ID_"+commonmessageID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(commonmessageID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/commonmessage/singlestatus",
		data: "commonmessageID=" + commonmessageID,
		success: function(result){
			//alert(result);
			if(result == 0)
			{
				$('#status_'+commonmessageID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+commonmessageID).html("Active");
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
		frmobj=window.document.frm_commonmessage_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_commonmessage_list.action="{{ url('/') }}/adminarea/commonmessage/index";
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
		  frmobj=window.document.frm_commonmessage_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_commonmessage_list.action="{{ url('/') }}/adminarea/commonmessage/index";
		  frmobj.submit();
	  }
  }
  else
  {
	alert('Please select atleast one record.');
  }
}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(commonmessageID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/commonmessage/imagedelete",
			data: "commonmessageID=" + commonmessageID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}

/************SELECT TEXT BOX AND TEXTAREA**********************/
function funMessageType(type)
{
	if(type==1)
	{
		$('#globalvalue1').show('fast');
		$('#globalvalue2').hide('fast');
		//$('#globalvalue3').hide('fast');
	}
	else if(type==2)
	{
		$('#globalvalue2').show('fast');
		$('#globalvalue1').hide('fast');
		$('#globalvalue3').hide('fast');
	}
	else{
		$('#globalvalue3').show('fast');
		$('#globalvalue1').hide('fast');
		$('#globalvalue2').hide('fast');
	}
}
/************SELECT TEXT BOX AND TEXTAREA**********************/
</script>
 