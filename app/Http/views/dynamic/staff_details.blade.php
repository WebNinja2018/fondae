<div class="section profile-teacher">
	<div class="profile-teacher-wrapper">
        <div class="teacher-info">
            @if($qGetStaffDetail[0]->position_public==1){{--Check image is public Or Unpublic--}}
                @if((file_exists(public_path().'/upload/staff/'.$qGetStaffDetail[0]->imgFileName_staff) && strlen($qGetStaffDetail[0]->imgFileName_staff) > 0))  {{--Conditon For if News image is Delete in folder. And 'rootPath' is set in config file--}}
                <div class="staff-item2 customize">
                    <div class="staff-item-wrapper">
                        <div class="staff-info">
                        	<a href="##"  class="staff-avatar">
                        		<img class="img-responsive" src="{{url('/').'/upload/staff/'.$qGetStaffDetail[0]->imgFileName_staff}}" alt="{{$qGetStaffDetail[0]->firstname}}" title="{{$qGetStaffDetail[0]->firstname}}">
                    		</a>
                        </div>
                    </div>
                </div>
                @endif
            @endif
            <div class="teacher-des">
                @if($qGetStaffDetail[0]->firstname_public==1 ||$qGetStaffDetail[0]->lastname_public==1 )
                    <div class="title">@if($qGetStaffDetail[0]->firstname_public==1){{$qGetStaffDetail[0]->firstname}}@endif @if($qGetStaffDetail[0]->lastname_public==1){{$qGetStaffDetail[0]->lastname}}@endif</div>
                @endif
                @if($qGetStaffDetail[0]->position_public==1)<div class="subtitle">{{$qGetStaffDetail[0]->position}}</div>@endif
                @if($qGetStaffDetail[0]->bio_public==1)
                    <div class="content">
                        {!!$qGetStaffDetail[0]->bio!!}
                    </div>
                @endif
            </div>
        </div>
	</div>
</div>
<div class="back">
	<?php /*?><a @if(strlen(Request::server('HTTP_REFERER'))>0) href="{{URL::previous()}}" @else href="{{url('/')}}" @endif title="BACK" class="back_link">&lt; BACK</a><?php */?>
	<a href="{{url('/staff')}}" title="BACK" class="back_link">&lt; BACK</a>
</div>
@if($productRecordCount>0)
    <div class="group-title-index">
        <h2 class="center-title">Related Audio Conference</h2>
    </div>
    <div class="courses-wrapper"><!-- Nav tabs-->
        <div class="tab-content courses-content">
            <div id="campus" role="tabpanel" class="tab-pane fade in active">
                <div class="style-show style-grid row">
                    @foreach($qGetProductData as $resultProduct)
                    <div class="col-style">
                        <div class="edugate-layout-2">
                            <div class="edugate-layout-2-wrapper">
                                <div class="edugate-content">
                                    <a href="{{url('/')}}/conference/{{$resultProduct->url_title}}" class="title">{{$resultProduct->productName}}</a>
                                    <div class="info">
                                        <div class="author item">
                                            <a href="##">By : {{$qGetStaffDetail[0]->firstname}} {{$qGetStaffDetail[0]->lastname}}</a>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <div class="author item">
                                            <p>Duration: {{round(abs(strtotime($resultProduct->productEndTime) - strtotime($resultProduct->productStartTime)) / 60)}} minutes</p>
                                            <p>{{date("d M Y", strtotime($resultProduct->productDate))}}</p>
                                            <p>{{$resultProduct->categoryName}}</p>
                                        </div>
                                    </div>
                                    <div title="Rated 5.00 out of 5" class="star-rating">
                                        <span class="width-80"><strong class="rating">5.00</strong> out of 5</span>
                                    </div>
                                </div>
                                <div class="edugate-image">
                                    @if(file_exists(public_path().'/upload/product/mainimages/'.$resultProduct->prodcutImage) && strlen($resultProduct->prodcutImage) > 0)
                                        <img src="{{url('/')}}/upload/product/mainimages/{{$resultProduct->prodcutImage}}" alt="" title=""  class="img-responsive"/>
                                    @else
                                        <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""  class="img-responsive"/>
                                    @endif
                                </div>
                            </div>
							<div class="col-md-12 col-sm-12 col-xs-12 conference_view_btn text-center">
								 <a href="{{url('/')}}/conference/{{$resultProduct->url_title}}" class="btn btn-green"><span>View Conference Details</span></a>
							</div>
                        </div>
                    </div>
					@endforeach
                    <nav class="pagination col-md-12">
                        <ul class="pagination__list">
                          	@include('include.pagination', ['paginator' => $qGetProductData])
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif