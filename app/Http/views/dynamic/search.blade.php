@if($ProductRecordCount > 0)			
<div class="group-title-index">
    <h2 class="center-title">Search Audio Conference</h2>
</div>
<div class="courses-wrapper"><!-- Nav tabs-->
    <!-- Tab panes-->
    <div class="tab-content courses-content">
        <div id="campus" role="tabpanel" class="tab-pane fade in active">
            <div class="style-show style-grid row">
                @foreach($qGetProductResult as $resultProduct){{--Display All News Record--}}
                    <div class="col-style">
                        <div class="edugate-layout-2">
                            <div class="edugate-layout-2-wrapper">
                                <div class="edugate-content">
                                    <a href="{{url('/')}}/conference/{{$resultProduct->url_title}}" class="title">{{$resultProduct->productName}}</a>
                                    @if(isset($resultProduct->firstname))
									<div class="info">
                                        <div class="author item">
                                            <a href="{{url('/').'/staff_details/'.$resultProduct->staff_url}}">By : {{$resultProduct->firstname}} {{$resultProduct->lastname}} </a>
                                        </div>
                                    </div>
									@endif
                                    <div class="info">
                                        <div class="author item">
                                            <p>Duration : {{round(abs(strtotime($resultProduct->productEndTime) - strtotime($resultProduct->productStartTime)) / 60)}} minutes</p>
                                            <p>Date : {{date("d M Y", strtotime($resultProduct->productDate))}}</p>
                                            <p>{{$resultProduct->categoryName}}</p>
                                        </div>
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
							<div class="col-md-12 col-sm-12 col-xs-12 conference_view_btn">
								<a href="{{url('/')}}/conference/{{$resultProduct->url_title}}" class="btn btn-green"><span>View Conference Details</span></a>
							</div>
                        </div>
                    </div>
                @endforeach
                <nav class="pagination col-md-12">
                    <ul class="pagination__list">
                        <li>@include('include.pagination', ['paginator' => $qGetProductResult])</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@else
	<h3 align="center">Record not found</h3>
@endif
