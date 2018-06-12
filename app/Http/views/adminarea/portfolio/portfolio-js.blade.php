@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_portfolio_addedit').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
				'categoryID[]':{
					message: 'Please select category.',
					validators: 
						{
							notEmpty:{message: 'Please select category.'},
						}
				},
				portfolioTitle: 
				{
					message: 'Please enter portfoio title.',
					validators: 
						{
							notEmpty:{message: 'Please enter portfolio title.'},
						}
				},
				imgFileName_portfolio: {
					 validators: {
					   file: {
							  extension: 'gif,jpeg,jpg,png',
							  type: 'image/gif,image/jpeg,image/png',
							  message: 'The selected file is not valid, it should be (jpeg,jpg,gif,png)'
						},
					}
                }
			}
    });
});
</script>
@endif
<script type="text/javascript">
function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_portfolio_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_portfolio_list.action="{{ url('/') }}/adminarea/portfolio/index";
	frmobj.submit();
}
function fun_changeOrder()
{
	var frmobj=window.document.frm_portfolio_list;
	frmobj.action="{{ url('/') }}/adminarea/portfolio/portfolioorder";
	frmobj.submit();
}
function fun_back()
{
	var frmobj=window.document.frm_portfolio_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}

function fun_search(perpage)
{
	
	var frmobj=window.document.frm_portfolio_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/portfolio/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/portfolio/index";
	}
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_portfolio_list;
	frmobj.srach_portfolioTitle.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/portfolio/index";
	frmobj.submit();
}

function fun_edit(portfolioID)
{
	var frmobj=window.document.frm_portfolio_list;
	frmobj.portfolioID.value=portfolioID;
	frmobj.action="{{ url('/') }}/adminarea/portfolio/addeditportfolio";
	frmobj.submit();
}

function fun_portfolioSearch(srach_portfolioTitle)
{
	var frmobj=window.document.frm_portfolio_list;
	frmobj.srach_portfolioTitle.value=srach_portfolioTitle;
	frmobj.action="{{ url('/') }}/adminarea/portfolio/index";
	frmobj.submit();
}

function fun_single_delete(portfolioID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/portfolio/singledelete",
			data: "portfolioID=" + portfolioID,
			success: function(total){
			$("#ID_"+portfolioID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(portfolioID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/portfolio/singlestatus",
		data: "portfolioID=" + portfolioID,
		success: function(result){
			//alert(result);
			if(result == 0)
			{
				$('#status_'+portfolioID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+portfolioID).html("Active");
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
		frmobj=window.document.frm_portfolio_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_portfolio_list.action="{{ url('/') }}/adminarea/portfolio/index";
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
		  frmobj=window.document.frm_portfolio_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_portfolio_list.action="{{ url('/') }}/adminarea/portfolio/index";
		  frmobj.submit();
	  }
  }
  else
  {
	alert('Please select atleast one record.');
  }
}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(portfolioID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/portfolio/imagedelete",
			data: "portfolioID=" + portfolioID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>
 