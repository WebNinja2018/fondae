<style type="text/css">
	.content-wrapper{ min-height:200px !important;}
</style>
<!-- start Notes-->
 <div class="col-xs-12 col-md-11 property_listing_info">
		<div class="col-xs-7 col-md-9">
			<div class="row">
				<h3>Notes</h3>
			</div>
		 </div>
		<div class="col-xs-12 col-md-3 property_edit_summary">
           	<a id="addEditNote" href="#"><i class="fa fa-plus"></i><span>Add Note</span></a>
		</div>
         <div class="col-sm-12 col-xs-12 col-md-12">
            <div class="row">
                 <table id="example" class="table  data_table table-striped">
                    <?php if($notesRecordCount >0){
                          foreach($qGetNotesData as $GetNotesData){?>
                            <tr id="ID_<?php echo $GetNotesData->notesUniqueID ?>">
                                <td width="20%"><?php echo $GetNotesData->subject;?></td>
                                <td width="20%"><?php echo $GetNotesData->description;?></td>
                                <td width="25%"><?php echo $GetNotesData->createdDate;?></td>
                                <td width="35%">
                                    <?php if($notesTypeID==$this->config->item('propertyNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('propertyNotesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyData)){echo $qGetSinglePropertyData[0]->propertyUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }elseif($notesTypeID==$this->config->item('propertyOwnerNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('propertyOwnerNotesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyOwnerData)){echo $qGetSinglePropertyOwnerData[0]->propertyOwnerUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }elseif($notesTypeID==$this->config->item('tenantNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('tenantNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleTenantData)){echo $qGetSingleTenantData[0]->tenantUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }elseif($notesTypeID==$this->config->item('unitNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('unitNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleUnitData)){echo $qGetSingleUnitData[0]->unitUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }elseif($notesTypeID==$this->config->item('vendorNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('vendorNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleVendorData)){echo $qGetSingleVendorData[0]->vendorUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }elseif($notesTypeID==$this->config->item('leaseNotesTypeID')){?>
                                            <a href="<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('leaseNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleLeaseData)){echo $qGetSingleLeaseData[0]->leaseUniqueID;}?>&notesUniqueID=<?php echo $GetNotesData->notesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php }?>
                                    &nbsp;
                                    <a href="javascript:;" onclick="fun_notes_delete('<?php echo $GetNotesData->notesUniqueID; ?>');" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                            <tr>You don't have any notes for this property right now.</tr>
                        <?php } ?>
                    </table>
                </div>
         </div>
 </div>
<!-- end Notes-->
<script type="text/javascript">
	/* for delete single note */
	function fun_notes_delete(notesUniqueID)
	{
		$.confirm({
			title: 'Notes Delete!',
			theme: 'black',
			content: 'Are you sure you want to delete this record? ',
			confirmButtonClass: 'btn-primary',
			cancelButtonClass: 'btn-danger',
			confirmButton:'Yes',
			cancelButton:'No',
			confirm: function(){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>commonnotes/singledelete",
					data: "notesUniqueID=" + notesUniqueID,
					success: function(total){
					$("#ID_"+notesUniqueID).animate({ opacity: "hide" }, "slow");
					}
				});
			},
			cancel: function(){
				}
		});
	}
	$("#addEditNote").click(function(){
		<?php if($notesTypeID==$this->config->item('propertyNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('propertyNotesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyData)){echo $qGetSinglePropertyData[0]->propertyUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600")
		<?php }elseif($notesTypeID==$this->config->item('propertyOwnerNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('propertyOwnerNotesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyOwnerData)){echo $qGetSinglePropertyOwnerData[0]->propertyOwnerUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600")
		<?php }elseif($notesTypeID==$this->config->item('tenantNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('tenantNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleTenantData)){echo $qGetSingleTenantData[0]->tenantUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600")
		<?php }elseif($notesTypeID==$this->config->item('unitNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('unitNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleUnitData)){echo $qGetSingleUnitData[0]->unitUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=335&width=600")
		<?php }elseif($notesTypeID==$this->config->item('vendorNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('vendorNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleVendorData)){echo $qGetSingleVendorData[0]->vendorUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=330&width=600")
		<?php }elseif($notesTypeID==$this->config->item('leaseNotesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonnotes/addeditnotes?notesTypeID=<?php echo $this->config->item('leaseNotesTypeID');?>&uniqueID=<?php if(isset($qGetSingleLeaseData)){echo $qGetSingleLeaseData[0]->leaseUniqueID;}?>&notesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=330&width=600")
		<?php }?>
	});
</script>