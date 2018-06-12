<?php $globalsettingID=Input::get('globalsettingID')?Input::get('globalsettingID'):'0';?>
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
					globalsettingname: 
					{
						message: 'Please enter Global Setting name.',
						validators: 
							{
								notEmpty:{message: 'Please enter Global Setting name.'},
							}
					},
					<?php if($globalsettingID==0){?>
					globalsettingvalue: 
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
	var frmobj=window.document.frm_globalsetting_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_search(perpage)
{
	
	var frmobj=window.document.frm_globalsetting_list;
	frmobj.submit();
}
function fun_file()
{
	var frmobj=window.document.frm_globalsetting_list;
	frmobj.action="{{ url('/') }}/adminarea/globalsetting/createFile";
	frmobj.submit();
}
function fun_reset()
{
	var frmobj=window.document.frm_globalsetting_list;
	frmobj.srach_name.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/globalsetting/index";
	frmobj.submit();
}

function fun_edit(globalsettingID)
{
	var frmobj=window.document.frm_globalsetting_list;
	frmobj.globalsettingID.value=globalsettingID;
	frmobj.action="{{ url('/') }}/adminarea/globalsetting/addeditglobalsetting";
	frmobj.submit();
}

function fun_globalsettingSearch(srach_name)
{
	var frmobj=window.document.frm_globalsetting_list;
	frmobj.srach_name.value=srach_name;
	frmobj.action="{{ url('/') }}/adminarea/globalsetting/index";
	frmobj.submit();
}

function fun_single_delete(globalsettingID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/globalsetting/singledelete",
			data: "globalsettingID=" + globalsettingID,
			success: function(total){
			$("#ID_"+globalsettingID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(globalsettingID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/globalsetting/singlestatus",
		data: "globalsettingID=" + globalsettingID,
		success: function(result){
			//alert(result);
			if(result == 0)
			{
				$('#status_'+globalsettingID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+globalsettingID).html("Active");
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
		frmobj=window.document.frm_globalsetting_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_globalsetting_list.action="{{ url('/') }}/adminarea/globalsetting/index";
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
		  frmobj=window.document.frm_globalsetting_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_globalsetting_list.action="{{ url('/') }}/adminarea/globalsetting/index";
		  frmobj.submit();
	  }
  }
  else
  {
	alert('Please select atleast one record.');
  }
}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(globalsettingID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/globalsetting/imagedelete",
			data: "globalsettingID=" + globalsettingID+"&imagename="+imagename,
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
 