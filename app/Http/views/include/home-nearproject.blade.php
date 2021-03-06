<?php   use App\Http\Controllers\Action_controllers;
        use App\Http\Models\Product_category;
        use App\Http\Models\Category_model;
        ?>
<div class="container">
        <div class="row">
            <div class="main text-left">
                <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">Featured Events Near you <div style="float:right; margin-right: 43px;" ><a class="fondae_btn hvr-shutter-out-horizontal" href="{{url('/')}}/explore">Explore</a></div></h3>
            </div>
            
           
            <?php /*?><div class="help_base" >
                @include('include.home-product-category')
                <div class="col-sm-12 container">
                    <div id="project-carousel" class="owl-carousel owl-theme"> 
                        @if($nearProductRecordCount > 0)
                            @foreach($qGetnearProductResult as $resultProduct){{--Display All News Record--}}
                                <?php 
                                        $datetime1 = strtotime($resultProduct->productDate);
                                        $datetime2 = time(); // or your date as well
                                        $datediff = $datetime1-$datetime2;
                                        $interval=floor($datediff / (60 * 60 * 24));
                                        $interval=$interval+1;
                                ?>
                                @if($interval>0)
                                <div class="{{$resultProduct->categoryName}}" data-tag='{{$resultProduct->categoryName}}' >
                                    <div class="help_block">
                                        <div class="image-base">
                                            <div class="baronNeueBlack" style="position: relative; ">
                                                <div class="corner-date-background"></div>
                                                <div class="deadline-month">{{date("M", strtotime($resultProduct->productDate))}}.</div>
                                                <div class="deadline-day">{{date("d", strtotime($resultProduct->productDate))}}</div>
                                            </div>
                                            
                                            @if(file_exists(public_path().'/upload/product/mainimages/'.$resultProduct->prodcutImage) && strlen($resultProduct->prodcutImage) > 0)
                                                <img src="{{url('/')}}/upload/product/mainimages/{{$resultProduct->prodcutImage}}" alt="" title=""  style="height: 380px"/>
                                            @else
                                                <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""  style="height: 380px"/>
                                            @endif
                                            <div class="help-info" style="padding: 0px">
                                                <h3 style="float:right"> {{$interval}} days until event </h3>
                                                <h3 class="project-header-title">{{$resultProduct->productName}}</h3>
                                                <h5 class="project-header-tagline">Tagline inserted here
                                                    <br>
                                                    <br>
                                                    <div ><span class="gm-marker"></span>
                                                        <span >{{$resultProduct->city}}</span>
                                                    </div>
                                                </h5>
                                                <?php $data=Action_controllers::getProductorderTotalCount($resultProduct->productID); ?>
                                                <div class="box-bottom">
                                                    <div class="skillbar" data-percent="{{number_format($data['goalper'],2)}}%">
                                                        <div class="skillbar-bar"></div>
                                                        <div class="skill-bar-percent" style="left:0;">{{number_format($data['goalper'],2)}}%</div>
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
                            <h3 align="center">Record not found</h3>
                        @endif               
                    </div>
                </div>
            </div><?php */?>
            
  
            <div id="filters">
                <div class="ui-group">
                    <div class="button-group js-radio-button-group" data-filter-group="children">
                        @include('include.home-product-category')   
                    </div>
                </div>
            </div>

            <section class="regular slider">
                  @if($nearProductRecordCount > 0)
                      @foreach($qGetnearProductResult
                                // echo $interval=$interval+1;
                                   $data_category=Product_category::where('productID',$resultProduct->productID)->select('categoryID')->first();

                                    $category_name=Category_model::where('categoryID',$data_category['categoryID'])->select('categoryname')->first();
                          ?>
                          <?php /*?>@if($interval>0)<?php */?>
                          <div>
                                <div class="children {{$resultProduct->categoryName}}"><a href="{{url('/event')}}/{{$resultProduct->url_title}}">
                                    <div class="help_block ">
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
                                            <div class="help-info" style="padding: 0px">
                                           
                                                <h3 style="float:right"> {{$interval}} days until event </h3>
                                              
                                                <h3 class="project-header-title">{{$resultProduct->productName}} <?php if(!empty($category_name->categoryname)){ ?><span style="color: #ffc34d;"> ({{$category_name->categoryname}})</span><?php } ?></h3>
                                                <h5 class="project-header-tagline">
                                                    <div>
                                                        <span class="gm-marker"></span>
                                                        <span>
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ date("g:i a", strtotime($resultProduct->event_time)) }}
                                                         <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp {{$resultProduct->city}} </span>
                                                    </div>
                                                </h5>
                                                <?php $data=Action_controllers::getProductorderTotalCount($resultProduct->productID);


                                                $goalpr=number_format($data['goalper'],2);
                                                if($goalpr>100)
                                                    { $goalpr=100; }
                                            
                                                 ?>
                                                <div class="box-bottom">
                                                    <div class="skillbar" data-percent="{{ $goalpr }}%">
                                                        <div class="skillbar-bar" style="width: {{ $goalpr }}%;"></div>
                                                        <div class="skill-bar-percent" style="left: 5%;">{{number_format($data['goalper'],2)}}%</div>
                                                    </div>
                                                    <p class="pull-left text-left">Raised<br><span>${{number_format($data['raised'],2)}}</span></p>
                                                    <p class="pull-right text-right">goal<br><span>${{number_format($resultProduct->price,2)}}</span></p>
                                                </div>
                                            </div>
                                            <div class="helpbox-overlay">
                                                <div class="help-btn-base">
                                                    <form class="donation-form" action="{{url('/event')}}/{{$resultProduct->url_title}}" method="get" target="_top">
                                                        <button type="submit"> 
                                                        DETAILS
                                                        </button>                    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> </a></div>
                         <?php /*?> @endif<?php */?>
                      @endforeach
                  @else
                      <h3 align="center">Record not found</h3>
                  @endif 
            </section>
 
            
        </div>
    </div>
  <script>
    function fun_hide_show_category(className)
      {
         $('[class^=item]').hide('fast','linear');
            if(className == 'all') {
                 $('[class^=item]').show('fast','linear');
            } else {
                 $('.category-'+className).show('fast','linear');
            }
      }
  </script>
  <style type="text/css">
      
      #popular-project .skill-bar-percent
       {
            background-color: #e8ae00;
            border-radius: 50%;
            height: 40px;
            left: 158px;
            line-height: 39px;
            text-align: center;
            width: 63px;
            margin-top: -16%;
            margin-left: 1px;
        }
        .slider .slick-dots{display:none !important;}
        .slick-prev, .slick-next {
    font-size: 0;
    line-height: 0;
    position: absolute;
    top: 50%;
    display: block;
    width: 30px;
    height: 30px;
    padding: 0;
    -webkit-transform: translate(0, -50%);
    -ms-transform: translate(0, -50%);
    transform: translate(0, -50%);
    cursor: pointer;
    color: transparent;
    border: none;
    outline: none;
    background:#e8ae00;
}
.slick-prev::before, .slick-next::before{
 content:"";font: normal normal normal 14px/1 FontAwesome; color:#000; font-size:18px; text-align:center;display: block;line-height:30px; 
    width: 30px;
    height: 30px;
}
.slick-prev::before{content: "\f104";}
.slick-next::before{content: "\f105";}
.slick-prev {
    left: -35px;
}
.slick-next {
    right: -35px;
}

#filters .ui-group .button {
    display: inline-block;
    vertical-align: top;
}
  </style>
  

