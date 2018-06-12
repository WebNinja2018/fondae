<script type="text/javascript">
	$(document).ready(function() {
    $('#frm_image').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
		
    });
	});
	function fun_edit_image(imagesID)
	{
		$.ajax({
		   type: "POST",
		   url: "{{ url('/') }}/adminarea/images/get_edit_record",
		   data: "imagesID=" + imagesID,
		   success: function(result){
				$("#imagechange").html("");
				$("#imagetxtHint").html(result);
		   }
		 });
	}
	
	function fun_single_delete_image(imagesID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/images/singledelete",
				data: "imagesID=" + imagesID,
				success: function(total){
				$("#ID_"+imagesID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
	
	function fun_single_status_image(imagesID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/images/singlestatus",
			data: "imagesID=" + imagesID,
			success: function(result){
				if(result == 0)
				{
					$('#status_'+imagesID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+imagesID).html("Active");
				}
			}
		});
	}
	
	
	/************Back to Page*************************/
	
	function fun_savetoback(backto)
	{
		
		var frmobj=window.document.frm_image;
		var backlistPage=document.getElementById('backto').value=1;
		frmobj.action="{{ url('/') }}/adminarea/images/saveimages";
		document.getElementById('frm_image').submit();
	}
	
	function fun_back()
	{
		var frmobj=window.document.frm_images_addedit;
		frmobj.action=frmobj.redirects_to.value;
		frmobj.submit();
	}

</script>


