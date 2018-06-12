<div class="modal fade" id="myModal_{{  $GetAllCoupon->couponID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Coupon View</h4>
      </div>
      
      <div class="modal-body">
        <table class="table table-striped table-bordered">
            <tr>
                <th style="width:30%;">Name </th>
                <td>{{ $GetAllCoupon->couponName }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Coupon Code </th>
                <td>{{ $GetAllCoupon->couponCode }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Coupon StartDate </th>
                <td>{{ date('m/d/Y',strtotime($GetAllCoupon->couponStartDate)) }}</td>
            </tr>
			<tr>	
                <th style="width:30%;">Coupon EndDate </th>
                <td>{{ date('m/d/Y',strtotime($GetAllCoupon->couponEndDate)) }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Discount Type </th>
                <td> {{ $GetAllCoupon->discountType }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Discount Rate </th>
                <td> {{ $GetAllCoupon->discountRate }}</td>
            </tr>
			<tr>	
                <th style="width:30%;">Use Limit </th>
                <td> {{ $GetAllCoupon->useLimit }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Status </th>
                <td>@if($GetAllCoupon->isActive == 1) Active @else InActive @endif</td>
            </tr>
         </table>
        </div>
    </div>
  </div>
</div>