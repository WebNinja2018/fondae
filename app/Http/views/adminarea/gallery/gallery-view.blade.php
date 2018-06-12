<div class="modal fade" id="myModal_{{ $GetAllGallery->galleryID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllGallery->galleryTitle}}</h4>
      </div>
	  <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Gallery Title </th>
                    <td>{{ $GetAllGallery->galleryTitle}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status</th>
                    <td>@if($GetAllGallery->isActive == 1) Active @else InActive @endif</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Featured </th>
                    <td>@if($GetAllGallery->featured == 1) Yes @else No @endif</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Date </th>
                    <td>{{ date('m/d/Y',strtotime($GetAllGallery->created_at))}}</td>
                </tr>
                @if(strlen($GetAllGallery->galleryMainImage)>0)
                <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/upload/gallery/{{ $GetAllGallery->galleryMainImage }}" width="400" /></td>
                </tr>
                @endif
             </table>
      </div>
    </div>
  </div>
</div>