<div id="help" class="explore_list">
<?php use App\Http\Controllers\Action_controllers;?>
<div class="main text-left">
    <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">Discover / All Categories</h3>
</div>

        @if($ProductCategoryRecordCount>0 )
            @foreach($qGetProductResult as $resultProduct)
                <?php 
                        $datetime1 = strtotime($resultProduct->productDate);
                        //$datetime2 = time(); // or your date as well
                       $datetime2 = strtotime($resultProduct->productExpiredDate);
                        $datediff = $datetime1-$datetime2;
                        $interval=floor($datediff / (60 * 60 * 24));
                        $interval=$interval+1;
                ?>
                @if($interval<=0)
                    <div class="children {{$resultProduct->categoryName}}">
                        <div class="help_block">
                            <div class="image-base">
                                <div class="baronNeueBlack" style="position: relative; ">
                                    <div class="corner-date-background"></div>
                                    <div class="deadline-month">{{date("M", strtotime($resultProduct->productDate))}}.</div>
                                    <div class="deadline-day">{{date("d", strtotime($resultProduct->productDate))}}</div>
                                </div>
                                <div class="events_images">
                                    @if(file_exists(public_path().'/upload/product/mainimages/'.$resultProduct->prodcutImage) && strlen($resultProduct->prodcutImage) > 0)
                                                    <img src="{{url('/')}}/upload/product/mainimages/{{$resultProduct->prodcutImage}}" alt="" title="" style="width:345px;"/>
                                    @else
                                        <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title="" />
                                    @endif
                                </div>
                                <div class="help-info" style="padding: 0px">
                                    <h3 style="float:right"> {{$interval}} days until event </h3>
                                    <h3 class="project-header-title">{{$resultProduct->productName}}</h3>
                                    <h5 class="project-header-tagline">Tagline inserted here
                                        <br>
                                        <br>
                                        <div style="padding-top: 25px;">
                                            <span class="gm-marker"></span>
                                            <span>{{$resultProduct->city}}</span>
                                        </div>
                                    </h5>
                                    <?php $data=Action_controllers::getProductorderTotalCount($resultProduct->productID); ?>
                                    <div class="box-bottom">
                                        <div class="skillbar" data-percent="{{number_format($data['goalper'],2)}}%">
                                            <div class="skillbar-bar" style="width: {{number_format($data['goalper'],2)}}%;"></div>
                                            <div class="skill-bar-percent" style="left: {{number_format($data['goalper'],2)}}%;">{{number_format($data['goalper'],2)}}%</div>
                                        </div>
                                        <p class="pull-left text-left">Raised<br><span>${{number_format($data['raised'],2)}}</span></p>
                                        <p class="pull-right text-right">goal<br><span>${{number_format($resultProduct->price,2)}}</span></p>
                                    </div>
                                </div>
                                <div class="helpbox-overlay">
                                    <div class="help-btn-base">
                                        <form class="donation-form" action="{{url('/event')}}/{{$resultProduct->url_title}}" method="get" target="_top">
                                            <button type="submit"> 
                                            Donate
                                            </button>                    
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div>Record not found!</div>
        @endif
            <nav class="pagination col-md-12">
                <ul class="pagination__list">
                    <li>@include('include.pagination', ['paginator' => $qGetProductResult])</li>
                </ul>
            </nav>
        
        <?php /*?><div class="col-sm-12">
            <div class="col-sm-5 col-sm-offset-4">
                <a class="btn btn-default hvr-shutter-out-horizontal" href="#">Show More Projects</a>
            </div>
        </div><?php */?>
</div>