<?php 
	$appliancesUniqueID = $this->input->post('appliancesUniqueID')? $this->input->post('appliancesUniqueID') : '';
	$appliancesName = $this->input->post('appliancesName')? $this->input->post('appliancesName') : '';
	$appliancesUnit = $this->input->post('appliancesUnit')? $this->input->post('appliancesUnit') : '';
	$appliancesDescription = $this->input->post('appliancesDescription')? $this->input->post('appliancesDescription') : '';
	$appliancesStartDate = $this->input->post('appliancesStartDate')? date('m/d/Y',strtotime($this->input->post('appliancesStartDate'))) : '';
	$appliancesEndDate = $this->input->post('appliancesEndDate')? date('m/d/Y',strtotime($this->input->post('appliancesEndDate'))) : '';
	
	if($appliancesRecordCount>0){
		$appliancesUniqueID = $qGetSingleAppliancesData[0]->appliancesUniqueID;
		$appliancesName = $qGetSingleAppliancesData[0]->appliancesName;
		$appliancesUnit = $qGetSingleAppliancesData[0]->appliancesUnit;
		$appliancesDescription = $qGetSingleAppliancesData[0]->appliancesDescription;
		$appliancesStartDate = date('m/d/Y',strtotime($qGetSingleAppliancesData[0]->appliancesStartDate));
		$appliancesEndDate = date('m/d/Y',strtotime($qGetSingleAppliancesData[0]->appliancesEndDate));
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
	 <form role="form" class="property_add_edit_form" id="frm_appliances" name="frm_appliances" method="post" action="<?php echo base_url(); ?>commonappliances/saveappliances">
		<input type="hidden" id="appliancesUniqueID" name="appliancesUniqueID" value="<?php echo $appliancesUniqueID;?>">
		<input type="hidden" id="uniqueID" name="uniqueID" value="<?php echo $uniqueID;?>">
		<input type="hidden" id="appliancesTypeID" name="appliancesTypeID" value="<?php echo $appliancesTypeID;?>">
		<div class="property_add">
			<div class="box-title with-border">
				<h2><?php if(strlen($appliancesUniqueID)>0){ echo "Edit ";}else{echo "Add ";}?> Appliances</h2>
			</div>
			<div class="addunit_forms owner_detail_form">
				<div class="box-body">
					<div class="form-group">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="exampleInputPassword1">Appliances Name *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<input class="form-control" placeholder="Appliances Name" type="text" id="appliancesName" name="appliancesName" value="<?php echo $appliancesName; ?>" maxlength="50">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 col-md-7">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="exampleInputPassword1">Appliances Unit *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<input class="form-control" placeholder="Appliances Unit" type="text" id="appliancesUnit" name="appliancesUnit" value="<?php echo $appliancesUnit; ?>" maxlength="11">
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
										<textarea class="form-control" id="appliancesDescription" name="appliancesDescription" maxlength="500"><?php echo $appliancesDescription; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="inputEmail3">Appliances Start Date *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<input class="form-control" id="appliancesStartDate" name="appliancesStartDate" value="<?php echo $appliancesStartDate; ?>" placeholder="" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-7 col-md-7 col-xs-12">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="row">
									<label class="col-sm-12 col-xs-12 col-md-12 control-label" for="inputEmail3">Appliances End Date *</label>
									<div class="col-sm-6 col-xs-6 col-md-6">
										<input class="form-control" id="appliancesEndDate" name="appliancesEndDate" value="<?php echo $appliancesEndDate; ?>" placeholder="" type="text">
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
		/* validation for Appliances page*/
		<?php if($this->config->item('isClientValidationStop')==0){?>
		jQuery.validator.addMethod("lettersonly", function(value, element) {
		  return this.optional(element) || /^[a-z]+$/i.test(value);
		}, "Please enter letters only."); 
		$.validator.setDefaults({
		submitHandler: function() { window.document.frm_appliances.submit() }
		});
		$.metadata.setType("attr", "validate");
		$().ready(function() {
		// validate the comment form when it is submitted
		$("#frm_appliances").validate({
			rules: {
						appliancesName: {required: true,lettersonly:true},
						appliancesUnit: {required: true,number:true},
						appliancesDescription: {required: true},
						appliancesStartDate: {required: true},
						appliancesEndDate: {required: true},
					},
			messages: {
						appliancesName:{required:"Please enter Appliances name."},
						appliancesDescription:{required:"Please enter Appliances description."},
						appliancesUnit:{required:"Please enter Appliances Unit.",number:"Please enter only number."},
						appliancesStartDate:"Please select Appliances StartDate.",
						appliancesEndDate:"Please select Appliances EndDate.",
					},
		});
		});
	<?php } ?>
	
	/* Appliances Date picker */
	$('#appliancesStartDate').datepicker({
	  startDate: '1/1/1990',
	  endDate: '12/30/2037',
	  autoclose: true,
	});
	
	$('#appliancesEndDate').datepicker({
	  startDate: '1/1/1990',
	  endDate: '12/30/2037',
	  autoclose: true,
	});
});
</script>
