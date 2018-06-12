<?php use App\Http\Controllers\Action_controllers;?>
<div class="container">
        <div class="row">
            <div class="main text-left">
                <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">Events Near You</h3>
            </div>
            
            
            
            
            <div class="help_base" >
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
            </div>
            
  
            @include('include.home-product-category')
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
                      @if($interval>0)
               				<div class="{{$resultProduct->categoryName}}">
                    			<div class="help_block ">
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
                                                <div>
                                                    <span class="gm-marker"></span>
                                                    <span>{{$resultProduct->city}}</span>
                                                </div>
                                            </h5>
                                            <div class="box-bottom">
                                                <div class="skillbar" data-percent="{{number_format($data['goalper'],2)}}%">
                                                    <div class="skillbar-bar" style="width: {{number_format($data['goalper'],2)}}%%;"></div>
                                                    <div class="skill-bar-percent" style="left: {{number_format($data['goalper'],2)}}%;">{{number_format($data['goalper'],2)}}%%</div>
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
                            
                <div class="children faith medical">
                	<div class="help_block">
                        <div class="image-base">
                            <div class="baronNeueBlack" style="position: relative; ">
                                <div class="corner-date-background"></div>
                                <div class="deadline-month">Jul.</div>
                                <div class="deadline-day">06</div>
                            </div>
                                <img src="http://www.d9ithub.com/fondae_new/upload/product/mainimages/1498471801.jpg" alt="" title="" style="height: 380px">
                            <div class="help-info" style="padding: 0px">
                                <h3 style="float:right"> 4 days until event </h3>
                                <h3 class="project-header-title">HELP FOR Poorsrer12</h3>
                                <h5 class="project-header-tagline">Tagline inserted here
                                    <br>
                                    <br>
                                    <div>
                                        <span class="gm-marker"></span>
                                        <span>Ahmedabad</span>
                                    </div>
                                </h5>
                                <div class="box-bottom">
                                    <div class="skillbar" data-percent="4.69%">
                                        <div class="skillbar-bar" style="width: 4.69%;"></div>
                                        <div class="skill-bar-percent" style="left: 4.69%;">4.69%</div>
                                    </div>
                                    <p class="pull-left text-left">Raised<br><span>$75.00</span></p>
                                    <p class="pull-right text-right">goal<br><span>$1,600.00</span></p>
                                </div>
                            </div>
                            <div class="helpbox-overlay">
                                <div class="help-btn-base">
                                    <form class="donation-form" action="http://www.d9ithub.com/fondae_new/event/help-for-poorsrer" method="get" target="_top">
                                        <button type="submit"> 
                                        Donate
                                        </button>                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="children movie emergencies">
                    <div class="help_block">
                        <div class="image-base">
                            <div class="baronNeueBlack" style="position: relative; ">
                                <div class="corner-date-background"></div>
                                <div class="deadline-month">Jul.</div>
                                <div class="deadline-day">06</div>
                            </div>
                                <img src="http://www.d9ithub.com/fondae_new/upload/product/mainimages/1498471801.jpg" alt="" title="" style="height: 380px">
                            <div class="help-info" style="padding: 0px">
                                <h3 style="float:right"> 4 days until event </h3>
                                <h3 class="project-header-title">HELP FOR Poorsrer12</h3>
                                <h5 class="project-header-tagline">Tagline inserted here
                                    <br>
                                    <br>
                                    <div>
                                        <span class="gm-marker"></span>
                                        <span>Ahmedabad</span>
                                    </div>
                                </h5>
                                <div class="box-bottom">
                                    <div class="skillbar" data-percent="4.69%">
                                        <div class="skillbar-bar" style="width: 4.69%;"></div>
                                        <div class="skill-bar-percent" style="left: 4.69%;">4.69%</div>
                                    </div>
                                    <p class="pull-left text-left">Raised<br><span>$75.00</span></p>
                                    <p class="pull-right text-right">goal<br><span>$1,600.00</span></p>
                                </div>
                            </div>
                            <div class="helpbox-overlay">
                                <div class="help-btn-base">
                                    <form class="donation-form" action="http://www.d9ithub.com/fondae_new/event/help-for-poorsrer" method="get" target="_top">
                                        <button type="submit"> 
                                        Donate
                                        </button>                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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