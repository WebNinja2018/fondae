<script src="//oss.maxcdn.com/momentjs/2.8.2/moment.min.js"></script>
@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
	$(document).ready(function() {
		$('#frm_news_addedit').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
					'categoryID[]':{
						message: 'Please select category',
						validators: 
							{
								notEmpty:{message: 'Please select category.'},
							}
					},
					newsTitle: 
					{
						message: 'Please Enter Title',
						validators: 
							{
								notEmpty:{message: 'Please enter news title.'},
							}
					},
					author: 
					{
						message: 'Please Enter Author',
						validators: 
							{
								notEmpty:{message: 'Please enter author name.'},
							}
					},
					imgFileName_news: {
						 validators: {
						   file: {
								  extension: 'gif,jpeg,jpg,png',
								  type: 'image/gif,image/jpeg,image/png',
								  message: 'The selected file is not valid, it should be (jpeg,jpg,gif,png)'
							},
						}
					},	
					newsDate:
					{
						message: 'Please select news date.',
						validators: 
							{
								notEmpty:{message: 'Please select news date.'},
		
								callback: {
									message: 'New Date cannot be a future date.',
									callback: function(value, validator) {
										var m = new moment(value, 'MM/DD/YYYY', true);
										if (!m.isValid()) {
											return false;
										}
										return m.isAfter('01/01/1970') && m.isBefore(new Date());
									}
								}
																
							}
					}	
				}
		});
	});
	
	$(document).ready(function() {
		$('#frm_news_meta').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
					pageTitle: 
					{
						message: 'Please Enter Title',
						validators: 
							{
								notEmpty:{message: 'Please enter Page title.'},
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
	frmobj=window.document.frm_news_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_news_list.action="{{ url('/') }}/adminarea/news/index";
	frmobj.submit();
}
function fun_changeOrder()
{
	var frmobj=window.document.frm_news_list;
	frmobj.action="{{ url('/') }}/adminarea/news/newsorder";
	frmobj.submit();
}

function fun_back_general_tab()
{
	var frmobj=window.document.frm_news_addedit;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}
function fun_back_mata()
{
	
	var frmobj=window.document.frm_news_meta;
	frmobj.action= frmobj.redirects_to.value;
	frmobj.submit();
}
function fun_search(perpage)
{
	
	var frmobj=window.document.frm_news_list;
	frmobj.action="{{ url('/') }}/adminarea/news/index";
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_news_list;
	frmobj.srach_newsTitle.value='';
	frmobj.srch_status.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/adminarea/news/index";
	frmobj.submit();
}

function fun_edit(newsID)
{
	var frmobj=window.document.frm_news_list;
	frmobj.newsID.value=newsID;
	frmobj.action="{{ url('/') }}/adminarea/news/addeditnews";
	frmobj.submit();
}

function fun_newsSearch(srach_newsTitle)
{
	var frmobj=window.document.frm_news_list;
	frmobj.srach_newsTitle.value=srach_newsTitle;
	frmobj.action="{{ url('/') }}/adminarea/news/index";
	frmobj.submit();
}

function fun_single_delete(newsID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/news/singledelete",
			data: "newsID=" + newsID,
			success: function(total){
			$("#ID_"+newsID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(newsID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/news/singlestatus",
		data: "newsID=" + newsID,
		success: function(result){
			//alert(result);
			if(result == 0)
			{
				$('#status_'+newsID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+newsID).html("Active");
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
		frmobj=window.document.frm_news_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_news_list.action="{{ url('/') }}/adminarea/news/index";
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
		  frmobj=window.document.frm_news_list;
		  frmobj.method.value="multipleDelete";
		  document.frm_news_list.action="{{ url('/') }}/adminarea/news/index";
		  frmobj.submit();
	  }
  }
  else
  {
	alert('Please select atleast one record.');
  }
}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(newsID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/news/imagedelete",
			data: "newsID=" + newsID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
</script>
 