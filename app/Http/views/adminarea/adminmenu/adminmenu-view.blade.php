<div class="modal fade" id="myModal_<?php echo $GetAllNews->newsID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $GetAllNews->newsTitle; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $GetAllNews->body; ?>
      </div>
    </div>
  </div>
</div>