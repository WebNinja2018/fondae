<div class="modal fade" id="myModal_{{  $GetAllTestimonials->testimonialsID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Testimonials View</h4>
      </div>
      
      <div class="modal-body">
        <table class="table table-striped table-bordered">
            <tr>
                <th style="width:30%;">Name </th>
                <td>{{ $GetAllTestimonials->clientName }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Designation </th>
                <td>{{ $GetAllTestimonials->designation }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Detail </th>
                <td>{!! $GetAllTestimonials->details !!}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Display Order </th>
                <td> {{ $GetAllTestimonials->displayOrder }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">isFeatured ?  </th>
                <td>@if($GetAllTestimonials->featured == 1) Yes @else No @endif</td>
            </tr>
            <tr>	
                <th style="width:30%;">Status </th>
                <td>@if($GetAllTestimonials->isActive == 1) Active @else InActive @endif</td>
            </tr>
		 	 @if(strlen($GetAllTestimonials->testimonial_img)>0)
            <tr>	
                <th style="width:30%;">Image </th>
                <td><img src="{{ url('/') }}/upload/testimonials/th_{{$GetAllTestimonials->testimonial_img}}" width="400" /></td>
            </tr>
             @else
            <tr>	
                <th style="width:30%;">Image </th>
                <td><img src="{{ url('/') }}/components/images/no-images.png" alt="" title="" width="400"  /></td>
            </tr>
            @endif
         </table>
        </div>
    </div>
  </div>
</div>