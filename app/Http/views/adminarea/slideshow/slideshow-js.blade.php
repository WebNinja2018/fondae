<?php $slideshowID=Input::get('slideshowID')?Input::get('slideshowID'):'0';?>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_slideshow_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		//excluded: ':disabled', For Hidden Fields Validation.
		fields: {
				slideshowTitle: 
				{
					message: 'Please enter Slideshow Title',
					validators: 
						{
							notEmpty:{message: 'Please enter Slideshow Title.'},
						}
				},
				caption1: 
				{
					message: 'Please enter caption 1',
					validators: 
						{
							notEmpty:{message: 'Please enter caption 1.'},
						}
				},
				<?php if($slideshowID==0){ ?>
				imagesName: {
					validators: {
						notEmpty:{message: 'Please select Images for slideshow.'},
						file: {
						extension: 'jpeg,jpg,png,gif',
						type: 'image/jpeg,image/png,image/gif',
						message: 'The selected file is not valid.'
						}
					}
				},	
				<?php } ?>
				displayOrder: 
				{
					message: 'Please enter display order',
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
function fun_changeOrder()
{
	var frmobj=window.document.frm_slideshow_list;
	frmobj.action="{{ url('/') }}/adminarea/slideshow/slideshoworder";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_slideshow_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_slideshow_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_slideshow_list.action="{{ url('/') }}/adminarea/slideshow/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_slideshow_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/slideshow/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/slideshow/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_slideshow_list;
	frmobj.srach_title.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/slideshow/index";
	frmobj.submit();
}

function fun_edit(slideshowID)
{
	var frmobj=window.document.frm_slideshow_list;
	frmobj.slideshowID.value=slideshowID;
	frmobj.action="{{ url('/') }}/adminarea/slideshow/addeditslideshow";
	frmobj.submit();
}

function fun_slideshowSearch(srach_title)
{
	var frmobj=window.document.frm_slideshow_list;
	frmobj.srach_title.value=srach_title;
	frmobj.action="{{ url('/') }}/adminarea/slideshow/index";
	frmobj.submit();
}

function fun_single_delete(slideshowID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/slideshow/singledelete",
			data: "slideshowID=" + slideshowID,
			success: function(total){
			$("#ID_"+slideshowID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(slideshowID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/slideshow/singlestatus",
		data: "slideshowID=" + slideshowID,
		success: function(result){
			
			if(result == 0)
			{
				$('#status_'+slideshowID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+slideshowID).html("Active");
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
		frmobj=window.document.frm_slideshow_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_slideshow_list.action="{{ url('/') }}/adminarea/slideshow/index";
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
			  frmobj=window.document.frm_slideshow_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_slideshow_list.action="{{ url('/') }}/adminarea/slideshow/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(slideshowID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/slideshow/imagedelete",
			data: "slideshowID=" + slideshowID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>