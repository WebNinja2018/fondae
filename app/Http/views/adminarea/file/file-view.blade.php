<div class="modal fade" id="myModal_{{ $getFileTypeListDate->fileID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $getFileTypeListDate->caption }}</h4>
      </div>

      <div class="modal-body">
      	@if($getFileTypeListDate->fileTypeID==2)
        	<a href="{{ url('/') }}/upload/news/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" > {{ $getFileTypeListDate->fileName }}</a>
      	@endif
        @if($getFileTypeListDate->fileTypeID==3)
        	<a href="{{ url('/') }}/upload/portfolio/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" >{{ $getFileTypeListDate->fileName }}</a>
      	@endif
        @if($getFileTypeListDate->fileTypeID==4)
        	<a href="{{ url('/') }}/upload/product/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" > {{ $getFileTypeListDate->fileName }}</a>
      	@endif
        @if($getFileTypeListDate->fileTypeID==5)
        	<a href="{{ url('/') }}/upload/event/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" > {{ $getFileTypeListDate->fileName }}</a>
      	@endif
        @if($getFileTypeListDate->fileTypeID==6)
        	<a href="{{ url('/') }}/upload/gallery/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" > {{ $getFileTypeListDate->fileName }}</a>
      	@endif
        @if($getFileTypeListDate->fileTypeID==7)
        	<a href="{{ url('/') }}/upload/services/file/{{ $getFileTypeListDate->itemID }}/{{ $getFileTypeListDate->fileName }}" target="_blank" > {{ $getFileTypeListDate->fileName }}</a>
      	@endif
      </div>
    </div>
  </div>
</div>