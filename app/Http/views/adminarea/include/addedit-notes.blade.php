<?php 
	$notesUniqueID = $this->input->post('notesUniqueID')? $this->input->post('notesUniqueID') : '';
	$subject = $this->input->post('subject')? $this->input->post('subject') : '';
	$description = $this->input->post('description')? $this->input->post('description') : '';
	
	if($notesRecordCount>0){
		$notesUniqueID = $qGetSingleNotesData[0]->notesUniqueID;
		$subject = $qGetSingleNotesData[0]->subject;
		$description = $qGetSingleNotesData[0]->description;
	}
?>
<style type="text/css">
	.property_add_edit_form .box-body .form-group label.error{ color:#FF0000;}
	.content-wrapper{ min-height:200px !important;}

</style>
<!-- Main content -->
<section class="content">
<!-- Default box -->
	<div class="box">
	 <form role="form" class="property_add_edit_form" id="frm_notes" name="frm_notes" method="post" action="<?php echo base_url(); ?>commonnotes/savenotes">
		<input type="hidden" id="notesUniqueID" name="notesUniqueID" value="<?php echo $notesUniqueID;?>">
		<input type="hidden" id="uniqueID" name="uniqueID" value="<?php echo $uniqueID;?>">
		<input type="hidden" id="notesTypeID" name="notesTypeID" value="<?php echo $notesTypeID;?>">
		<div class="property_add">
			<div class="box-title with-border">
				<h2><?php if(strlen($notesUniqueID)>0){ echo "Edit ";}else{echo "Add ";}?> Notes</h2>
			</div>
			<div class="addunit_forms owner_detail_form">
				<div class="box-body">
					<div class="form-group">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="exampleInputPassword1">Subject *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<input class="form-control" placeholder="Subject" type="text" id="subject" name="subject" value="<?php echo $subject; ?>" maxlength="100">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="inputEmail3">Description *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<textarea class="form-control" id="description" name="description" maxlength="500"><?php echo $description; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			 </div>
		</div>
	   <div class="box-footer">
		<div class="col-xs-2 col-sm-3 col-md-3"></div>
			<div class="col-xs-4 col-sm-4 col-md-4">
			<button class="btn btn-warning waves-effect waves-light" type="submit" id="save" name="save">Submit</button>
		</div>
	  </div>
	 </form>
	</div>
<!-- /.box -->
</section>
<!-- /.content -->
<script type="text/javascript">
$(document).ready(function(){
	/* validation for notes page*/
		<?php if($this->config->item('isClientValidationStop')==0){?>
		$.validator.setDefaults({
		submitHandler: function() { window.document.frm_notes.submit() }
		});
		$.metadata.setType("attr", "validate");
		$().ready(function() {
		// validate the comment form when it is submitted
		$("#frm_notes").validate({
			rules: {
						subject: {required: true},
						description: {required: true},
					},
			messages: {
						subject:{required:"Please enter notes subject."},
						description:{required:"Please enter notes description."},
					},
		});
		});
	<?php } ?>
	
});
</script>