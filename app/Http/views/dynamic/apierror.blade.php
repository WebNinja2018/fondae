<div class="api_auto">

	<div class="api_details">

		<?php session_start();
				
			$resArray=$_SESSION['reshash'];?>
            <table width="280">

                <tr>

                    <td colspan="2" class="header">The PayPal API has returned an error!</td>

                </tr>

                <?php  
					
                    if(isset($_SESSION['curl_error_no'])) { 

                    $errorCode= $_SESSION['curl_error_no'] ;

                    $errorMessage=$_SESSION['curl_error_msg'] ;	

                    session_unset();	

                ?>

                <tr>

                    <td>Error Number:</td>

                    <td><?php echo $errorCode; ?></td>

                </tr>

                <tr>

                    <td>Error Message:</td>

                    <td><?php echo $errorMessage; ?></td>

                </tr>

            </table>

        <?php } else { ?>

            <table width = 400>

                <?php 

                foreach($resArray as $key => $value) {

                    echo "<tr><td class='name_details'> $key:</td><td>$value</td>";

                }	

                ?>

            </table>

        <?php }?>

        <br>

        <?php  $referrerUrl=Session::get('referrerUrl')?Session::get('referrerUrl'):url('/');?>

        <a href="<?php echo $referrerUrl;?>"><input type="button" value="< Back" name="" class="checkoutbtn"></a>

    

    

    </div>

</div>



