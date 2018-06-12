<?php
use App\Http\Models\Product_price;
use App\Http\Models\Order_details;
use App\Http\Controllers\Action_controllers;
use App\Http\Models\Customer;
use App\Http\Models\Orders;
use App\Http\Models\Comment;
use App\Http\Models\Product_category;
use App\Http\Models\Category_model;
?>
@include('include.message')
<div class="section courses-detail event-detail-section">
    <div class="container">
        <div class="courses-detail-wrapper">
            <div class="row">
                <div class="col-md-12 layout-left">
                    <h2 class="event-detail-title">PROJECT DETAILS<a @if(strlen(Request::server('HTTP_REFERER'))>0) href="{{URL::previous()}}" @else href="{{url('/audio-conference')}}" @endif title="BACK" class="back_link" style="float:right;">&lt; BACK</a></h2>
                </div>
                <div class="col-md-8 layout-left event_description">
                    <?php /*?><div class="course-syllabus-title underline description_title">Description</div><?php */?>
                    <div class="course-info info info-event-detail">
                        <div class="row">
                            
                            <div class="col-md-12 pull-left detail_img">
                                @if(file_exists(public_path().'/upload/product/mainimages/'.$qGetProductResult[0]->prodcutImage) && strlen($qGetProductResult[0]->prodcutImage) > 0)
                                <img src="{{url('/')}}/upload/product/mainimages/{{$qGetProductResult[0]->prodcutImage}}" alt="" title=""  class="img-responsive"/>
                                @else
                                <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""  class="img-responsive"/>
                                @endif
                                <br><br> <hr><div style='text-align: justify;'>{!! $qGetProductResult[0]->projectDescription !!}</div>
                            </div>
                        </div>
                        <hr> <div class="row">
                            <h2 class="event-detail-title"> Event Details </h2>
                            <?php $getvalue=Action_controllers::getProductorderTotalCount($qGetProductResult[0]->productID);
                            $start_date=date("Y-m-d", strtotime($qGetProductResult[0]->created_at));
                            $today = date("Y-m-d"); // or your date as well
                            $date1=date_create($start_date);
                            $date2=date_create($today);
                            $diff=date_diff($date1,$date2);
                            
                            ?>
                            <div class="col-md-12  detail_img">
                                @if(file_exists(public_path().'/upload/product/event_image/'.$qGetProductResult[0]->event_img) && strlen($qGetProductResult[0]->event_img) > 0)
                                <img src="{{url('/')}}/upload/product/event_image/{{$qGetProductResult[0]->event_img}}" alt="" title=""  class="img-responsive"/>
                                @else
                                <img src="{!! url('components/front-end/images/no-images.png') !!}" alt="" title=""  class="img-responsive"/>
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                                <div class="note-time-block">
                                    
                                    <span class="label-time"><i class="fa fa-clock-o"></i>{{strtoupper($qGetProductResult[0]->productStartTime)}} EST</span>
                                    <!--span class="label-time"><i class="fa fa-hourglass-half" aria-hidden="true"></i> {{round(abs(strtotime($qGetProductResult[0]->productEndTime) - strtotime($qGetProductResult[0]->productStartTime)) / 60)}} minutes</span-->
                                    <?php
                                    $datetime1 = strtotime($qGetProductResult[0]->productDate);
                                    $datetime2 = time(); // or your date as well
                                    $datediff = $datetime1-$datetime2;
                                    $interval=floor($datediff / (60 * 60 * 24));
                                    $interval=$interval+1;
                                    ?>
                                    @if($interval>0)
                                    @elseif($interval==0)
                                    <?php /*?><span class="label-time bg-yellow">{{$interval}} Days Left</span><?php */?>
                                    @else
                                    <span class="label-time bg-yellow">Available for all day</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                                <div class="note-time-block">
                                    <span class="label-time"><i class="fa fa-microphone" aria-hidden="true"></i>{{$qGetProductResult[0]->categoryName}}</span>
                                    <span class="label-time"><i class="fa fa-calendar" aria-hidden="true"></i> {{date("M d, Y", strtotime($qGetProductResult[0]->productDate))}} </span>
                                    <span class="label-time"><i class="fa fa-clock-o"></i> Time  {{ date("g:i A", strtotime($qGetProductResult[0]->event_time)) }}  </span>
                                    
                                    
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                    <!--<div class="event-detail-thumb">z
                        <img src="images/event-detail-1.jpg" alt="" class="img-responsive"/>
                    </div>-->
                    <div class=" bottom-project-info">
                        <h4 >Event Description</h4>
                        <div style='text-align: justify;'> {!!$qGetProductResult[0]->longDescription!!}</div>
                    </div>
                </div>
                <?php
                $datas = Customer::where('customerID',$qGetProductResult[0]->createdBy)->first();
                // For Product Order.
                $Orders= new Orders;
                $prductItemData = array('productID'=>$qGetProductResult[0]->productID,'eventType'=>1);
                $qGetProductOrderData=$Orders->getByAttributesQuery($prductItemData);
                $data['qGetProductOrderData'] = $qGetProductOrderData['data'];
                $data['prodcutOrderRecordCount'] = $qGetProductOrderData['recordCount'];
                // var_dump($data['qGetProductOrderData']);
                $data_category=Product_category::where('productID',$qGetProductResult[0]->productID)->select('categoryID')->first();
                $category_name=Category_model::where('categoryID',$data_category['categoryID'])->select('categoryname')->first();
                ?>
                <div class="col-md-4 sidebar layout-right cstm-add" style="padding-right: 13px;">
                    <div class="event-detail-des bottom-project-info">
                        <style type="text/css">
                            .campaign-author span{
                                font-size: 17px
                            }
                             .process .process-info {
                                margin-bottom: 15px;
                                display: inline-flex;
                            }
                            .process-funded , .process-pledged{
                                width:106px;
                            }
                            .process-funded span, .process-pledged span{
                                font-weight: bold;
                                font-size: 18px;
                                color: #444444;
                            }
                            .text-large{
                                font-size:18px !important;
                            }
                            .process-time{
                                margin-top: 12px
                            }
                            .progress
                            {
                                background:#eaeaea;
                            }
                            .progress .progress-bar
                            {padding: 0px 38px 0px 6px;}
                            .cstm-add h5
                            {
                                color:#444444;

                            }
                            

                        </style>
                        <!-- <h3 style="margin-top: -15px;">{{ $category_name['categoryname']}}</h3> -->
                        <div class="campaign-author " style="margin-top: -7px;margin-bottom: 20px;">
                            <div class="author-profile">
                                <span>{{ $category_name['categoryname']}}
                                    <span style="float:right"><i class="fa fa-map-marker "></i> {{ $qGetProductResult[0]->city }}</span>
                                </span>
                            </div>
                        </div>

                                        

                        <h3 style="color:green;font-size:22px;margin-bottom: -6px;">{{$qGetProductResult[0]->productName}}</h3>
                        <span class="" style='margin-top: -30px;font-size:18px;'>{!! $qGetProductResult[0]->shortDescription !!}  </span>
                        <div class="process" style="margin-top: 25px">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width:{{number_format($getvalue['goalper'],2)}}%">
                                {{number_format($getvalue['goalper'],2)}}%  
                                </div>
                            </div>
                            <div class="process-info">
                                <div class="process-funded"><span>${{number_format($qGetProductResult[0]->price,2)}}</span><br>funding goal</div>
                                <div class="process-pledged"><span>${{number_format($getvalue['raised'],2)}}</span><br>pledged</div>
                                 <div class="process-time"><span style="background-color:#242c42;color:#fff ;padding:8px; font-size:15px">{{$interval}} Days Until Event</span>
                                 </div>
                             </div>
                        </div>
                        </div>
                        <h5> <b>Raised by {{ $data['prodcutOrderRecordCount']}} People In {{ $diff->format("%a days") }}</b></h5>
                        
                        <span class=""> End of Fundraiser and Date of Event </span>
                        <div class="clearfix">
                            <span class="label-time text-large" style="background-color:#242c42;color:#fff ;padding:8px;float: left"> {{date("M d, Y", strtotime($qGetProductResult[0]->productDate))}} </span>
                            <span class="label-time text-large" style="right: 13%;
                            position: absolute;
                            margin-top: 11px;"><i class="fa fa-clock-o"></i> Time  {{ date("g:i A", strtotime($qGetProductResult[0]->event_time)) }}  </span>
                        </span>
                    </div>
                    
                    
                    <span class="heading" >You can donate to project upto 20 days after end event date</span>
                    
                    <div class="event-detail-des bottom-project-info">
                        <label style="color:#444444">Project Owner</label>   <br>
                        <p class="pull-left text-left" style="margin-bottom: 10px">
                        <img style="border-radius: 50px;width:50px;border: 2px solid #eee;" src="/upload/customer/{{($datas['imgName']!=''?$datas['imgName']:'tenantimage.jpg')}}" />
                            <span>{{$datas['firstName'].' '.$datas['lastName']}}</span></p><br> <br>
                    </div>
                </div>
                <div class="col-md-4 sidebar layout-right">
                    <div class="row">
                        <div class="category-widget widget col-sm-6 col-md-12 col-xs-6 sd380">
                            <div class="title-widget">CHOOSE YOUR DONATION OPTIONS</div>
                            <label class="lablelable-info"> </label>
                            <div class="content-widget">
                                <?php //dd($qGetSize);?>
                                
                                @if($sizeCount!=0 )
                                <div class="content-widget">
                                    <form action="{{ url('/') }}/action/addtocart" method="POST">
                                        <input type="hidden" id="projectcreatedBy" name="projectcreatedBy" value="{{$qGetProductResult[0]->createdBy}}" />
                                        <input type="hidden" name="productID" id="productID" value="{{$qGetProductResult[0]->productID}}" />
                                        <input type="hidden" name="sizeID[]" value="1">
                                        <input type="hidden" name="priceID" id="priceID" value="00" />
                                        <input type="hidden" name="quantity" value="1">
                                        <ul class="category-widget list-unstyled">
                                            <li>
                                                <a href="##" class="link cat-item">
                                                    <span class="pull-left">Make a pledge without a reward </span>
                                                    <button type="submit" class="btn btn-grey video-btn-right" style="color:#FFFFFF; margin-right:0px;"><span><b>Donate</b></span></button>
                                                </a>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                                @foreach($qGetSize as $resultProductSize)
                                <?php $Order_details= new Order_details;
                                $orderData=array('productID'=>$qGetProductResult[0]->productID,
                                'sizeID'=>$resultProductSize->sizeID,
                                'customerID'=>Session::get('customerID')?Session::get('customerID'):0,
                                'fieldList'=>'order_details.orderDetailsID',
                                );
                                $resultOrder=$Order_details->getByAttributesQuery($orderData);
                                
                                ?>
                                
                                @if($resultProductSize->eventType==1 || $resultProductSize->eventType==3)
                                @if(($resultProductSize->quantity==0||$resultProductSize->remainingQuantity!=0) )
                                
                                <form name="frm_productCart" method="post" id="frm_productCart" action="{{ url('/') }}/action/addtocart">
                                    <input type="hidden" name="productID" id="productID" value="{{$qGetProductResult[0]->productID}}" />
                                    <input type="hidden" name="quantity" id="quantity" value="1" />
                                    <input type="hidden" name="sizeID[]" value="{{$resultProductSize->sizeID}}">
                                    <input type="hidden" name="sizeName" value="{{$resultProductSize->sizeName}}">
                                    <input type="hidden" name="productName" value="{{$qGetProductResult[0]->productName}}">
                                    <input type="hidden" name="min_amount" value="{{$resultProductSize->price}}">
                                    <label for="sizeID[]" generated="true" class="error"></label>
                                    <ul class="category-widget list-unstyled">
                                        <li>
                                            <a href="##" class="link cat-item">
                                                <span class="pull-left rewardtitle">{{$resultProductSize->sizeName}}</span>
                                                <br>
                                                <p>{!!$resultProductSize->description!!}</p>
                                                @if($resultProductSize->price > 0)
                                                <p>
                                                    (Min. Donation {{Config::get('config.priceSign', '$')}}{{$resultProductSize->price}})
                                                </p>
                                                @endif
                                                @if($resultProductSize->quantity!=0)
                                                <span class="pledge__limit">({{$resultProductSize->remainingQuantity}} left of {{$resultProductSize->quantity}})</span>
                                                <span class="block pledge__backer-count">{{$resultProductSize->quantity - $resultProductSize->remainingQuantity}} backers</span>
                                                @endif
                                                <button type="submit" class="btn btn-grey video-btn-right" style="color:#FFFFFF; margin-right:0px;"><span><b>Donate</b></span></button>
                                            </a>z
                                        </li>
                                    </ul>
                                </form>
                                @endif
                                @else
                                @if(( $resultProductSize->eventType==2 && $resultProductSize->quantity==0||$resultProductSize->remainingQuantity!=0))
                                <form name="frm_productCart_{{$resultProductSize->sizeID}}" method="post" id="frm_productCart_{{$resultProductSize->sizeID}}" action="@if(Session::has('customerID')) {{ url('/') }}/action/addtocartunpaid @else {{url('/login-registration')}} @endif" enctype="multipart/form-data">
                                    
                                    <input type="hidden" name="productID" id="productID" value="{{$qGetProductResult[0]->productID}}" />
                                    <input type="hidden" name="quantity" id="quantity" value="1" />
                                    <input type="hidden" name="unpaidOption" id="unpaidOption" value="{{$resultProductSize->unpaidOption}}" />
                                    <input type="hidden" name="sizeID" value="{{$resultProductSize->sizeID}}">
                                    <input type="hidden" name="sizeName" value="{{$resultProductSize->sizeName}}">
                                    <input type="hidden" name="minamt" value="{{$resultProductSize->price}}">
                                    <input type="hidden" name="productName" value="{{$qGetProductResult[0]->productName}}">
                                    <label for="sizeID[]" generated="true" class="error"></label>
                                    <ul class="category-widget list-unstyled">
                                        <li>
                                            <a href="##" class="link cat-item"><span class="pull-left">{{$resultProductSize->sizeName}}</span></a>
                                            <br>
                                            <p>{!!$resultProductSize->description!!}</p>
                                            @if($resultProductSize->quantity!=0)file_select
                                            <span class="pledge__limit">({{$resultProductSize->remainingQuantity}} left of {{$resultProductSize->quantity}})</span>
                                            <span class="block pledge__backer-count">{{$resultProductSize->quantity - $resultProductSize->remainingQuantity}} backers</span>
                                            @endif
                                            @if($resultProductSize->price > 0)
                                            <p>(Min. Donation {{Config::get('config.priceSign', '$')}}{{$resultProductSize->price}})</p>
                                            @endif
                                            @if(Session::has('customerID'))
                                            @if($resultProductSize->eventType==2 )
                                            <input class="form-control" type="text" name="email" id="email" plcaholder='Enter Your Email Id' value="" required/>
                                            
                                            <div class="file_select">
                                                <input name="image" maxlength="200" id="image" type="file" value="" required accept="image/*"/> <br>
                                                (
                                                Please upload @if($resultProductSize->unpaidOption==2) Facebook @elseif($resultProductSize->unpaidOption==3) Tweeter @elseif($resultProductSize->unpaidOption==4) Instagram @endif screenshot.
                                                )
                                            </div>
                                            @endif
                                            <br>
                                            <button type="submit" class="btn btn-grey video-btn-right" style="color:#FFFFFF; margin-right:0px;"><span><b>Submit</b></span></button>
                                            @else
                                            <input type="hidden" name="redirecturl" id="redirecturl" value="{{Request::fullUrl()}}" />
                                            <button type="submit" class="btn btn-grey video-btn-right pull-right" style="color:#FFFFFF; margin-right:0px;"><span><b>Login</b></span></button>
                                            @endif
                                            
                                        </li>
                                    </ul>
                                </form>
                                @endif
                                @endif
                                @endforeach
                                <h5>&nbsp&nbsp Supported By {{ $data['prodcutOrderRecordCount'] }} Donations:</h5><br><br>
                                <div class="marquee-sc microsoft navbar-collapse">
                                    <div class="marquee">
                                        <?php
                                        $getorder_detail=Order_details::select('customerID','price','orderDetailsID')->where('productID',$qGetProductResult[0]->productID)orderBy('orderDetailsID','desc')->get();
                                        
                                        foreach ($getorder_detail as $show_getorder_detail) {
                                        
                                        $recordCount = count($show_getorder_detail);
                                        if($recordCount>0)
                                        {
                                        $getcomment_count= Comment::where('order_id',$show_getorder_detail['orderDetailsID'])->count();
                                        
                                        if($getcomment_count>0){
                                        $getcomment= Comment::where('order_id',$show_getorder_detail['orderDetailsID'])->first();
                                        $doner=Customer::select('firstName','lastName')->find($show_getorder_detail['customerID']);
                                        ?>
                                        <div class="row">
                                            
                                            <div class="col-sm-12 style="overflow-y: scroll; height: 200px"">
                                                <div class="marq-sc ">
                                                    <div class="marq-usr-icon">
                                                        <div class="thumbnail">
                                                            <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                                            </div><!-- /thumbnail -->
                                                            </div><!-- /col-sm-1 -->
                                                            
                                                            <div class="marq-txt">
                                                                <div class="marq-heading">
                                                                    <strong> @if($getcomment['display_name']=='1') 
                                                                       Anonymous Donor 
                                                                      @else
                                                                      {{ $doner['firstName'].' '.$doner['lastName'] }}
                                                                     @endif 
                                                                    </strong> <span class="text-muted"> 
                                                                    @if($getcomment['display_amount']!='1')
                                                                     ${{ $show_getorder_detail['price'] }}
                                                                     @else
                                                                     N/A
                                                                    @endif
</span>
                                                                </div>
                                                                <div class="marq-body">
                                                                    {{ $getcomment['comment'] }}
                                                                    </div><!-- /panel-body -->
                                                                    </div><!-- /panel panel-default -->
                                                                    </div><!-- /panel panel-default -->
                                                                    </div><!-- /col-sm-5 -->
                                                                    
                                                                    </div><br><!-- /row -->
                                                                    
                                                                    
                                                                    <?php
                                                                    
                                                                    } // inner if
                                                                    
                                                                    } // if
                                                                    } //while
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            @endif
                                                           
                                                        </div>
                                                        <!--div class="content-widget">
                                                        <form action="{{ url('/') }}/action/addtocart" method="POST">
                                                            <input type="hidden" id="projectcreatedBy" name="projectcreatedBy" value="{{$qGetProductResult[0]->createdBy}}" />
                                                            <input type="hidden" name="productID" id="productID" value="{{$qGetProductResult[0]->productID}}" />
                                                            <input type="hidden" name="sizeID[]" value="1">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <ul class="category-widget list-unstyled">
                                                                <li>
                                                                    <a href="##" class="link cat-item">
                                                                        <span class="pull-left">Main Item</span>
                                                                        <button type="submit" class="btn btn-grey video-btn-right pull-right" style="color:#FFFFFF; margin-right:0px;"><span><b>Donate</b></span></button>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </form>
                                                    </div-->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="back">
                            <a href="{{ URL::previous() }}" title="BACK">&lt; BACK</a>
                        </div>