<!-- start Appliances-->
 <div class="col-xs-12 col-md-11  property_listing_info">
	<div class="col-xs-7 col-md-9">
		<div class="row">
			<h3>Appliances</h3>
		</div>
	 </div>
	 <div class="col-xs-12 col-md-3 property_edit_summary">
			<a id="addEditAppliances" href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i><span>Add Appliance</span></a>
	 </div>
	 <div class="col-sm-12 col-xs-12 col-md-12">
     	<div class="row">
			<table id="example" class="table data_table table-striped">
			   <?php if($appliancesRecordCount >0){
					 foreach($qGetAppliancesData as $GetAppliancesData){?>
						<tr id="ID_<?php echo $GetAppliancesData->appliancesUniqueID ?>">
							<td width="20%"><?php echo $GetAppliancesData->appliancesName;?></td>
							<td width="20%"><?php echo $GetAppliancesData->appliancesUnit;?> Unites</td>
							<td width="25%"><?php echo $GetAppliancesData->createdDate;?></td>
							<td width="35%">
								<?php if($appliancesTypeID==$this->config->item('propertyAppliancesTypeID')){?>
										<a href="<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('propertyAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyData)){echo $qGetSinglePropertyData[0]->propertyUniqueID;}?>&appliancesUniqueID=<?php echo $GetAppliancesData->appliancesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
								<?php }elseif($appliancesTypeID==$this->config->item('propertyOwnerAppliancesTypeID')){?>
										<a href="<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('propertyOwnerAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyOwnerData)){echo $qGetSinglePropertyOwnerData[0]->propertyOwnerUniqueID;}?>&appliancesUniqueID=<?php echo $GetAppliancesData->appliancesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
								<?php }elseif($appliancesTypeID==$this->config->item('tenantAppliancesTypeID')){?>
										<a href="<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('tenantAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleTenantData)){echo $qGetSingleTenantData[0]->tenantUniqueID;}?>&appliancesUniqueID=<?php echo $GetAppliancesData->appliancesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
								<?php }elseif($appliancesTypeID==$this->config->item('unitAppliancesTypeID')){?>
										<a href="<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('unitAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleUnitData)){echo $qGetSingleUnitData[0]->unitUniqueID;}?>&appliancesUniqueID=<?php echo $GetAppliancesData->appliancesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
								<?php }elseif($appliancesTypeID==$this->config->item('vendorAppliancesTypeID')){?>
										<a href="<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('vendorAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleVendorData)){echo $qGetSingleVendorData[0]->vendorUniqueID;}?>&appliancesUniqueID=<?php echo $GetAppliancesData->appliancesUniqueID;?>&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600" class="thickbox"><i class="fa fa-pencil-square-o"></i></a>
								<?php }?>
                                &nbsp;
								<a href="javascript:;" onclick="fun_appliances_delete('<?php echo $GetAppliancesData->appliancesUniqueID; ?>');" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
				<?php } }else{ ?>
						<tr>You don't have any appliances for this property right now.</tr>
				<?php } ?>
			</table>
         </div>  
	 </div>
 </div>
<!-- end Appliances-->
<script type="text/javascript">
/* for delete single appliance */
	$("#addEditAppliances").click(function(){
		<?php if($appliancesTypeID==$this->config->item('propertyAppliancesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('propertyAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyData)){echo $qGetSinglePropertyData[0]->propertyUniqueID;}?>&appliancesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600")
		<?php }elseif($appliancesTypeID==$this->config->item('propertyOwnerAppliancesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('propertyOwnerAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSinglePropertyOwnerData)){echo $qGetSinglePropertyOwnerData[0]->propertyOwnerUniqueID;}?>&appliancesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600")
		<?php }elseif($appliancesTypeID==$this->config->item('tenantAppliancesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('tenantAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleTenantData)){echo $qGetSingleTenantData[0]->tenantUniqueID;}?>&appliancesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600")
		<?php }elseif($appliancesTypeID==$this->config->item('unitAppliancesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('unitAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleUnitData)){echo $qGetSingleUnitData[0]->unitUniqueID;}?>&appliancesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600")
		<?php }elseif($appliancesTypeID==$this->config->item('vendorAppliancesTypeID')){?>
			tb_show("","<?php echo base_url()?>commonappliances/addeditappliances?appliancesTypeID=<?php echo $this->config->item('vendorAppliancesTypeID');?>&uniqueID=<?php if(isset($qGetSingleVendorData)){echo $qGetSingleVendorData[0]->vendorUniqueID;}?>&appliancesUniqueID=0&popup=true&KeepThis=true&TB_iframe=true&height=400&width=600")
		<?php }?>
		
	});
	function fun_appliances_delete(appliancesUniqueID)
	{
		$.confirm({
			title: 'Appliances Delete!',
			theme: 'black',
			content: 'Are you sure you want to delete this record? ',
			confirmButtonClass: 'btn-primary',
			cancelButtonClass: 'btn-danger',
			confirmButton:'Yes',
			cancelButton:'No',
			confirm: function(){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>commonappliances/singledelete",
					data: "appliancesUniqueID=" + appliancesUniqueID,
					success: function(total){
					$("#ID_"+appliancesUniqueID).animate({ opacity: "hide" }, "slow");
					}
				});
			},
			cancel: function(){
				}
		});
	}
</script>