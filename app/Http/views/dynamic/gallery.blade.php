<div class="gallery">
	<div class="row">
		
		@if($galleryRecordCount > 0)
            @foreach($qGetGalleryData as $resultGalleryData)
                @if((file_exists(public_path().'/upload/gallery/th_'.$resultGalleryData->galleryMainImage) && strlen($resultGalleryData->galleryMainImage) > 0)) {{--Conditon For if News image is Delete in folder. And 'rootPath' is set in config file--}}
                <div class="col-xs-6 col-sm-3 col-md-3">
                    <a class="thumbnail" href="{{ url('/').'/gallery-detail/'.$resultGalleryData->url_title}}">
                        <div class="gallery_images">
                            <img src="{{url('/').'/upload/gallery/th_'.$resultGalleryData->galleryMainImage}}" alt="">
                        </div>
                        <h2>{{$resultGalleryData->galleryTitle}}</h2>
                    </a>
                </div>
                
                @else
                <div class="col-xs-6 col-sm-3 col-md-3">
                    <a href="{{url('/').'/gallery-detail/'.$resultGalleryData->url_title}}">
                    <div class="gallery_lightbox">
                        <img src="{{ url('/').'/components/images/no-images.png'}}" alt="Image Not Available" title=""  />
                    </div>
                    <h2>{{$resultGalleryData->galleryTitle}}</h2>
                   </a>
                 </div>
                @endif
            @endforeach
		@else
			<h3 align="center">Record not found</h3>
		@endif
	</div>
</div>
<div class="pagenavigation">
    <ul>
        <li> @include('include.pagination', ['paginator' => $qGetGalleryData])</li>
    </ul>
</div>


