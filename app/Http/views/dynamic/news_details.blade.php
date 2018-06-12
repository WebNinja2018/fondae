<div class="col-md-12 col-sm-12 col-xs-12 portfolio_detail_img">
    <div class="row">
        @if((file_exists(public_path().'/upload/news/'.$qGetNewsDetailData[0]->imgFileName_news) && strlen($qGetNewsDetailData[0]->imgFileName_news) > 0)){ ?>
        <div class="col-md-6 col-sm-6 col-xs-6 ">
        	<div class="row">
            	<img src="{{url('/').'/upload/news/'.$qGetNewsDetailData[0]->imgFileName_news}}" alt="" title="">
        	</div>
        </div>
        @endif
        <div class="portfolio_description">
            <h2>{{$qGetNewsDetailData[0]->newsTitle}}</h2>
            <p>By : {{$qGetNewsDetailData[0]->author}}</p>
            <p>Date : {{date(Config::get('config.dateFormat','Y-m-d'),strtotime($qGetNewsDetailData[0]->newsDate))}}</p>
            @if($qGetNewsDetailData[0]->body=='')
                {!! $qGetNewsDetailData[0]->summary !!}
            @else
                {!! $qGetNewsDetailData[0]->body !!}
            @endif
        </div>
    </div>
</div>
@if($imageCount>0)
<div class="portfolio_relatedimages gallery col-md-12 col-sm-12 col-xs-12">
	<div class="row">
		<h3>Related Images</h3>
        <div class="customNavigation">
          <a href="javascript:;" class="prev" title="Prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
          <a href="javascript:;" class="next" title="Next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
        </div>
		<div id="owl-demo2" class="owl-carousel gallery">
			@foreach($qGetImages as $resultImage)
				@if(file_exists(public_path().'/upload/news/images/'.$qGetNewsDetailData[0]->newsID.'/'.$resultImage->imagesName))
                    <div class="item">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <a data-gal="prettyPhoto[gallery1]" href="{{url('/').'/upload/news/images/'.$qGetNewsDetailData[0]->newsID.'/'.$resultImage->imagesName}}" >
                                <div class="portfolio_sliderimages">
                                    <img src="{{url('/').'/upload/news/images/'.$qGetNewsDetailData[0]->newsID.'/'.$resultImage->imagesName}}" alt="" title="" />
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
    <?php /*?><a href="{{url('/').'/news'}}">&lt; BACK</a><?php */?>
	<a href="{{ URL::previous() }}" title="BACK">&lt; BACK</a>
</div>	
					