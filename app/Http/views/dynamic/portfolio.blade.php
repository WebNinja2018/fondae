<script type="text/javascript">
	function fun_pagenavigation(pageNo)
	{
		frmobj = window.document.frm_portfolio;
		frmobj.currentPage.value = pageNo;
		frmobj.submit();
	}
	function funGetPortfolioCategory()
	{
		frmobj = window.document.frm_portfolio;
		var catgory = frmobj.category.value;
		if(catgory!=''){
			frmobj.action="{{url('/')}}/portfolio/"+catgory;
		}else{
			frmobj.action="{{url('/')}}/portfolio";
		}
		frmobj.submit();
	}
</script>
@if($portfolioRecordCount > 0)
    <form name="frm_portfolio" method="post" id="frm_portfolio" action="#">
        <div class="col-xs-6 col-sm-4 col-md-3 pull-right">
            <div class="row">
                <div class="select_categories">
                    <select name="category" id="category" class="form-control" onchange="return funGetPortfolioCategory();">
                        <option value="">All Categories</option>
                        @foreach($qGetPortfolioCategoryData as $resultPortfolioCategory )
                        <option value="{{$resultPortfolioCategory->urlName}}" @if($resultPortfolioCategory->urlName==$portfolioCategory) selected='selected' @endif>{{$resultPortfolioCategory->categoryname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
    <div class="col-xs-12 col-sm-12 col-md-12 portfolio">
        <div class="row">
            @foreach($qGetAllPortfolio as $resultPortfolioData)
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="thumbnail">
                            @if(strlen($resultPortfolioData->imgFileName_portfolio)>0 && file_exists(public_path().'/upload/portfolio/th_'.$resultPortfolioData->imgFileName_portfolio))
                                <a href="{{url('/').'/portfolio_details/'.$resultPortfolioData->url_title}}">
                                    <div class="portfolio_images">   
                                        <img src="{{url('/').'/upload/portfolio/th_'.$resultPortfolioData->imgFileName_portfolio}}" alt="{{$resultPortfolioData->portfolioTitle}}" title="{{$resultPortfolioData->portfolioTitle}}"/>
                                    </div>
                                </a>
                            @else
                                <a href="{{url('/').'/portfolio_details/'.$resultPortfolioData->url_title}}">
                                    <div class="portfolio_images">
                                        <img src="{{url('/').'/components/images/no-images.png'}}" alt="{{$resultPortfolioData->portfolioTitle}}" title="{{$resultPortfolioData->portfolioTitle}}">
                                    </div>
                                </a>
                            @endif
                                <div class="caption">
                                    <h5>{{$resultPortfolioData->portfolioTitle}}</h5>
                                    <p><a href="{{url('/').'/portfolio_details/'.$resultPortfolioData->url_title}}" class="btn btn-primary" role="button">Learn More</a></p>
                                </div>
                        </div>
                    </div>
             @endforeach
         </div>
    </div>
	<div class="pagenavigation">
        <ul>
            <li> @include('include.pagination', ['paginator' => $qGetAllPortfolio])</li>
        </ul>
    </div>
@else
	<h3 align="center">Record not found</h3>
@endif