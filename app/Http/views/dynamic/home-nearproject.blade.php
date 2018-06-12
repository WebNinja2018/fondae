<?php use App\Http\Controllers\Action_controllers;?>
<div class="container">
        <div class="row">
            <div class="main text-left">
                <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">
                Featured Events Near you </h3>
            </div>
            <div id="filters">
                <div class="ui-group">
                    <div class="button-group js-radio-button-group" data-filter-group="children">
                      @include('include.home-product-category') 
                    </div>
                </div>
            </div>
            <div class="isotope">
                  @if($nearProductRecordCount > 0)
                      @foreach($qGetnearProductResult as $resultProduct){{--Display All News Record--}}
                          <?php 
                                  $datetime1 = strtotime($resultProduct->productDate);
                                  $datetime2 = time(); // or your date as well
                                  $datediff = $datetime1-$datetime2;
                                  $interval=floor($datediff / (60 * 60 * 24));
                                  $interval=$interval+1;
                          ?>
                          <?php /*?>@if($interval>0)<?php */?>
                                <div class="children {{$resultProduct->categoryName}}">
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
                                                    <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title="" />
                                                @endif
                                            </div>
                                            <div class="help-info" style="padding: 0px">
                                                <h3 style="float:right"> {{$interval}} days until event </h3>
                                                <h3 class="project-header-title">Time:- {{ date("g:i a", strtotime($resultProduct->event_time)) }}</h3>
                                                <h3 class="project-header-title">{{$resultProduct->productName}}</h3>
                                                <h5 class="project-header-tagline">Tagline inserted here
                                                    <br>
                                                    <br>
                                                    <div>
                                                        <span class="gm-marker"></span>
                                                        <span>{{$resultProduct->city}}</span>
                                                    </div>
                                                </h5>
                                                <?php $data=Action_controllers::getProductorderTotalCount($resultProduct->productID); 

                                                  $goalpr=number_format($data['goalper'],2);
                                                if($goalpr>100)
                                                    { $goalpr=100; }
                                            
                                                 ?>
                                                <div class="box-bottom">
                                                    <div class="skillbar" data-percent="{{number_format($data['goalper'],2)}}%">
                                                        <div class="skillbar-bar" style="width: {{ $goalpr }}%;"></div>
                                                        <div class="skill-bar-percent" style="left: {{ $goalpr }}%;">{{number_format($data['goalper'],2)}}%</div>
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
                                </div>
                          <?php /*?>@endif<?php */?>
                      @endforeach
                  @else
                      <h3 align="center">Record not found</h3>
                  @endif 
            </div>
            
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