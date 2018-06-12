<div class="modal fade" id="myModal_{{ $getImageTypeListDate->imagesID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $getImageTypeListDate->caption }}</h4>
      </div>

      <div class="modal-body">
      	@if($getImageTypeListDate->imagesTypeID==2)
        	<img src="{{ url('/') }}/upload/news/images/{{ $getImageTypeListDate->itemID }}/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
        @if($getImageTypeListDate->imagesTypeID==3)
        	<img src="{{ url('/') }}/upload/portfolio/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
        @if($getImageTypeListDate->imagesTypeID==4)
        	<img src="{{ url('/') }}/upload/product/images/{{ $getImageTypeListDate->itemID }}/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
        @if($getImageTypeListDate->imagesTypeID==5)
        	<img src="{{ url('/') }}/upload/event/images/{{ $getImageTypeListDate->itemID }}/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
        @if($getImageTypeListDate->imagesTypeID==6)
        	<img src="{{ url('/') }}/upload/gallery/images/{{ $getImageTypeListDate->itemID }}/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
        @if($getImageTypeListDate->imagesTypeID==7)
        	<img src="{{ url('/') }}/upload/services/images/{{ $getImageTypeListDate->itemID }}/{{ $getImageTypeListDate->imagesName }}" width="558" />
      	@endif
      </div>
    </div>
  </div>
</div>