<?php foreach($getImageTypeSingleData as $getImageTypeSingleData){ ?>
<input type="hidden" name="imagesID" value="<?php echo $getImageTypeSingleData->imagesID; ?>" />
<div class="col-md-12">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-md-4">&nbsp;</div>
    </div>
    <div class="form-group">
        <label for="pageTitle" class="col-sm-2 control-label">Image </label>
        <div class="col-md-4">
            <input type="file" name="imagesName" id="imageName" class="form-control" size="50"/>
            <br/>
            <?php if($getImageTypeSingleData->imagesTypeID==2){?>
            	<img src="<?php echo $this->config->item('fe_url');; ?>upload/news/images/<?php echo $getImageTypeSingleData->imagesName; ?>" height="400" width="400" />
            <?php }else{?>
            	<img src="<?php echo $this->config->item('fe_url');; ?>upload/event/images/<?php echo $getImageTypeSingleData->imagesName; ?>" height="400" width="400" />
            <?php }?>
            <input type="hidden" name="imagesName_old" value="<?php echo $getImageTypeSingleData->imagesName; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Caption</label>
        <div class="col-md-4">
            <input name="caption" id="caption" size="40" class="form-control" type="text" maxlength="200" value="<?php echo $getImageTypeSingleData->caption; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="metaKeyword" class="col-sm-2 control-label">Display Order</label>
        <div class="col-md-4">
           <input name="displayOrder" id="displayOrder" size="10" class="form-control"  type="text" maxlength="5" value="<?php echo $getImageTypeSingleData->displayOrder; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="metaKeyword" class="col-sm-2 control-label">IsActive?</label>
        <div class="col-md-4">
           <input name="isActive" id="isActive" size="40" class="form-control" type="checkbox" value="1" <?php if($getImageTypeSingleData->isActive==1){ ?> checked="checked" <?php } ?>  >
        </div>
    </div>
</div>
<?php } ?>