
 <script type="text/javascript">
$(document).ready(function()
{
    $('#frm_Pages_list').bootstrapValidator(
	{
        message: 'This value is not valid',
        feedbackIcons: 
		{
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					pageName: 
					{
						message: 'Please Enter Name',
						validators: 
							{
								notEmpty:{message: 'Please enter page name.'},
							}
					},
					
					pageFileName: 
					{
						message: 'Please Enter Page File Name',
						validators: 
							{
								notEmpty:{message: 'Please enter page file name.'},
							}
					},
					
				}
    });
});

function fun_changeOrder()
{
	var srch_pageID = $('#srch_pageID').val();
  	var h = [];
  	$("#table-1 tr").each(function() {  h.push($(this).attr('id'));  });
		
  	$.ajax({
	type: "POST",
	url: "{{ url('/') }}/adminarea/pages/saveorder",
	data: 'item='+h+'&srch_pageID='+srch_pageID,
	success: function(data)
		{
			window.location.reload();
		}
	});
}

function fun_back()
{
	var frmobj=window.document.frm_pages_addedit;
		frmobj.action= frmobj.redirects_to.value;
		frmobj.submit();
}

function fun_selectsection(srch_pageID)
{
	var frmobj=window.document.frm_Pages_list;
	frmobj.srch_pageID.value = srch_pageID;
	frmobj.action="{{ url('/') }}/adminarea/pages";
	frmobj.submit();
}

function fun_hideshow()
{
	$(document).ready(function(){
    $("button").click(function(){
        $("a").toggle();
    });
	});
}
function reorder_rows(current_id,parent_id,direction)
{
	$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/pages/getReorder",
			data: "pageID="+current_id+"&parentID="+parent_id+"&direction="+direction,
			success: function(total)
			{
			   window.document.location.reload();
			   alert();
			}
		});
}

function fun_upDown(fieldname,order)
{
	frmobj=window.document.frm_Pages_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_Pages_list.action="{{ url('/') }}/adminarea/pages/index";
	frmobj.submit();
}

function funPageType(type)
{
	if(type==1)
	{
		$('#pageType1_1').show('fast');
		$('#pageType2_1').hide('fast');
		$('#pageType2_3').hide('fast');
		if( $( "#content" ).prop( "checked" )==true )
		{
			funPageContent(1);
		}
		else if( $( "#dynamic" ).prop( "checked" )==true )
		{
			funPageContent(2);
		}
		else if( $( "#contentdynamic" ).prop( "checked" )==true )
		{
			funPageContent(3);
		}
	}
	else
	{
		$('#pageType2_1').show('fast');
		$('#pageType2_3').show('fast');
		$('#pageType1_1').hide('fast');
		$('#pageContentBox').hide('fast');
	}
}

function funPageContent(type)
{
	if(type==1 || type==3)
	{
		$('#pageContentBox').show('fast');
	}
	else
	{
		$('#pageContentBox').hide('fast');
	}
}

function fun_search(perpage)
{
	var frmobj=window.document.frm_Pages_list;
	if(perpage>0)
	{
		frmobj.action="{{ url('/') }}/adminarea/pages/index/"+perpage;
	}
	else
	{
		frmobj.action="{{ url('/') }}/adminarea/pages/index";
	}
	frmobj.submit();
}

function fun_pagesSearch(srch_name)
{
	var frmobj=window.document.frm_Pages_list;
	frmobj.srch_name.value=srch_name;
	frmobj.action="{{ url('/') }}/adminarea/pages/index";
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_Pages_list;
	frmobj.srch_name.value='';
	frmobj.srch_status.value='';
	frmobj.action="{{ url('/') }}/adminarea/pages/index";
	frmobj.submit();
}

function fun_edit(pageID)
{
	var frmobj=window.document.frm_Pages_list;
	frmobj.pageID.value=pageID;
	frmobj.action="{{ url('/') }}/adminarea/pages/addeditpages";
	frmobj.submit();
}

function fun_single_delete(pageID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/pages/singledelete",
			data: "pageID=" + pageID,
			success: function(total){
			$("#ID_"+pageID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(pageID)
{
	$.ajax({
		type: "POST",
		url: "{{ url('/') }}/adminarea/pages/singlestatus",
		data: "pageID=" + pageID,
		success: function(result){
			if(result == 0)
			{
				$('#status_'+pageID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+pageID).html("Active");
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
		frmobj=window.document.frm_Pages_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_Pages_list.action="{{ url('/') }}/adminarea/pages/index";
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
			  frmobj=window.document.frm_Pages_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_Pages_list.action="{{ url('/') }}/adminarea/pages/index";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/

function funGetChild(parentID,checked,obj) 
{
	var pageID = $('#pageID').val();
	
	if(pageID!=parentID && parentID>0)
	{
		$('#parentID').val(parentID);
		var dropdown = $('#dropdown').val();
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				
				$( "#parentID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/pages/getChildPages",
		   data: "parentID="+parentID+"&obj="+obj+"&checked="+checked,
		   success: function(result){
			   if(result)
			   {
				   var tmp = Number(obj)+Number(1);
				   $('#dropdown').val(tmp);
				   $( "#parentDropdowns" ).append( result );
			   }
		   }
		 });
	}
	else if(parentID == 0 && (obj==1 || obj.length==0))
	{
		var dropdown = $('#dropdown').val();
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				$( "#parentID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		var tmp2 = Number(obj)-Number(1);
		$('#dropdown').val(tmp2);
		
		parentID = $('#parentID_'+tmp2).val();
		
		$('#parentID').val(parentID);
	}
}
function fun_remove_thumb(pageID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/pages/imagedelete",
			data: "pageID=" + pageID+"&imagename="+imagename,
			success: function(total){
				$("#image").animate({ opacity: "hide" }, "slow");
				location.reload();
			}
		});
	}
}
</script>