<div class="col-md-12 col-sm-12 col-xs-12 portfolio_detail_img">
	<div class="row">
		@if((strlen($qGetPortfolioDetail[0]->imgFileName_portfolio)>0) && file_exists(public_path().'/upload/portfolio/'.$qGetPortfolioDetail[0]->imgFileName_portfolio))
            <div class="col-md-6 col-sm-6 col-xs-6">
            	<div class="row">
                	<img  src="{{url('/').'/upload/portfolio/'.$qGetPortfolioDetail[0]->imgFileName_portfolio}}" alt="{{$qGetPortfolioDetail[0]->portfolioTitle}}" title="{{$qGetPortfolioDetail[0]->portfolioTitle}}"  />
            	</div>
            </div>
       @endif
        <div class="portfolio_description">
            <h2>{{$qGetPortfolioDetail[0]->portfolioTitle}}</h2>
            {!!$qGetPortfolioDetail[0]->body!!}
        </div>
     </div>
</div>
@if($imageCount>1)
<div class="portfolio_relatedimages gallery col-md-12 col-sm-12 col-xs-12">
	<div class="row">
		<h3>Related Images</h3>
        <div class="customNavigation">
          <a href="javascript:;" class="prev" title="Prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
          <a href="javascript:;" class="next" title="Next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
        </div>
		<div id="owl-demo2" class="owl-carousel gallery">
			
			@foreach($qGetImages as $resultImage)
                @if(file_exists(public_path().'/upload/portfolio/'.$resultImage->imagesName))
                    <div class="item">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <a data-gal="prettyPhoto[gallery1]" href="{{url('/').'/upload/portfolio/'.$resultImage->imagesName}}" >
                                <div class="portfolio_sliderimages">
                                    <img src="{{url('/').'/upload/portfolio/'.$resultImage->imagesName}}" alt="" title="" />
                                </div>
                            </a>
                        </div>
                    </div>
                @else
    				<div class="item">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <a data-gal="prettyPhoto[gallery1]" href="{{url('/').'/components/images/no-images.png'}}" >
                                <div class="portfolio_sliderimages">
                                    <img src="{{url('/').'/components/images/no-images.png'}}" alt="" title="" />
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
			@endforeach
			
		</div>
	</div>
</div>
@endif
<div class="back">
	<a href="{{ URL::previous() }}" title="BACK">&lt; BACK</a>
</div>

