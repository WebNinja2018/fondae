<div class="modal fade" id="myModal_{{ $GetAllSlideshow->slideshowID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllSlideshow->caption1}}</h4>
      </div>
      <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Caption 1 </th>
                    <td>{{ $GetAllSlideshow->caption1}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Caption 2 </th>
                    <td>{{ $GetAllSlideshow->caption2}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Date </th>
                    <td>{{ date('m/d/Y',strtotime($GetAllSlideshow->created_at))}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status </th>
                    <td>@if($GetAllSlideshow->isActive == 1) Active @else InActive @endif</td>
                </tr>
                @if(strlen($GetAllSlideshow->imagesName)>0)
                <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/upload/slideshow/{{ $GetAllSlideshow->imagesName }}"  width="400"/></td>
                </tr>
                @endif
             </table>
        </div>
    </div>
  </div>
</div>