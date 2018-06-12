<div class="modal fade" id="myModal_<?php echo $GetAllCategory->categoryID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Category View</h4>
          </div>
          <div class="modal-body">
          	<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">ParentCategory Name </th>
                    <td><?php if(strlen($GetAllCategory->parentcategoryname)>0){echo $GetAllCategory->parentcategoryname;}else{echo 'Root Category';} ?></td>
                </tr>
                <tr>	
                	<th style="width:30%;">Category Name </th>
                    <td><?php echo $GetAllCategory->categoryname; ?></td>
                </tr>
                <tr>	
                	<th style="width:30%;">Date </th>
                    <td><?php echo date('m/d/Y',strtotime($GetAllCategory->created_at)); ?></td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status </th>
                    <td><?php if($GetAllCategory->isActive == 1) { echo "Active"; } else { echo "InActive";} ?></td>
                </tr>
             </table>
          </div>
           <?php /*?><div class="modal-body">
            <h5><b>Featured : </b></h5><?php if($GetAllCategory->isFeatured == 1) { echo "Yes"; } else { echo "No";} ?>
          </div><?php */?>
          </div>
      </div>
</div>