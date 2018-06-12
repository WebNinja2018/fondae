<?php use App\Http\Controllers\Action_controllers;
      use App\Http\Models\Product_category;
      use App\Http\Models\Category_model;
        ?>
<div class="container">
    <div class="row">
        <div class="main text-left">
            <h4 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">What is Popular  <div style="float:right; margin-right: 43px;" ><a class="fondae_btn hvr-shutter-out-horizontal" href="{{url('/')}}/explore">Explore</a></div></h4><br><br><br>
        </div>
         <div id="jcl-demo">


            <div class="custom-container default">
              <div class="pull-right nextprevious_btn">
                    <a href="#" class="prev"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="next"><i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="carousel featured_projects">
                    <ul>
                     @if($popularProductRecordCount > 0)
                        @foreach($popularProductResult as $resultProduct)
                            
                            <?php 
                                    $datetime1 = strtotime($resultProduct->productDate);
                                    $datetime2 = time(); // or your date as well
                                    $datediff = $datetime1-$datetime2;
                                    $interval=floor($datediff / (60 * 60 * 24));
                                    $interval=$interval+1;

                                    $data_category=Product_category::where('productID',$resultProduct->productID)->select('categoryID')->first();

                                    $category_name=Category_model::where('categoryID',$data_category['categoryID'])->select('categoryname')->first();
                            ?>
                            @if($interval>0)
                    
                            <li>
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
                                                <?php /*?><img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""/><?php */?>
                                                <img src="{{url('/')}}/upload/product/mainimages/1498471801.jpg" alt="" title="" style="width:345px;">
                                            @endif
                                        </div>
                                        <?php $data=Action_controllers::getProductorderTotalCount($resultProduct->productID); 
                        
                    ?>
                                        <div class="help-info" style="padding: 0px">
                                            <h3 style="float:right"> {{$interval}} days until event  </h3>
                                            <h3 class="project-header-title">{{$resultProduct->productName}} <?php if(!empty($category_name->categoryname)){ ?><span style="color: #ffc34d;"> ({{$category_name->categoryname}})</span><?php } ?></h3>
                                            <h5 class="project-header-tagline">
                                                <br>
                                                <br>
                                                <div>
                                                    <span class="gm-marker"></span>
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ date("g:i a", strtotime($resultProduct->event_time)) }}
                                                    <span>{{$resultProduct->city}}</span>
                                                </div>
                                            </h5>
                                            <?php
                                                    $goalpr = number_format($data['goalper'],2);
                                                        if($goalpr>100)
                                                            { $goalpr=100; }

                                            ?>
                                            <div class="box-bottom">
                                                <div class="skillbar" data-percent="{{ $goalpr }}%">
                                                    <div class="skillbar-bar" style="width: {{ $goalpr }}%;"></div>
                                                    <div class="skill-bar-percent" style="left: {{ $goalpr }}%;">{{ number_format($data['goalper'],2) }}%</div>
                                                </div>
                                                <p class="pull-left text-left">Raised<br><span>${{number_format($data['raised'],2)}}</span></p>
                                                <p class="pull-right text-right">goal<br><span>${{number_format($resultProduct->price,2)}}</span></p>
                                            </div>
                                        </div>
                                        <div class="helpbox-overlay">
                                            <div class="help-btn-base">
                                                <form class="donation-form" action="{{url('/event')}}/{{$resultProduct->url_title}}" method="get" target="_top">
                                                <button type="submit">DETAILS</button>                    
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @endif
                         @endforeach
                    @else
                        <h3 align="center">Record not found</h3>
                    @endif              
                    </ul>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
 
    </div>
</div>
