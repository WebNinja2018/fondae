<div class="gallerydetails gallery">
	<div class="row">
		@if($imagesRecordCount>0)
            @foreach($qGetImagesData as $ResultImagesData)
                @if((file_exists(public_path().'/upload/gallery/images/'.$ResultImagesData->imagesName) && strlen($ResultImagesData->imagesName) > 0)) {{--Conditon For if News image is Delete in folder. And 'rootPath' is set in config file--}}   
					<div class="col-xs-4 col-sm-3 col-md-3">
                        <a data-gal="prettyPhoto[gallery1]" class="thumbnail" href="{{url('/').'/upload/gallery/images/'.$ResultImagesData->imagesName}}">
                        <div class="gallery_detailsimages">
                            <img src="{{url('/').'/upload/gallery/images/'.$ResultImagesData->imagesName}}" alt="" title="">
                        </div>
                        </a>
                    </div>
                @else
                    <div class="col-xs-4 col-sm-3 col-md-3">
                        <a data-gal="prettyPhoto[gallery1]" class="thumbnail" href="{{ url('/').'/components/images/no-images.png'}}">
                        <div class="gallery_detailsimages">
                            <img src="{{ url('/').'/components/images/no-images.png'}}" alt="Image Not Available" title="">
                        </div>
                        </a>
                    </div>
                @endif
            @endforeach
		@else
            <h3 align="center">Record not found</h3>
        @endif
	</div>
</div>
<div class="back">
	<a href="{{url('/').'/gallery'}}">&lt; BACK</a>
</div>
<div class="pagenavigation">
    <ul>
        <li> @include('include.pagination', ['paginator' => $qGetImagesData])</li>
    </ul>
</div>
