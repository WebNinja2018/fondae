<div class="col-sm-11 col-md-11 col-xs-12 property_listing_info">
	<div class="col-xs-7 col-md-9">
		<div class="row">
			<h3>Files</h3>
		</div>
	 </div>
	<div class="col-xs-12 col-md-3 property_edit_summary">
        <a href="#files-control"><i class="fa fa-upload" aria-hidden="true"></i><span id="upload-file">Upload File</span></a>
	</div>
	<div class="col-sm-12 col-xs-12 col-md-12" id="files-control" style="display:none;">
		<input id="file-1" type="file" value="upload" name="imagesName" multiple class="file-loading" data-overwrite-initial="false" data-min-file-count="1">
		<p class="help-block">File upload should be a maximum of 5mb. Supported Files .gif .jpg .bmp .doc. docx .png .ppt .pdf .xls .xlsx .txt .rtf</p>
	</div>
	<div class="col-sm-12 col-xs-12 col-md-12">
     	<div class="row">
            <table id="example" class="table data_table table-striped">
               <?php if($filesRecordCount >0){
                     foreach($qGetFilesData as $GetFilesData){?>
                        <tr id="ID_<?php echo $GetFilesData->filesUniqueID ?>">
                            <td width="40%"><?php echo $GetFilesData->filesName;?></td>
                            <td width="25%"><?php echo $GetFilesData->createdDate;?></td>
                            <td width="36%">
                                <a href="<?php echo base_url().'upload/files/'.$GetFilesData->filesName;?>" download="<?php echo $GetFilesData->filesName ?>"><i class="fa fa-download"></i></a>
                                &nbsp;
                                <a href="javascript:;" onClick="fun_files_delete('<?php echo $GetFilesData->filesUniqueID; ?>');" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                <?php } }else{ ?>
                        <tr>You don't have any files for this property right now.</tr>
                <?php } ?>
            </table>
        </div>
	</div>
</div>
<?php if($filesTypeID==$this->config->item('propertyFilesTypeID')){
		$filesTypeID=$this->config->item('propertyFilesTypeID');
		$uniqueID=$qGetSinglePropertyData[0]->propertyUniqueID;
	  }else if($filesTypeID==$this->config->item('propertyOwnerFilesTypeID')){
	  	$filesTypeID=$this->config->item('propertyOwnerFilesTypeID');
		$uniqueID=$qGetSinglePropertyOwnerData[0]->propertyOwnerUniqueID;
	  }else if($filesTypeID==$this->config->item('tenantFilesTypeID')){
	  	$filesTypeID=$this->config->item('tenantFilesTypeID');
		$uniqueID=$qGetSingleTenantData[0]->tenantUniqueID;
	  }else if($filesTypeID==$this->config->item('unitFilesTypeID')){
	  	$filesTypeID=$this->config->item('unitFilesTypeID');
		$uniqueID=$qGetSingleUnitData[0]->unitUniqueID;
	  }else if($filesTypeID==$this->config->item('vendorFilesTypeID')){
	  	$filesTypeID=$this->config->item('vendorFilesTypeID');
		$uniqueID=$qGetSingleVendorData[0]->vendorUniqueID;
	  }
 ?>
<script src="<?php echo base_url();?>/components/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript">
	$('#upload-file').click(function(){
		window.location.hash = '#upload-file';
		$('#files-control').toggle(500);
	});
	$("#file-1").fileinput({
		uploadUrl: '<? echo base_url();?>commonfiles/savefile', // you must set a valid URL here else you will get an error
		allowedFileExtensions : ['jpg', 'png','gif','jpeg','pdf','doc','docx','xml','zip','rar','rtf','xlsx','xls','word','txt','text','ppt'],
		overwriteInitial: false,
		maxFileSize: 1000,
		//dataType: "json",
		showUpload: false, // hide upload button
		showRemove: false, // hide remove button
		maxFilesNum: 10,
		uploadExtraData:{filesTypeID:<?php echo $filesTypeID; ?>,uniqueID:'<?php echo $uniqueID; ?>'},
		//allowedFileTypes: ['image', 'video', 'flash'],
		slugCallback: function(filename) {
			return filename.replace('(', '_').replace(']', '_');
		}
	}).on("filebatchselected", function(event, files) {
		$("#file-1").fileinput("upload");		
		window.location.reload();
	});
	<?php /*on("filebatchselected", function(event, files) {
		// trigger upload method immediately after files are selected
		$(".file-preview").css("height","auto");
		$(".file-drop-zone").css("height","auto");
		$("#file-1").fileinput("upload");
		window.location.reload();*/ ?>

/* for delete single file */
function fun_files_delete(filesUniqueID)
{
	$.confirm({
		title: 'File Delete!',
		theme: 'black',
		content: 'Are you sure you want to delete this record? ',
		confirmButtonClass: 'btn-primary',
		cancelButtonClass: 'btn-danger',
		confirmButton:'Yes',
		cancelButton:'No',
		confirm: function(){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>commonfiles/singlefiledelete",
				data: "filesUniqueID=" + filesUniqueID,
				success: function(total){
				$("#ID_"+filesUniqueID).animate({ opacity: "hide" }, "slow");
				}
			});
		},
		cancel: function(){
			}
	});
}
</script>