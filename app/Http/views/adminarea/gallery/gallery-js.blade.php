<?php $galleryID=Input::get('galleryID')?Input::get('galleryID'):'0';?>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function() {
    $('#frm_gallery_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		//excluded: ':disabled', For Hidden Fields Validation.
		fields: {

				galleryTitle: 
				{
					message: 'Please Enter Gallery Title',
					validators: 
						{
							notEmpty:{message: 'Please Enter Gallery Title.'},
						}
				},

				displayOrder: 
				{
					message: 'Please Enter Display Order',
					validators: 
						{
							notEmpty:{message: 'Please Enter Display Order.'},
						}
				},
				
				<?php if($galleryID==0) {?>
				galleryMainImage: 
				{
					message: 'Please Select Gallary Image',
					validators: 
						{
							notEmpty:{message: 'Please Select Gallary Image.'},
							file: 
							{
								extension: 'jpeg,jpg,png,gif',
								type: 'image/jpeg,image/png,image/gif',
								message: 'The selected file is not valid.'
                    		}
						}
				},
				<?php } ?>
				
				weblink: 
				{
					message: 'Please Enter Valid weblink',
					validators: 
					{
						uri:
						{
							message: 'The weblink is not valid'
						}
					}
				},
			}
    });
});
</script>
@endif
<script type="text/javascript">
function fun_changeOrder()
{
	var frmobj=window.document.frm_gallery_list;
	frmobj.action="{{ url('/') }}/adminarea/gallery/galleryorder";
	frmobj.submit();
}
function fun_changeimageOrder()
{
	var frmobj=window.document.frm_gallery_addedit;
	frmobj.action="{{ url('/') }}/adminarea/gallery/imageorder";
	frmobj.submit();
}

function fun_backGallery()
{
	var frmobj=window.document.frm_gallery_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	var frmobj=window.document.frm_gallery_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_gallery_list.action="{{ url('/') }}/adminarea/gallery/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_gallery_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/gallery/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/gallery/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_gallery_list;
	frmobj.srach_title.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/gallery/index";
	frmobj.submit();
}

function fun_edit(galleryID)
{
	var frmobj=window.document.frm_gallery_list;
	frmobj.galleryID.value=galleryID;
	frmobj.action="{{ url('/') }}/adminarea/gallery/addeditgallery";
	frmobj.submit();
}

function fun_gallerySearch(srach_title)
{
	var frmobj=window.document.frm_gallery_list;
	frmobj.srach_title.value=srach_title;
	frmobj.action="{{ url('/') }}/adminarea/gallery/index";
	frmobj.submit();
}

function fun_single_delete(galleryID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/gallery/singledelete",
			data: "galleryID=" + galleryID,
			success: function(total){
			$("#ID_"+galleryID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(galleryID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/gallery/singlestatus",
		data: "galleryID=" + galleryID,
		success: function(result){
			
			if(result == 0)
			{
				$('#status_'+galleryID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+galleryID).html("Active");
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
		frmobj=window.document.frm_gallery_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_gallery_list.action="{{ url('/') }}/adminarea/gallery/index";
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
			  frmobj=window.document.frm_gallery_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_gallery_list.action="{{ url('/') }}/adminarea/gallery/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(galleryID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/gallery/imagedelete",
			data: "galleryID=" + galleryID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}

function fun_isActiveImage(imagesID)
{
	if(confirm("Image Status Update Successfully..."))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/gallery/singleimagestatus",
			data: "imagesID="+imagesID,
			success: function(total1){
			}
		});
	}
}
</script>