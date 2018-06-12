<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Custom;
use Image;
use Session;
use DB;
use Mail;
use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Frm_contactus;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;
use App\Http\Models\Emailsetting;
use App\Http\Models\Product_price;
use App\Http\Models\Country;
use App\Http\Models\Globalsetting;
use App\Http\Models\Cart;
use App\Http\Models\Cart_detail;
use App\Http\Models\Customer_address;
use App\Http\Models\Orders;
use App\Http\Models\Order_details;
use App\Http\Models\Customer;
use App\Http\Models\Product;

class Payment_controllers extends Controller {

    public function confirmOrder(Request $request) {

        //echo "Please do not close browser or  press back button <br>";

        $cartData = array('uID' => $_COOKIE['uID']);
        $Cart = new Cart;
        $cartResult = $Cart->getCardDataWithPrice($cartData);
        $data['cartResult'] = $cartResult;
        $qGetCartData = $cartResult['data'];
        $cartRecordCount = $cartResult['recordCount'];
        $cartPrice = $cartResult['price'];
        $cartID = $qGetCartData[0]->cartID;
        $couponCode = $qGetCartData[0]->couponCodeID;
        Session::set('cartID', $cartID); //Session set cartID
        $cartDetailID = $qGetCartData[0]->cartDetailID;

        if ($qGetCartData[0]->billingID > 0) {
            $Customer_address = new Customer_address;
            $addressData = array('customerAddressID' => $qGetCartData[0]->billingID);
            $addressResult = $Customer_address->getByAttributesQuery($addressData);
            $data['qGetBillingAddressData'] = $addressResult['data'];
            $data['billingAddressRecordCount'] = $addressResult['recordCount'];
        }
        //$customerID = $data['qGetBillingAddressData'][0]->customerID;
        //$firstName = $data['qGetBillingAddressData'][0]->firstName;
        //$lastName = $data['qGetBillingAddressData'][0]->lastName;
        //$address1 = $data['qGetBillingAddressData'][0]->address1;
        //$address2 = $data['qGetBillingAddressData'][0]->address2;
        //$city = $data['qGetBillingAddressData'][0]->city;
        //$state =$data['qGetBillingAddressData'][0]->state;
        //$zip = $data['qGetBillingAddressData'][0]->zipcode;

        $orderID = Session::get('orderID') ? Session::get('orderID') : 0;

        $amount = $request->grandTotal;

        // Payment Processing [START]
        $this->validate($request, array('grandTotal' => 'required'));

        require_once('stripe/init.php');

        //dd($request);
        $totalPrice = $request->input('grandTotal') * 100;
        $adminPrice = $totalPrice * 0.1;
        $customrePrice = $totalPrice * 0.9;
        $adminToken = $request->input('adminToken');
        $customerToken = $request->input('customerToken');
        $customerSeceretKey = $request->input('customer_sk_value');

        $stripkey = Globalsetting::where('globalsettingname', 'stripe_key')->first();
        // \Stripe\Stripe::setApiKey($stripkey->globalsettingvalue);

        \Stripe\Stripe::setApiKey ('sk_live_WyHRTQGrAzZ9o5cnIpcNGUos');
        try {
            \Stripe\Charge::create(array(
                "amount" => $adminPrice,
                "currency" => "usd",
                "source" => $adminToken,
                "description" => "Pay to admin",
                "metadata" => array("firstName" => Session::get('firstName'),
                    "lastName" => Session::get('lastName'),
                    "email" => Session::get('email')
                ),
            ));
            //Session::flash ( 'success-message', 'Payment done successfully !' );          
        } catch (\Exception $e) {


            Session::flash('fail_message', "Oops...it seems there was a glitch. It does this from time to time. Your card was not charged. Enter your card info again.");
            return Redirect::back();
        }

        \Stripe\Stripe::setApiKey($customerSeceretKey);
        try {
            \Stripe\Charge::create(array(
                "amount" => $customrePrice,
                "currency" => "usd",
                "source" => $customerToken,
                "description" => "Pay to customer",
                "metadata" => array("firstName" => Session::get('firstName'),
                    "lastName" => Session::get('lastName'),
                    "email" => Session::get('email')
                ),
            ));
            //Session::flash ( 'success-message', 'Payment done successfully !' );          
        } catch (\Exception $e) {

            Session::flash('fail_message', "Oops...it seems there was a glitch. It does this from time to time. Your card was not charged. Enter your card info again.");
            return Redirect::back();
        }

        if ($orderID > 0) {

            $orderData = array(
                'customerID' => $request->customerID,
                'billingID' => '00000000',
                'shippingID' => '00000000',
                'grandTotal' => $amount,
                'subTotal' => $amount,
                'shippingTotal' => $amount,
                'discount' => 0,
                'tax' => 0,
                'paymentMethod' => 0,
                'discountCouponID' => 0,
                'eventType' => 1
            );

            $Orders = new Orders;
            $query = $Orders->where('orderID', $orderID)
                    ->update($orderData);

            Order_details::where('orderID', $orderID)->delete(); //Delete Order Details
            //ADD Order Details[Start]
            foreach ($qGetCartData as $qGetCartResult) {
                $orderDetailData = array(
                    'customerID' => $request->customerID,
                    'productID' => $qGetCartResult->productID,
                    'sizeID' => $qGetCartResult->sizeID,
                    'itemID' => 0,
                    'orderID' => $orderID,
                    'cardID' => $qGetCartResult->cardID,
                    'productName' => $qGetCartResult->productName,
                    'price' => $amount,
                    'product_quantity' => 1,
                    'total' => $amount * 1,
                    'itemName' => '',
                    'sizeName' => $qGetCartResult->sizeName
                );
                $Order_details = new Order_details($orderDetailData);
                $Order_details->save();
                $orderDetailsID = $Order_details->orderDetailsID;
                Session::set('orderDetailsIDD', $orderDetailsID); //Session set orderID 
            }
            //ADD Order Details[End]
        } else {
            $orderData = array(
                'customerID' => $request->customerID,
                'billingID' => '00000',
                'orderNumber' => 1,
                'shippingID' => '00000',
                'grandTotal' => $amount,
                'subTotal' => $amount,
                'shippingTotal' => $amount,
                'discount' => 0,
                'tax' => 0,
                'orderStatus' => 1,
                'paymentMethod' => 0,
                'discountCouponID' => 0,
                'orderTypeID' => 1,
                'eventType' => 1
            );

            $Orders = new Orders($orderData);
            $Orders->save();
            $orderID = $Orders->orderID;

            $orderNumber = date('Ymd', strtotime('now')) . $orderID;
            $orderInfo = array('orderNumber' => $orderNumber);
            $Orders = new Orders;
            $query = $Orders->where('orderID', $orderID)
                    ->update($orderInfo);

            Session::set('orderID', $orderID); //Session set orderID

            foreach ($qGetCartData as $qGetCartResult) {
                $orderDetailData = array(
                    'customerID' => $request->customerID,
                    'productID' => $qGetCartResult->productID,
                    'sizeID' => $qGetCartResult->sizeID,
                    'itemID' => 0,
                    'orderID' => $orderID,
                    'cardID' => $qGetCartResult->cardID,
                    'productName' => $qGetCartResult->productName,
                    'price' => $amount,
                    'product_quantity' => 1,
                    'total' => $amount * 1,
                    'itemName' => '',
                    'sizeName' => $qGetCartResult->sizeName
                );
                $Order_details = new Order_details($orderDetailData);
                $Order_details->save();
                $orderDetailsID = $Order_details->orderDetailsID;
                Session::set('orderDetailsIDD', $orderDetailsID); //Session set orderID 
            }
        }






        //$this->orderMail();  //Order Mail

        $customerid = Customer::where('customerID', $request->customerID)->first();
        $emaill = $customerid['email'];
        $getproduct = Product::where('productID', $qGetCartResult->productID)->first();
        $product_name = $getproduct['productName'];
        /* mail send to customer */
        Mail::send("emails.payment-sucess", [
            'amount' => $amount, 'event_name' => $product_name,
                ], function($m) use($emaill) {
            $m->to($emaill)->subject('Thanks for your Donation');
        });

        //Delete Cart Record[Start]
        $cartID = Session::get('cartID') ? Session::get('cartID') : 0;
        $cartResult = Cart::find($cartID);
        Cart::destroy($cartID);
        Cart_detail::destroy($cartResult->cartDetailID);
        //Delete Cart Record[End]

        $data = array('productID' => $qGetCartResult->productID, 'sizeID' => $qGetCartResult->sizeID);
        if ($qGetCartResult->sizeID != 1) {
            $Product_price = new Product_price;
            $productDetaile = $Product_price->where($data)->decrement('remainingQuantity');
        }

        $userid = Product::where('productID', $qGetCartResult->productID)->first();

        $owner_data = Customer::where('customerID', $userid->createdBy)->first();


        //email send to project owner


        Mail::send("emails.thanks-doner", [
            'amount' =>
            $amount, 'useremail' => $customerid['email'], 'clientname' => $customerid['firstName'], 'lastname' => $customerid['lastName'], 'event_name' => $product_name,
                ], function($m)use($owner_data) {
            $m->to($owner_data['email'])->subject('New Donation Received');
        });

        /* admin mail */
        $getAdminMail = Emailsetting::where('isActive',1)->get();
                foreach ($getAdminMail as $val) {
        Mail::send("emails.payment_created", [
            'amount' => $amount, 'useremail' => $customerid['email'], 'clientname' => $customerid['firstName'], 'lastname' => $customerid['lastName'], 'event_name' => $product_name,
                ], function($m)use($val) {
            $m->to($val->email)->subject('New Donation Received ');
        });

                }
        

        $_POST['formID'] = \Config::get('config.orderFormID', 8);
        return Redirect::fun_redirect(url('/') . '/thankyou?status=paymentdone')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
    }

