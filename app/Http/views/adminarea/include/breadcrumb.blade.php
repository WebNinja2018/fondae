<ol class="breadcrumb">
    <li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <?php if(strlen($this->uri->segment(1))>0 && strlen($this->uri->segment(2))>0){?>
    	<li><a href="<?php echo base_url().$this->uri->segment(1);?>"><?php echo ucfirst(str_replace("_"," ",$this->uri->segment(1))).' '.'Management';?></a></li>
	<?php }else{?>
		<li><a href="#"><?php echo ucfirst(str_replace("_"," ",$this->uri->segment(1))).' '.'Management';?></a></li>	
	<?php }?>
    <?php if(strlen($this->uri->segment(2))>0){
			if($this->uri->segment(2)=='addedit'.$this->uri->segment(1)){?>
    			<li><a href="#"><?php echo 'Add '.ucfirst(str_replace("_"," ",$this->uri->segment(1)));?></a></li>
            <?php }else{?>
    			<li><a href="#"><?php echo ucfirst(str_replace("_"," ",$this->uri->segment(1))).' View';?></a></li>
			<?php }?>
	<?php }?>
</ol>
<div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
    <div class="advance_button">
        <a class="" href="#" id="advance_search" onclick="funToggleSearch('Property');"><i class="fa fa-search"></i>&nbsp; Search</a>
    </div>
</div>
<section class="content-header top_header_content" id="searchSectionProperty" style=" display:none;"> 
	<div class="row">
        <div class="box">
            <div class="box-title with-border">
                <h2>Search Area</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-footer">
                <div class="search_box_col">
                    <div class="row">
                        <div class="form-group">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-3 col-xs-3 col-sm-3">
                                 <div class="row">
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <div class="row">
                                            <select class="form-control" name="searchByType" id="searchByType">
                                                <option value="">-- Select Alphabetics--</option>
                                                <option value="2">A</option>
                                                <option value="1">B</option>
                                                <option value="1">C</option>
                                                <option value="1">D</option>
                                                <option value="1">E</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                             </div>
                             <div class="col-sm-3 col-md-3 col-xs-3">
                                <div class="row">
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <div class="row">
                                            <input class="form-control" name="searchByName" id="searchByName" value="" placeholder="Page name" type="text">
                                         </div>
                                    </div>
                                 </div>
                             </div>
                             <div class="col-md-3 col-xs-3 col-sm-3">
                                 <div class="row">
                                    <div class="col-md-10 col-xs-10 col-sm-10">
                                        <div class="row">
                                            <select class="form-control" name="searchByType" id="searchByType">
                                                <option value="">-- Select --</option>
                                                <option value="2">Active</option>
                                                <option value="1">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                             </div>
                             <div class="col-md-3 col-xs-5">
                                 <div class="row">
                                    <div class="col-md-11">
                                        <div class="row">
                                            <button id="searchSubmit" name="save" type="submit" class="btn btn-warning waves-effect waves-light">Submit</button>
                                            <button id="searchReset" name="save" type="submit" class="btn btn-primary waves-effect waves-light">Reset</button>
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
   </div>
</section>
