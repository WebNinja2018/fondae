<?php /*?><?php if($this->config->item('isClientValidationStop')!=1){ ?>
<script type="text/javascript">
	$.validator.setDefaults({
		submitHandler: function() { window.document.frm_blog.submit() }
	});
	$.metadata.setType("attr", "validate");
	$().ready(function() {
	// validate the comment form when it is submitted
	$("#frm_blog").validate({
		rules: {
			blogTitle: {required: true},
			description: {required: true},
			blogImage: {accept: "gif|jpg|bmp|png"},
	},
		messages: {
			blogTitle:"Please Enter Blog Title",
			description:"Please Enter Blog Description",
			blogImage:"File must be gif , jpg , bmp ,png "
			}
		});
	});
</script>
<?php } ?>
<?php 	
	$blogTitle=$this->input->post('blogTitle')?$this->input->post('blogTitle'):'';
	$description=$this->input->post('description')?$this->input->post('description'):'';
	$blogImage=$this->input->post('blogImage')?$this->input->post('blogImage'):''; 
	$currentPage = $this->input->post('currentPage')? $this->input->post('currentPage') : 1;
	$recordsPerPage = $this->input->post('recordsPerPage')? $this->input->post('recordsPerPage') : 10;
?>
     <div class="innerblog_success_text">
            <?php if(strlen($this->session->flashdata('Sucessmasg'))>0){?>
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <div class="alert alert-success" style="color:#060;" alert-dismissible role="alert">       
                <?php echo $this->session->flashdata('Sucessmasg')?>
              </div>
            <?php } ?>
			<?php //echo $this->input->post('Sucessmasg');
               $clientName=$this->input->post('clientName')?$this->input->post('clientName'):'';
               $designation=$this->input->post('designation')?$this->input->post('designation'):'';
               $details=$this->input->post('details')?$this->input->post('details'):'';
          ?>
    </div>    	
    
	<script type="text/javascript">
        $(document).ready(function() {
            $("#HideShow").click(function() {
                var $this = $(this);
                $("#HideForm").toggle(500)
                $this.toggleClass("expanded");
                <?php if(strlen($this->uri->segment(2)>0) || (strlen($this->uri->segment(1)>0))) {?>
                if ($this.hasClass("expanded")) {
                    $this.html("<h3>Hide Blog</h3>");
                } else {
                    $this.html("<h3>Add New Blog</h3>");
                }
                <?php }else{?>
                if ($this.hasClass("expanded")) {
                    $this.html("<h3>Add New Blog</h3>");
                } else {
                    $this.html("<h3>Hide Blog</h3>");
                }
                <?php } ?>
            });
        });
    </script>
    <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
         <div class="testimonial_hideshow">   
            <a id="HideShow" href="javascript:;"><?php if(strlen($this->uri->segment(2)>0)) {echo "<h3>Add New Blog</h3>";}else{echo "<h3>Hide Blog</h3>";}?></a>
         </div>
   	</div>
	<div class="innerblog_container">
      <div id="HideForm" <?php if(strlen($this->uri->segment(2)>0)) {?> style="display:none;" <?php }?> >
    	<form class="blog_form" name="frm_blog" id="frm_blog" method="post" action="<?php echo base_url();?>action/addblog" enctype="multipart/form-data">
            <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                    <div class="form-group">
                        <input type="text" name="blogTitle" id="blogTitle" value="<?php echo $blogTitle;?>" maxlength="50" placeholder="Blog Title*" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                    <div class="form-group">
                        <textarea placeholder="Description*" name="description" class="form-control"><?php echo $description;?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                    <div class="form-group">
                        <input type="file" name="blogImage" id="blogImage">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('CaptchaSiteKey');?>" style="float:left;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
                    <div class="form-group">
                        <button type="submit" name="save" value="Login" class="btn whishlist_btn">SUBMIT</button>
                    </div>
                </div>
            </div>
      	</form> 
     </div>
      <form name="frm_blog_details" method="post" id="frm_blog_details" action="#">
        <input type="hidden" name="currentPage" value="<?php echo $currentPage;?>" />
        <input type="hidden" name="recordsPerPage" value="<?php echo $recordsPerPage;?>" />
	  </form> 
      	  <div class="innerblog_form">
       	 	<div class="col-xs-12 col-sm-7 col-md-12 col-lg-12">
				<?php if($blogRecordCount > 0) {
                 foreach($qGetAllblogo as $GetAllblogo) { ?>
                    <div class="innerblog_comments_text">
                        <h4>News Image </h4>
                        <p>dssdf</p>
                    </div>
                 <?php } 
                }
                else
				{
					echo '<h3 align="center">No record found.</h3>';
				}?>
           </div>
         </div>
    </div>
    <div class="pagenavigation">
        <ul>
            <li><?php echo $paginationLinks;?></li>
        </ul>
    </div>
	<?php */?>

<?php /*?>


<div class="col-md-6 col-sm-6 col-xs-6 blog_form">
	<div class="row">
		<form>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Client Name">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Blog Title">
			</div>
			<div class="form-group">
				<textarea class="form-control blog_description" placeholder="Description"></textarea>
			</div>
			<div class="form-group">
				<div class="input-group">
					<input class="form-control" type="text" name="endDate" placeholder="Date" value="" id="endDate">
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				</div>
			</div>
			<div class="form-group">
				<input type="file" id="exampleInputFile">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</div><?php */?>
<div class="col-md-12 col-xs-12 col-sm-12 blogs">
	<div class="row"> 
		
		<h2>Blog Title</h2>
		<span>Date</span>
		<p>Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description</p>
		
	</div>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 blogs">
	<div class="row"> 
		<h2>Blog Title</h2>
		<span>Date</span>
		<p>Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description</p>
		
	</div>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 blogs">
	<div class="row"> 
		
		<h2>Blog Title</h2>
		<span>Date</span>
		<p>Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description</p>
		
	</div>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 blogs">
	<div class="row"> 
		
		<h2>Blog Title</h2>
		<span>Date</span>
		<p>Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description</p>
		
	</div>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 blogs">
	<div class="row"> 
		
		<h2>Blog Title</h2>
		<span>Date</span>
		<p>Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description Description</p>
		
	</div>
</div>

