<?php /*?><div class="features">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<h2>Services</h2>
        @foreach($qGetServiceDetail as $resultServiceData)              
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne{{$resultServiceData->servicesID}}">
				<p class="panel-title">
                    <a class="plus collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$resultServiceData->servicesID}}" aria-expanded="false" aria-controls="collapseOne{{$resultServiceData->servicesID}}">
                        {{$resultServiceData->servicesTitle}}
                    </a>
				</p>
			</div>
			<div id="collapseOne{{$resultServiceData->servicesID}}" class="panel-collapse collapse" role="tabpanel">
				<div class="panel-body">
					<p>
						<?php 
						$body=strip_tags($resultServiceData->body);
						echo substr($body, 0, 100);
						if(strlen($body)>100){
							echo "...";
						}?>
                    </p>
					<a href="{{ url('/').'/services_details/'.$resultServiceData->url_title}}">View Details</a>
				</div>
			</div>
		</div>
        @endforeach
	</div>
</div><?php */?>
<div class="features_news category_list">
	<h3>Category</h3>
<div class="item">	
        <a href="{{url('/explore/')}}">All</a><br>
    </div>
    <?php //dd($qGetProductCategoryResult);?>
     @foreach($qGetProductCategoryResult as $resultProductCategory)
    	<div class="item">	
			<a href="{{url('/explore/')}}/{{$resultProductCategory->urlName}}"><?php /*?><i class="fa fa-plus" aria-hidden="true"></i><?php */?>  {{ $resultProductCategory->categoryname}}</a><br>
		</div>
    @endforeach
    <div class="item">	
        <a href="{{url('/recentpast/')}}">Recent Past Events</a><br>
    </div>
    <div class="item">	
        <a href="{{url('/completedprojects/')}}">Completed Projects</a><br>
    </div>
</div>
