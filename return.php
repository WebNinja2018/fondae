<?php

require_once ('stripe/lib/Stripe.php');
require_once('stripe/init.php');

  /*
   *  @author   Gopal Joshi
   *  @about    Stripe Payment Gateway integration Payment Form
   *  @tutorial http://sgeek.org/integrate-stripe-payment-gateway-using-php-javascript/
   */

	if(!empty($_POST['stripeToken'])){
		Stripe::setApiKey("sk_test_AKasas32OvBiI2HlWgH4olfQ2");

		// Token submitted by the form:
		$token = $_POST['stripeToken'];

		// Charge the user's card:
		$charge = \Stripe\Charge::create(array(
		  "amount" => $_POST['amount'],
		  "currency" => "usd",
		  "description" => "SSL Certificate (Demo Product)",
		  "source" => $token,
		  "metadata" => array("purchase_order_id" => "SKA92712382139") // Custom parameter
		));

		$chargeJson = json_decode($charge);

		if($chargeJson['amount_refunded'] == 0 && $chargeJson['failure_code'] == null && $chargeJson['captured'] == true){
			echo "Payment completed successfully";
		}else{
			echo "Payment has been failed";
		}
	}else{
		echo "Payment has been failed";
	}