    public function doDirectPayment() {
        include(public_path() . '/app/Http/Controllers/payment/doDirectPayment_controllers.php');
    }

    public function doExpressCheckout() {
        include(public_path() . '/app/Http/Controllers/payment/doExpressCheckout_controllers.php');
    }

    public function completeExpressCheckout() {
        require_once 'paypal/CallerService.php';

        $token = urlencode($_SESSION['token']);
        $paymentAmount = urlencode($_SESSION['TotalAmount']);
        $paymentType = urlencode($_SESSION['paymentType']);
        $currCodeType = urlencode($_SESSION['currCodeType']);
        $payerID = urlencode($_SESSION['payer_id']);
        $serverName = urlencode($_SERVER['SERVER_NAME']);

        $nvpstr = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTACTION=' . $paymentType . '&AMT=' . $paymentAmount . '&CURRENCYCODE=' . $currCodeType . '&IPADDRESS=' . $serverName;
        $resArray = hash_call("DoExpressCheckoutPayment", $nvpstr);
        $ack = strtoupper($resArray["ACK"]);
        if ($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING') {
            $_SESSION['reshash'] = $resArray;
            $location = url('/') . "/apierror";
            header("Location: $location");
        } else {
            $sucessdata = serialize(@$resArray);
            $orderID = Session::get('orderID') ? Session::get('orderID') : 0;
            $cartID = Session::get('cartID') ? Session::get('cartID') : 0;

            $orderdata = array('orderStatus' => 2, 'transactionID' => $resArray['TRANSACTIONID'], 'correlationID' => $resArray['CORRELATIONID'], 'paymentResponse' => $sucessdata);

            $Orders = new Orders;
            $query = $Orders->where('orderID', $orderID)
                    ->update($orderdata);

            //Delete Cart Record[Start]
            $cartID = Session::get('cartID') ? Session::get('cartID') : 0;
            $cartResult = Cart::find($cartID);
            Cart::destroy($cartID);
            Cart_detail::destroy($cartResult->cartDetailID);
            //Delete Cart Record[End]

            $this->orderMail();  //Order Mail

            $_POST['formID'] = \Config::get('config.orderFormID', 8);
            return Redirect::fun_redirect(url('/') . '/thankyou')->with(array('flash_message' => '')); // fun_redirect Function Create In vendor/laravel/framework/src/Illuminate/Support/Facades/Redirect.php
        }
    }

    public function orderMail() {
        include(public_path() . '/app/Http/Controllers/payment/orderMail_controllers.php');
    }

}
