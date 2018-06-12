<script type="text/javascript">
function fun_addBillinginfo(customerAddressID,typeID) /*Open addedit Billing Info page*/
{	
	tb_show("<h4 style='margin:0px 6px;'>Shipping Information</h4>","{{url('/')}}/customeraddressaddedit?d=&c=Pages_controllers&m=customeraddressaddedit&customerAddressID="+customerAddressID+"&typeID="+typeID+"&popup=true&KeepThis=true&height=600&width=690&TB_iframe=true");
}
</script>
<style>
	#TB_title {height: 40px;background: #86bc42;color: #fff;}
	#TB_ajaxWindowTitle {padding: 10px;}
	#TB_closeAjaxWindow { padding:10px;}
	#TB_window { border:4px solid #86bc42;}
</style>
<div class="col-md-8 col-sm-8 col-xs-12 myaccount_inner">
  <div class="method-item right_form">
      <h6><i class="fa fa-truck"></i>Shipping Information </h6>
      <div class="col-sm-12 col-md-12 col-xs-12 billing_detail_method">
		  @if($customerAddressRecordCount>0)
              @foreach($qGetCustomerAddressData as $getShippingAddressData)
          	  	<div class="col-sm-6 col-xs-12 col-md-6">
                      <div class="inner_billing_detail">
                          <h4>{{$getShippingAddressData->firstName}} {{$getShippingAddressData->lastName}}</h4>
                          <span><b>Address 1 </b>: &nbsp; {{$getShippingAddressData->address1}}</span>
                          @if(strlen($getShippingAddressData->address2)>0)<span><b>Address 2 </b> : &nbsp;{{$getShippingAddressData->address2}}</span>@endif
                          <span><b>city </b> : &nbsp;{{$getShippingAddressData->city}} </span>
                          <span><b>state </b> : &nbsp;{{$getShippingAddressData->stateName}} </span>
                          <span><b>country </b> : &nbsp;{{$getShippingAddressData->countryName}}, {{$getShippingAddressData->zipcode}}</span>
                          @if(strlen($getShippingAddressData->phone)>0)<span><b>Phone No </b> : &nbsp;{{$getShippingAddressData->phone}}</span>@endif
                          <?php /*?><span><b>Email </b> :  &nbsp; priyank.consultpr@gmail.com</span><?php */?>
                          <h5><a href="javascript:fun_addBillinginfo({{$getShippingAddressData->customerAddressID}},{{$getShippingAddressData->typeID}})">Edit <i class="fa fa-pencil" aria-hidden="true"></i> </a></h5>
                      </div>
                  </div>
			  @endforeach
		  @endif
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <div class="contact-submit">
                  <a href="javascript:fun_addBillinginfo(0,1)" class="btn btn-contact btn-green"><span><i class="fa fa-plus" aria-hidden="true" style="font-size: 12px; margin-right:6px;"></i> Add New</span></a>
              </div>
          </div>
      </div>
  </div>
</div>
