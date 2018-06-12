<?php 
try {	
	$amount=$_POST['amount'];
	$Secretkey='sk_test_JHkeSk0TcHyltgBvCTfDD9f2';
	require_once('Stripe/lib/Stripe.php');
	Stripe::setApiKey($Secretkey); //Replace with your Secret Key
	
	$charge = Stripe_Charge::create(array(
		"amount" => $amount*100,
		"currency" => "usd",
		"card" => $_POST['stripeToken'],
		"description" => "Demo Transaction"
	));
	//send the file, this line will be reached if no error was thrown above
	echo "<h1>Your payment has been completed.</h1>";
	//you can send the file to this email:
	echo $_POST['stripeEmail'];
}

catch(Stripe_CardError $e) {
	echo "p1";
}

//catch the errors in any way you like

catch (Stripe_InvalidRequestError $e) {
  // Invalid parameters were supplied to Stripe's API
	echo "p2";
} catch (Stripe_AuthenticationError $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
	echo "p3";
} catch (Stripe_ApiConnectionError $e) {
  // Network communication with Stripe failed
  echo "p4";
} catch (Stripe_Error $e) {
	echo "p5";
  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
echo "p6";
  // Something else happened, completely unrelated to Stripe
}
?>