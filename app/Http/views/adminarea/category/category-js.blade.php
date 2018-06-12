@if(Config::get('config.isClientValidationStop_admin', '0')!=1)
<script type="text/javascript">
$(document).ready(function()
{
    $('#frm_category_addedit1').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
					categoryname: 
					{
						message: 'Please enter category name.',
						validators: 
							{
								notEmpty:{message: 'Please enter category name.'},
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
	frmobj=window.document.frm_category_list;
	frmobj.fieldname.value=fieldname;
	frmobj.order.value=order;
	document.frm_category_list.action="{{ url('/') }}/{{ $categorytypePath }}";
	frmobj.submit();
}

function fun_back()
{
	var frmobj=window.document.frm_category_addedit;
	//frmobj.action="{{ url('/') }}/{{ $categorytypePath }}";
	frmobj.action=frmobj.redirects_to.value;
	frmobj.submit();
}
function fun_changeOrder()
{
	var frmobj=window.document.frm_category_list;
	frmobj.action="{{ url('/') }}/adminarea/category/categoryorder";
	frmobj.submit();
}

function fun_search()
{
	var frmobj=window.document.frm_category_list;
	frmobj.action="{{ url('/') }}/{{ $categorytypePath }}";
	frmobj.submit();
}

function fun_reset()
{
	var frmobj=window.document.frm_category_list;
	frmobj.srach_categoryname.value='';
	frmobj.srch_status.value='';
	frmobj.srach_parentcategoryname.value='';
	frmobj.startDate.value='';
	frmobj.endDate.value='';
	frmobj.action="{{ url('/') }}/{{ $categorytypePath }}";
	frmobj.submit();
}

function fun_edit(categoryID)
{
	var frmobj=window.document.frm_category_list;
	frmobj.categoryID.value=categoryID;
	frmobj.action="{{ url('/') }}/{{ $addcategorytypePath }}";
	frmobj.submit();
}

function fun_categorySearch(srach_categoryname)
{
	var frmobj=window.document.frm_category_list;
	frmobj.srach_categoryname.value=srach_categoryname;
	frmobj.action="{{ url('/') }}/{{ $categorytypePath }}";
	frmobj.submit();
}

function fun_single_delete(categoryID)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/category/singledelete",
			data: "categoryID=" + categoryID,
			success: function(total){
			$("#ID_"+categoryID).animate({ opacity: "hide" }, "slow");
			}
		});
	}
}

function fun_single_status(categoryID)
{
	$.ajax({
	type: "POST",
	url: "{{ url('/') }}/adminarea/category/singlestatus",
	data: "categoryID=" + categoryID,
	success: function(result)
		{
			if(result == 0)
			{
				$('#status_'+categoryID).html("Inactive");
			}
			if(result == 1)
			{
				$('#status_'+categoryID).html("Active");
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
		frmobj=window.document.frm_category_list;
		frmobj.method.value="multiplestatus";
		frmobj.status.value=status;
		document.frm_category_list.action="{{ url('/') }}/{{ $categorytypePath }}";
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
			  frmobj=window.document.frm_category_list;
			  frmobj.method.value="multipleDelete";
			  document.frm_category_list.action="{{ url('/') }}/{{ $categorytypePath }}";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}
/***************** MULTIPLE ACTIVE ******************/
function fun_remove_thumb(categoryID,imagename)
{
	if(confirm("Are you sure want to delete this record? "))
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/category/imagedelete",
			data: "categoryID=" + categoryID+"&imagename="+imagename,
			success: function(total){
			$("#image").animate({ opacity: "hide" }, "slow");
			location.reload();
			}
		});
	}
}
function funGetChild(parentID,checked,obj) 
{
	var categoryID = $('#categoryID').val();
	if(categoryID!=parentID && parentID>0)
	{
		$('#parentCategoryID').val(parentID);
		var dropdown = $('#dropdown').val();
		if(obj < dropdown)
		{
			var drops = Number(dropdown);
			
			for(var l=drops ; l>obj ; l--)
			{
				$( "#parentCategoryID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/category/getChildPages",
		   data: "parentCategoryID="+parentID+"&obj="+obj+"&checked="+checked,
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
				$( "#parentCategoryID_"+l ).remove();
			}
			var tmp2 = Number(obj)+Number(1);
			$('#dropdown').val(tmp2);
		}
		var tmp2 = Number(obj)-Number(1);
		$('#dropdown').val(tmp2);
		
		parentID = $('#parentCategoryID_'+tmp2).val();
		
		$('#parentCategoryID').val(parentID);
	}
}
</script>