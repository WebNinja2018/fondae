<div class="col-sm-12 col-md-12 col-xs-12 ">
    <div class="row">
        <div class="thankyou_title">
            <h4 class="yello">Thank You </h4>
        </div>

<?php

    if(isset($_REQUEST['status']) && $_REQUEST['status']=='paymentdone'){

    ?>
              <div class="innerthanks_text">
                    <p>Thank you for your donation. We appreciate your support.</p>
                </div>

<?php }else{ ?>
       <?php if(isset($qGetMassageData[0]->message1)){	   
	   			$subject = $qGetMassageData[0]->message1;?>
                <div class="innerthanks_text">
                    <p>{!! $subject !!}</p>
                </div>
       <?php } 

}
       ?>
    </div>
    <?php

    if(isset($_REQUEST['status']) && $_REQUEST['status']=='paymentdone'){

    ?>
   <div class="container">
      <h2>Leave Comment </h2>

       <form action="{{ url('/action/addcomment') }}" method="POST">
          {{ csrf_field() }}
        <div class="form-group">
       
           
          <label for="email">Comment</label>
          <textarea  class="form-control" name='comment'></textarea>
        </div>
        <div class="checkbox">
          <label><input type="checkbox" name="display_name" value='1'>Hide Name From Comment</label>
        </div>
         <div class="checkbox">
          <label><input type="checkbox" name="display_amount" value='1'>Hide Donation Amount From Comment</label>
        </div>
        <input type="submit" class="">
      </form>
    </div>
<?php } ?>
</div>
        

</div><div class="clear-fix"></div>

