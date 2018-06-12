<div class="modal fade" id="myModal_{{ $GetAllProduct->productID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllProduct->productName}}</h4>
      </div>
	  <div class="modal-body">
      	<table class="table table-striped table-bordered">
       		 <tr>
                <th style="width:30%;">Event Name</th>
                <td> {{ $GetAllProduct->productName}}</td>
            </tr>
           <?php /*?> <tr>
                <th style="width:30%;">Event Number </th>
                <td>{{ $GetAllProduct->itemnumber}}</td>
            </tr><?php */?>
			<tr>
                <th style="width:30%;">Conference Date </th>
                <td>{{ date('m/d/Y',strtotime($GetAllProduct->productDate))}}</td>
            </tr>
			<tr>
                <th style="width:30%;">Start Time </th>
                <td>{{ $GetAllProduct->event_time}}</td>
            </tr>
			
            <tr>
                <th style="width:30%;">Availability Status </th>
                 <td>@if($GetAllProduct->availabilityStatus == 1) Available @else Not Available @endif </td>
            </tr>
            <tr>
                <th style="width:30%;">Long Description</th>
                <td>{!! $GetAllProduct->longDescription!!}</td>
            </tr>
            <tr>
                <th style="width:30%;">Short Description</th>
                <td>{!! $GetAllProduct->shortDescription!!}</td>
            </tr>
            <tr>
                <th style="width:30%;">Status</th>
                <td>@if($GetAllProduct->isActive == 1) Active @else InActive @endif</td>
            </tr>
            <tr>
                <th style="width:30%;">Featured</th>
                <td>@if($GetAllProduct->isFeatured == 1) Yes @else No @endif</td>
            </tr>
            @if(strlen($GetAllProduct->prodcutImage)>0)
            <tr>
                <th style="width:30%;">Event Image</th>
                <td><img src="{{ url('/') }}/upload/product/mainimages/th_{{ $GetAllProduct->prodcutImage}}" /></td>
            </tr>
            @else
            <tr>
                <th style="width:30%;">Event Image</th>
                <td><img src="{{ url('/') }}/components/images/no-images.png" alt="" title="" /></td>
            </tr>
            @endif
       </table>
       </div>
    </div>
  </div>
</div>