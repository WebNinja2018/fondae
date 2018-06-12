@if($ProductCategoryRecordCount > 0)
<div class="section section-padding list-categories">
  <div class="container">
      <div class="list-categories-wrapper">
          <div class="list-categories-content row indusries_category" >
              <div class="customs-row">
				  @foreach($qGetProductCategoryResult as $resultProductCategory)
                  	<div class="col-md-4 col-sm-6">
                      <div class="edugate-layout-3">
                          <div class="edugate-layout-3-wrapper">
                              <div class="industries_img">
                                  <a href="{{url('/')}}/audio-conference/{{$resultProductCategory->urlName}}" class="edugate-image">
                                        @if(file_exists(public_path().'/upload/category/'.$resultProductCategory->imagename) && strlen($resultProductCategory->imagename) > 0)
                                            <img src="{{url('/')}}/upload/category/{{$resultProductCategory->imagename}}" alt="" title=""  class="img-responsive"/>
                                        @else
                                            <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""  class="img-responsive" width="310"/>
                                        @endif
                                  </a>
                               </div>
                              <div class="edugate-content">
                                  <a href="{{url('/')}}/audio-conference/{{$resultProductCategory->urlName}}" class="title">{{ $resultProductCategory->categoryname}}
                                  <a href="{{url('/')}}/audio-conference/{{$resultProductCategory->urlName}}" class="btn btn-green">
                                      <span>All Conferences</span>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
				  @endforeach
              </div>
          </div>
      </div>
  </div>
</div>
@endif