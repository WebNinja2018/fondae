<div class="affiliations">
	<div class="row">
		@if($affilationRecordCount > 0)
            @foreach($qGetAffilationData as $resultAffilationData)
                <div class="col-md-3 col-sm-4 col-xs-3 text-center">
                    <div class="thumbnail">
                        @if(strlen($resultAffilationData->weblink)>0)
                            <a href="{{ $resultAffilationData->weblink}}" target="_blank">
                        @endif
                                @if((file_exists(public_path().'/upload/links/th_'.$resultAffilationData->linksImage) && strlen($resultAffilationData->linksImage) > 0)) {{--Conditon For if Affilation image is Delete in folder. And 'rootPath' is set in config file--}}
                                    <div class="affiliations_images">
                                        <img src="{{url('/').'/upload/links/th_'.$resultAffilationData->linksImage}}" alt="{{$resultAffilationData->name}}" title="{{$resultAffilationData->name}}">
                                    </div>
                                @else
                                    <img src="{{url('/').'/components/images/no-images.png'}}" alt="{{$resultAffilationData->name}}" title="{{$resultAffilationData->name}}">
                                @endif                     
                                <h3>{{ $resultAffilationData->name }}</h3>
                       @if(strlen($resultAffilationData->weblink)>0)
                            </a>
                       @endif
                            
                    </div>
                </div>
        	@endforeach
			<div class="pagenavigation">
                <ul>
                    <li> @include('include.pagination', ['paginator' => $qGetAffilationData])</li>
                </ul>
            </div>
        @else
            <h3 align="center">Record Not Found</h3>
        @endif
	</div>
</div>
<div class="back">
	<a href="{{ URL::previous() }}" title="BACK">&lt; BACK</a>
</div>