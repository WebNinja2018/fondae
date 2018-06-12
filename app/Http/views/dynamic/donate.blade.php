<script type="text/javascript">
  $.validator.setDefaults({
    submitHandler1: function() { window.document.frm_checkout.submit() }
  });
  $.metadata.setType("attr", "validate");
</script>

<h4>Step 2</h4>
<hr>
<?php 
use App\Http\Models\Product;
use App\Http\Models\Customer;
use App\Http\Models\Product_price;
use App\Http\Models\Cart;

if($qGetCartData[0]->sizeID==1){
  $product=new Product;
  $productDetaile=$product->find($qGetCartData[0]->productID);  
  $price=$productDetaile->price;
  $customerID=$productDetaile->createdBy;
  
  
  $customer = Customer::find($customerID);
  $customer_pk = $customer->stripe_pk;
  $customer_sk = $customer->stripe_sk;
}
else{
  $Product_price=new Product_price;
  $data=array('sizeID'=>$qGetCartData[0]->sizeID,'productID'=>$qGetCartData[0]->productID);
  $productDetaile=$Product_price->where($data)->get();
  $price=$productDetaile[0]->price;

    $product=new Product;
    $productDetaile=$product->find($qGetCartData[0]->productID);  
    $customerID=$productDetaile->createdBy;
    $customer = Customer::find($customerID);

    $customer_pk = $customer->stripe_pk;
    $customer_sk = $customer->stripe_sk;
}
 $userid=Session::get('customerID');
 $cartData = array('uID'=>$_COOKIE['uID']);
 $Cart= new Cart;
 $cartResult= $Cart->getCardDataWithPrice($cartData);
 $data['cartResult']= $cartResult;
 $qGetCartData = $cartResult['data'];
 $pricevalue= $qGetCartData[0]->priceID;
 if($pricevalue=='00')
   {
    $price='5';
   }
?>

