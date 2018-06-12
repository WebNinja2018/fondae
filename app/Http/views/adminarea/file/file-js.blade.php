<script type="text/javascript">
	$(document).ready(function() {
    $('#frm_file').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
		
    });
	});
	function fun_edit_file(fileID)
	{
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/file/get_edit_record",
		   data: "fileID=" + fileID,
		   success: function(result){
				$("#filechange").html("");
				$("#filetxtHint").html(result);
		   }
		 });
	}
	
	function fun_single_delete_file(fileID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/file/singledelete",
				data: "fileID=" + fileID,
				success: function(total){
				$("#ID_"+fileID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
	
	function fun_single_status_file(fileID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/file/singlestatus",
			data: "fileID=" + fileID,
			success: function(result){
				if(result == 0)
				{
					$('#status_'+fileID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+fileID).html("Active");
				}
			}
		});
	}
	
	
	/************Back to Page*************************/
	
	function fun_savetoback(backto)
	{
		
		var frmobj=window.document.frm_file;
		var backlistPage=document.getElementById('backto').value=1;
		frmobj.action="{{ url('/') }}/adminarea/file/savefile";
		document.getElementById('frm_file').submit();
	}
	
	function fun_back()
	{
		var frmobj=window.document.frm_file_addedit;
		var redirects_to= frmobj.redirects_to.value;
		frmobj.action=redirects_to
		frmobj.submit();
	}

</script>


