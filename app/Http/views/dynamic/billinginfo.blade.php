<script type="text/javascript">
function fun_addBillinginfo(customerAddressID,typeID) /*Open addedit Billing Info page*/
{	
	tb_show("<h4 style='margin:0px 6px;'>Billing Information</h4>","{{url('/')}}/customeraddressaddedit?d=&c=Pages_controllers&m=customeraddressaddedit&customerAddressID="+customerAddressID+"&typeID="+typeID+"&popup=true&KeepThis=true&height=600&width=690&TB_iframe=true");
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
      <h6><i class="fa fa-money"></i>Billing Information </h6>
      <div class="col-sm-12 col-md-12 col-xs-12 billing_detail_method">
		  @if($customerAddressRecordCount>0)
              @foreach($qGetCustomerAddressData as $getBillingAddressData)
              	<div class="col-sm-6 col-xs-12 col-md-6">
                  <div class="inner_billing_detail">
                      <h4>{{$getBillingAddressData->firstName}} {{$getBillingAddressData->lastName}}</h4>
                      <span><b>Address 1 </b>: &nbsp; {{$getBillingAddressData->address1}}</span>
                      @if(strlen($getBillingAddressData->address2)>0)<span><b>Address 2 </b> : &nbsp;{{$getBillingAddressData->address2}}</span>@endif
                      <span><b>city </b> : &nbsp;{{$getBillingAddressData->city}} </span>
                      <span><b>state </b> : &nbsp;{{$getBillingAddressData->stateName}} </span>
                      <span><b>country </b> : &nbsp;{{$getBillingAddressData->countryName}}, {{$getBillingAddressData->zipcode}}</span>
                      @if(strlen($getBillingAddressData->phone)>0)<span><b>Phone No </b> : &nbsp;{{$getBillingAddressData->phone}}</span>@endif
                      <?php /*?><span><b>Email </b> :  &nbsp; priyank.consultpr@gmail.com</span><?php */?>
                      <h5><a href="javascript:fun_addBillinginfo({{$getBillingAddressData->customerAddressID}},{{$getBillingAddressData->typeID}})">Edit <i class="fa fa-pencil" aria-hidden="true"></i> </a></h5>
                  </div>
              </div>
              @endforeach
		  @endif
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
              <div class="contact-submit">
                  <a href="javascript:fun_addBillinginfo(0,2)" class="btn btn-contact btn-green"><span><i class="fa fa-plus" aria-hidden="true" style="font-size: 12px; margin-right:6px;"></i> Add New</span></a>
              </div>
          </div>
      </div>
      <?php /*?><div class="col-sm-12 col-md-12 col-xs-12">
          <div class="table-responsive">
              <table class="edu-table-responsive cart_table table-hover table-bordered">
                  <thead>
                      <tr class="heading-table">
                          <th>Action</th>
                          <th>Primary</th>
                          <th>Card Number</th>
                          <th>Card Type</th>
                          <th>Exp. Month</th>
                          <th>Exp.Year</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>
                              <a href="#" class="belling_table_edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="belling_table_edit"><i class="fa fa-trash" aria-hidden="true"></i></a>
                          </td>
                          <td><input type="radio" name="primary" value="" autocomplete="off"></td>
                          <td>XXXX-XXXX-XXXX-2312	</td>
                          <td>Visa</td>
                          <td>3</td>
                          <td>2017</td>
                      </tr>
                      <tr>
                          <td>
                              <a href="#" class="belling_table_edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="belling_table_edit"><i class="fa fa-trash" aria-hidden="true"></i></a>
                          </td>
                          <td><input type="radio" name="primary" value="" autocomplete="off"></td>
                          <td>XXXX-XXXX-XXXX-2312	</td>
                          <td>Visa</td>
                          <td>3</td>
                          <td>2017</td>
                      </tr>
                      <tr>
                          <td>
                              <a href="#" class="belling_table_edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="belling_table_edit"><i class="fa fa-trash" aria-hidden="true"></i></a>
                          </td>
                          <td><input type="radio" name="primary" value="" autocomplete="off"></td>
                          <td>XXXX-XXXX-XXXX-2312	</td>
                          <td>Visa</td>
                          <td>3</td>
                          <td>2017</td>
                      </tr>
                  </tbody>
              </table>
          </div>                                	
      </div><?php */?>
  </div>
</div>