<div class="col-sm-7">

  <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
    <form accept-charset="UTF-8" action="{{url('/')}}/payment/confirmOrder" class="require-validation"
          data-cc-on-file="false" id="payment-form" method="post">
    {{ csrf_field() }}
      <input type="hidden" name="referrerUrl" value="/donate" />
      <input type="hidden" name="customerID" value="{{$userid }}" />
      <input type="hidden" name="price" value="{{ $price}}" id="price" />
      <input type="hidden" name="admin_pk_value" value="pk_live_rOq962ZiLCyPRnhvAVUWtClj" id="admin_pk_value" />
      <input type="hidden" name="customer_pk_value" value="{{$customer_pk}}" id="customer_pk_value" />
      <input type="hidden" name="customer_sk_value" value="{{$customer_sk}}" id="customer_sk_value" />
          <div class="events_checkoutform">
              <div class="checking_out">
        <?php if($customer_pk && $customer_sk){ ?>
                  <div class="amount_details">
                      <a href="javascript:fun_donateAmount(25);">$25</a>
                      <a href="javascript:fun_donateAmount(50);">$50</a>
                      <a href="javascript:fun_donateAmount(75);">$75</a>
                      <a href="javascript:fun_donateAmount(100);">$100</a>
                      <a href="javascript:fun_donateAmount(250);">$250</a>
                      <br>
                     
          <div class='form-row form-group'>
            <div class='col-xs-4'><label>Card Number</label> </div>
            <div class='col-xs-8  card required'>
              <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder='XXXXXXXXXXXXXXXX' >
            </div>
          </div>
          <div class='form-row form-group'>
            <div class='col-xs-4'><label>Expiration/CVC</label> </div>
            <div class='col-xs-2  expiration required'>
              <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' >
            </div>            
            <div class='col-xs-3  expiration required'>
              <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' >
            </div>

            <div class='col-xs-3  cvc required'>
              <input autocomplete='off' class='form-control card-cvc' placeholder='514' size='3' type='text' >
            </div>
          </div>
          <div class='form-row form-group'>
            <div class='col-xs-4'><label>Donation Amount</label>
                                  <br><span>(Min Donation Amount ${!! $price!!})</span>
                                   </div>
            <div class="other_amount col-md-8">
                          <input type="number" class='form-control' value="{!! $price!!}" name="grandTotal" id="grandTotal" min="{{ $price}}" onchange="fun_amount(this.value)" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/> 
            </div>
          </div>
        
          <div class='form-row form-group' id="checkPrice" style="display:none;">
            <div class="form-btn">
              <button  type="submit" name="save" class="hvr-shutter-out-horizontal" style="border: none;border-radius: 3px; color: #fff; padding: 15px 55px; float: right; margin-right: 15px;">Pay »</button>                         
            </div>
            
          </div>
          <div class='form-row form-group'>
            <div class='col-md-12 error  hide'>
              <div class='alert-danger alert'>Please correct the errors and try again.</div>
            </div>
          </div>
          
            
                  </div>
        <?php }else{ ?>
        <div class="amount_details">
                      <a href="javascript:fun_donateAmount(25);">$25</a>
                      <a href="javascript:fun_donateAmount(50);">$50</a>
                      <a href="javascript:fun_donateAmount(75);">$75</a>
                      <a href="javascript:fun_donateAmount(100);">$100</a>
                      <a href="javascript:fun_donateAmount(250);">$250</a>
                      <br>
          <div class='form-row form-group'>
            <div class='col-md-12 error'>
              <div class='alert-danger alert'>Sorry, Because Customer has not Stripe Account, so you can not Donate.</div>
            </div>
          </div>
        </div>
        <?php } ?>
          
              </div>   
          </div>
  
          <div class="events_checkoutform">
             <script>
             window.onload = function() {
                var min_val=$("#grandTotal").val();
              
             fun_amount(min_val);
            };

        function fun_donateAmount(amt){
          document.getElementById('grandTotal').value = amt;
           $(".stripe-button").attr( "data-amount", amt*100 );
                                         
           price=$("#price").val()-1;

           if(4<amt){$("#checkPrice").show();}else{$("#checkPrice").hide();}
        }
        
        function fun_amount(amount){ 
            $(".stripe-button").attr( "data-amount", amount*100 );
                                            
            price=$("#price").val()-1;
            if(4<amount){$("#checkPrice").show();}else{$("#checkPrice").hide();}
        }
        $(function() {
          $('form#payment-form').bind('submit', function(e) {
          var $form  = $(e.target).closest('form'),
            inputSelector = ['input[type=email]', 'input[type=password]',
                     'input[type=text]', 'input[type=file]',
                     'textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid         = true;

          $errorMessage.addClass('hide');
          $('.has-error').removeClass('has-error');
          $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault(); // cancel on first error
            }
          });
          });
        });

        $(function() {
          var $form = $("#payment-form");

          $form.on('submit', function(e) {
          if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($('#customer_pk_value').val());
            Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
            }, adminResponseHandler);
          }
          if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($('#admin_pk_value').val());
            Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
            }, customerResponseHandler);
          }
          });

          function adminResponseHandler(status, response) {
          if (response.error) {
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text(response.error.message);
          } else {
            // token contains id, last4, and card type
            var token = response['id'];          
            // insert the token into the form so it gets submitted to the server
            //$form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='adminToken' value='" + token + "'/>");
            //$form.get(0).submit();
          }
          }
          
          function customerResponseHandler(status, response) {
          if (response.error) {
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text(response.error.message);
          } else {            
            var token = response['id'];            
            //$form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='customerToken' value='" + token + "'/>");
            $form.get(0).submit();
          }
          }
        })
        </script>
          </div>
</form>
</div>
<script>
$(document).keydown(function(event){
  if(event.keyCode==67){ 
     alert("Don't Try This!")
      return false;  //Prevent from ctrl+shift+i
   }
});
$(document).bind('contextmenu', function (e) {
  e.preventDefault();
}); 
</script>
