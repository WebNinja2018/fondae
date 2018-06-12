<script type="text/javascript">
	function fun_pagenavigation(pageNo){
		frmobj = window.document.frm_news;
		frmobj.currentPage.value = pageNo;
		frmobj.submit();
	}
	function fun_getServiceCategory()
	{
		frmobj = window.document.frm_news;
		var catgory = frmobj.category.value;
		if(catgory!=''){
			frmobj.action="{{url('/')}}/news/"+catgory;
		}else{
			frmobj.action="{{url('/')}}/news";
		}
		frmobj.submit();
	}
</script>

    <form name="frm_news" method="post" id="frm_news" action="#">
        <div class="col-xs-6 col-sm-4 col-md-3 pull-right">
            <div class="row">
                <div class="news_categories">
                    <select name="category" id="category" class="form-control" onchange="return fun_getServiceCategory();">
                        <option value="">All Categories</option>
                        @foreach($qGetNewsCategoryData as $ResultNewsCategory )
                        <option value="{{$ResultNewsCategory->urlName}}" @if($ResultNewsCategory->urlName==$newsCategory) selected='selected' @endif>{{$ResultNewsCategory->categoryname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
@if($newsTotalCount > 0)
    <div id="news">	
        @foreach($qGetNewsData as $resultNewsData){{--Display All News Record--}}
            <div class="col-xs-12 col-sm-12 col-md-12 service_list">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 service_list_left">
                        @if((file_exists(public_path().'/upload/news/th_'.$resultNewsData->imgFileName_news) && strlen($resultNewsData->imgFileName_news) > 0)) {{--Conditon For if News image is Delete in folder. And 'rootPath' is set in config file--}}
                                <img src="{{url('/').'/upload/news/th_'.$resultNewsData->imgFileName_news}}" alt="{{$resultNewsData->newsTitle}}" title="{{$resultNewsData->newsTitle}}">
                        @else
                                <img src="{{url('/').'/components/images/no-images.png'}}" alt="" title="">
                        @endif
                    </div>
                    <div class="col-xs-9 col-sm-9 col-md-9 event_list_right">
                        <div class="col-sm-12 col-md-12 col-xs-12 ">
                        <h3>{{$resultNewsData->newsTitle}}</h3>
                        <h4>@if(strlen($resultNewsData->author)>0) By : {{$resultNewsData->author}} @endif {{--Condition If NEWS author is not enterd--}} </h4>
                        <span>@if(strlen($resultNewsData->newsDate)>0) Date : {{date(Config::get('config.dateFormat','Y-m-d'),strtotime($resultNewsData->newsDate))}} {{--SET News Date--}}@endif {{--Condition If NEWS newsDate is not enterd And Date format is set in config  file.--}}</span>
                        <p>
                            @if(strlen($resultNewsData->summary)>0) {{--Condition if summray is not Entered--}}
                                <?php $summary=strip_tags($resultNewsData->summary);?>
                                {{substr($summary, 0, 150)}} @if(strlen($summary)>150) ... @endif
                            @endif
                         </p>
                        <a class="btn btn-primary" href="{{url('/').'/news_details/'.$resultNewsData->url_title}}">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
		@endforeach
    </div>
	<div class="pagenavigation">
        <ul>
            <li> @include('include.pagination', ['paginator' => $qGetNewsData])</li>
        </ul>
    </div>
@else
	<h3 align="center">Record not found</h3>
@endif