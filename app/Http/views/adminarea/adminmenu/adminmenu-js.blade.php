@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_adminmenu_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
						menuName: 
                        {
                            message: 'Please Enter menu name',
                            validators: 
                                {
                                    notEmpty:{message: 'Please enter menu name.'},
                                }
                        },
						
						menuLink: 
                        {
                            message: 'Please Enter menu link',
                            validators: 
                                {
                                    notEmpty:{message: 'Please enter menu link.'},
                                }
                        },
						
						displayOrder: 
                        {
                            message: 'Please Enter display order',
                            validators: 
                                {
                                    notEmpty:{message: 'Please enter display order.'},
                                }
                        }
						
                    }
    });
});
</script>
@endif
<script type="text/javascript">
function fun_back()
{
	var frmobj=window.document.frm_adminmenu_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function reorder_rows(current_id,parent_id,direction)
{
	$.ajax({
			type: "POST",
			url: "{{url('/')}}/adminarea/adminmenu/getReorder",
			data: "menuID="+current_id+"&menuParentID="+parent_id+"&direction="+direction,
			success: function(total){
			   window.document.location.reload();
			}
		});
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_adminmenu_list;
	if(perpage>0)
	{
		frmobj.action="{{url('/')}}/adminarea/adminmenu/index/"+perpage;
	}
	else
	{
		frmobj.action="{{url('/')}}/adminarea/adminmenu/index/";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_adminmenu_list;
	frmobj.srach_menuName.value='';
	frmobj.srch_status.value='';
	frmobj.srch_menuParentID.value='';
	frmobj.action="{{url('/')}}/adminarea/adminmenu/index";
	frmobj.submit();
}

function fun_edit(menuID)
{
	var frmobj=window.document.frm_adminmenu_list;
	frmobj.menuID.value=menuID;
	frmobj.action="{{url('/')}}/adminarea/adminmenu/addeditadminmenu";
	frmobj.submit();
}

function fun_userSearch(srach_adminmenuTitle)
{
	var frmobj=window.document.frm_adminmenu_list;
	frmobj.srach_adminmenuTitle.value=srach_adminmenuTitle;
	frmobj.action="{{url('/')}}/adminarea/adminmenu/index";
	frmobj.submit();
}

function fun_single_delete(menuID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{url('/')}}/adminarea/adminmenu/singledelete",
			data: "menuID=" + menuID,
			success: function(total){
			$("#ID_"+menuID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(menuID)
{
	$.ajax({
		type: "POST",
		url: "{{url('/')}}/adminarea/adminmenu/singlestatus",
		data: "menuID=" + menuID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+menuID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+menuID).html("Active");
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
		frmobj=window.document.frm_adminmenu_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_adminmenu_list.action="{{url('/')}}/adminarea/adminmenu/index";
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
			  frmobj=window.document.frm_adminmenu_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_adminmenu_list.action="{{url('/')}}/adminarea/adminmenu/index";
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