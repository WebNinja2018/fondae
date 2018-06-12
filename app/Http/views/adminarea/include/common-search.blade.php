<?php if($fileName=='property'){?>
    <form name="frm_property_list" id="frm_property_list" method="post" action="<?php echo base_url()?>property" >
    <input type="hidden" id="currentPage" name="currentPage" value="<?php echo $currentPage; ?>">
    <input type="hidden" id="propertyUniqueID" name="propertyUniqueID" value="" />
    <input type="hidden" name="fieldname" value="<?php echo $this->input->post('fieldname'); ?>" />
    <input type="hidden" name="order" value="<?php echo $this->input->post('order'); ?>" />
    <input type="hidden" name="method" value="" />
    <input type="hidden" name="status" value="" />
        <section class="content-header top_header_content" id="advance_search_col" style="display:none;"> 
            <div class="box">
                <div class="box-title with-border">
                    <h2>Advance Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="search_box_col">
                        <div class="row">
                            <div class="form-group">
                            <div class="col-sm-6 col-md-12 col-xs-12">
                                 <div class="col-sm-8 col-md-3 col-xs-3">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <input class="form-control" name="searchByName" id="searchByName" value="<?php echo $searchByName;?>" placeholder="Property Name" type="text">
                                             </div>
                                        </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-5 col-md-3 col-xs-5">
                                     <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <select class="form-control" name="searchByType" id="searchByType">
                                                    <option value="">Property Type</option>
                                                    <option value="1" <?php if($searchByType == 1){?> selected <?php }?>>Commercial</option>
                                                    <option value="2" <?php if($searchByType == 2){?> selected <?php }?>>Residential</option>
                                                </select>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-5 col-md-3 col-xs-5">
                                     <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <select class="form-control" name="searchByStatus" id="searchByStatus">
                                                    <option value="">Property Status</option>
                                                    <option value="0" <?php if($searchByStatus == 1){?> selected <?php }?>>Inactive</option>
                                                    <option value="1" <?php if($searchByStatus == 1){?> selected <?php }?>>Active</option>
                                                </select>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-5 col-md-3 col-xs-5">
                                     <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <button id="searchSubmit" name="save" type="submit" class="btn btn-warning waves-effect waves-light">Submit</button>
                                                <button id="searchReset" name="save" type="submit" class="btn btn-default waves-effect waves-light">Reset</button>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer-->
           </div>
        </section>
<?php }?>