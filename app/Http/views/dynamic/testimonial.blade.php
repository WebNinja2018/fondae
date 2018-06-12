@if($testimonialRecordCount > 0)
	@foreach($qGetTestimonialData as $getTestimonialData)
        <div class="col-sm-12 col-md-12 col-xs-12 testimonial">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2 testimonial_img">
                    <div class="row">
                        @if((file_exists(public_path().'/upload/testimonials/th_'.$getTestimonialData->testimonial_img) && strlen($getTestimonialData->testimonial_img) > 0))
                            <img src="{{url('/').'/upload/testimonials/th_'.$getTestimonialData->testimonial_img}}" alt="{{$getTestimonialData->clientName}}" title="{{$getTestimonialData->clientName}}">
                        @else
                            <img src="{{url('/').'/components/images/no-images.png'}}" alt="{{$getTestimonialData->clientName}}" title="{{$getTestimonialData->clientName}}">
                        @endif
                    </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <div class="testimonial_comments col-sm-12 col-md-12 col-xs-12">
                        <h2>{{$getTestimonialData->clientName}} </h2>
                        <strong><i>{{date(Config::get('config.dateFormat','Y-m-d'),strtotime($getTestimonialData->created_at))}}</i></strong>
                        <br/>
                            {!! $getTestimonialData->details !!}
                     </div>
                </div>
            </div>
         </div>
	@endforeach 
	<div class="pagenavigation">
        <ul>
            <li> @include('include.pagination', ['paginator' => $qGetTestimonialData])</li>
        </ul>
    </div>
@else
	<h3 align="center">No record found.</h3>
@endif
<div class="back">
	<a href="{{ URL::previous() }}" title="BACK">&lt; BACK</a>
</div>


