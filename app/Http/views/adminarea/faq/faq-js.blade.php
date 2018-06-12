@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_faq_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
				   // 'categoryID[]': {
//						validators: {
//							notEmpty: {
//								message: 'The category field is required.'
//							}
//						}
//					},
					
					question: 
					{
						message: 'Please enter FAQ question.',
						validators: 
							{
								notEmpty:{message: 'Please enter FAQ question.'},
							}
					},
					
					answer: 
					{
						message: 'Please enter FAQ answer',
						validators: 
							{
								notEmpty:{message: 'Please enter FAQ answer.'},
							}
					},
					displayOrder: 
					{
						message: 'Please enter FAQ display order.',
						validators: 
							{
								notEmpty:{message: 'Please enter display order.'},
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
	var frmobj=window.document.frm_faq_list;
	frmobj.action="{{ url('/') }}/adminarea/faq/faqorder";
	frmobj.submit();
}


function fun_back()
{
	var frmobj=window.document.frm_faq_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_faq_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_faq_list.action="{{ url('/') }}/adminarea/faq/index";
	frmobj.submit();
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_faq_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/faq/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/faq/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_faq_list;
	frmobj.srach_question.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/faq/index";
	frmobj.submit();
}

function fun_edit(faqID)
{
	var frmobj=window.document.frm_faq_list;
	frmobj.faqID.value=faqID;
	frmobj.action="{{ url('/') }}/adminarea/faq/addeditfaq";
	frmobj.submit();
}

function fun_faqSearch(srach_question)
{
	var frmobj=window.document.frm_faq_list;
	frmobj.srach_question.value=srach_question;
	frmobj.action="{{ url('/') }}/adminarea/faq/index";
	frmobj.submit();
}

function fun_single_delete(faqID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/faq/singledelete",
			data: "faqID=" + faqID,
			success: function(total){
			$("#ID_"+faqID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(faqID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/faq/singlestatus",
		data: "faqID=" + faqID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+faqID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+faqID).html("Active");
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
	//alert(status);
	var count = $(":checkbox:checked").length;
	if(count > 0)
	{
		frmobj=window.document.frm_faq_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_faq_list.action="{{ url('/') }}/adminarea/faq/index";
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
			  frmobj=window.document.frm_faq_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_faq_list.action="{{ url('/') }}/adminarea/faq/index";
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