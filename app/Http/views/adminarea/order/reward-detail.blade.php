@extends('adminarea.home')
@section('content')
<?php use App\Http\Models\Customer; ?>
<script type="text/javascript">
	function printDiv(divName) /*Print Funation*/
	{
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>

<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#description').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<ol class="breadcrumb">
	<li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="##"> Donation</a></li>
    <li class="active">Reward Detail</li>
</ol>

<section class="content-header top_header_content">
    <div class="box">
        <div class="property_add">
            <div class="box-title with-border">
           		<h2 class="col-sm-6 text-left">Reward Detail</h2><div class="col-sm-6 control-label text-right" style="float:right"><a href="javascript:printDiv('printableArea');" class="btn btn-default btn-warning "><span>Print Invoice</span></a>&nbsp;&nbsp;<?php /*?><a href="{{url('/adminarea/order')}}" class="btn btn-default btn-warning "><span>< Back</span></a><?php */?></div>
           	</div>
            <div class="addunit_forms" id="printableArea">
                <div class="box-body">
               		<div class="form-group">
                    	<div class="col-sm-9 col-xs-9 col-md-9">
                        	<div class="row"><?php //print_r($qGetOrderlist);exit;?>
                                <label class="col-sm-6 col-md-6 col-xs-12 control-label text-left">Reward Donation Number : <a href="##">{{$qGetOrderlist[0]->orderNumber}}</a></label>
                                <label class="col-sm-6 col-md-6 col-xs-12 control-label text-left">Reward Donation Date :<span> {{date('m/d/Y',strtotime($qGetOrderlist[0]->created_at))}}</span></label>
                                <?php /*?><label class="col-sm-3 col-md-3 col-xs-12 control-label text-left">Order Status : <span> {{$qGetOrderlist[0]->orderName}} </span></label><?php */?>
                        	</div>
                        </div>
                    </div>
                    <div class="form-group">
                    	<div class="col-sm-12 col-xs-12 col-md-12">
							<div class="row">
                            	<div class="col-sm-8 col-xs-8 col-md-8">
                                   <div class="table-responsive data_view_table">
                                      <table id="example" class="table-bordered table-striped table-hover table">
                                            <thead>
                                            	<tr>
													<th colspan="2">Member Detail</th> 
                                            	</tr>
                                             </thead>
                                             <tbody>
                                             	<tr>
                                                	<td style="width:30%;"><label class="control-label text-left">Member Name </label></td>
                                                    <td>{{ $qGetOrderlist[0]->firstName }} {{ $qGetOrderlist[0]->lastName }}</td>
                                                </tr>
                                                <tr>
                                                	<td style="width:30%;"><label class="control-label text-left">Email</label></td>
                                                    <td>{{ $qGetOrderlist[0]->email }}</td>
                                                </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                </div>                     	
                             </div>
							<br />
                        </div>
                    </div>
                    
                    @if($qGetOrderlist[0]->unpaidOption==1)
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                 <div class="table-responsive">
                                  <table class="table table-striped table-hover table-bordered">
                                     <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Event Detail</th>
                                            <th>Reward Type</th>
                                            <th>Email</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php $i=1; //dd($qGetOrderlist);?>
                                        @foreach($qGetOrderlist as $resultCartData)	
                                        <?php $productcreatedBy=Customer::find($resultCartData->createdBy);?>                                        
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>
                                                    <div class="checkout_product">
                                                        <h5><a href="{{url('/')}}/event/{{$resultCartData->url_title}}" target="_blank">{{$resultCartData->productName}}</a></h5>
                                                        By: {{$productcreatedBy->firstName}} {{$productcreatedBy->lastName}}
                                                    </div>
                                                </td>
                                                <td>@if($resultCartData->unpaidOption==1) Email @elseif($resultCartData->unpaidOption==2) Facebook @elseif($resultCartData->unpaidOption==3) Twitter @else Instagram @endif</td>
                                                <td>
                                                    <div class="checkout_product_qty">
                                                        <span>{{$resultCartData->orderEmail}}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++;?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
                        </div>
                    @else
                    	<div class="form-group">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                 <div class="table-responsive">
                                  <table class="table table-striped table-hover table-bordered">
                                     <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Event Detail</th>
                                            <th>Reward Type</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php $i=1; //dd($qGetOrderlist);?>
                                        @foreach($qGetOrderlist as $resultCartData)	
                                        <?php $productcreatedBy=Customer::find($resultCartData->createdBy);?>                                        
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>
                                                    <div class="checkout_product">
                                                        <h5><a href="{{url('/')}}/event/{{$resultCartData->url_title}}" target="_blank">{{$resultCartData->productName}}</a></h5>
                                                        By: {{$productcreatedBy->firstName}} {{$productcreatedBy->lastName}}
                                                    </div>
                                                </td>
                                                <td>@if($resultCartData->unpaidOption==1) Email @elseif($resultCartData->unpaidOption==2) Facebook @elseif($resultCartData->unpaidOption==3) Twitter @else Instagram @endif</td>
                                            </tr>
                                        <?php $i++;?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                 <div class="table-responsive">
                                  <table class="table table-striped table-hover table-bordered">
                                     <thead>
                                        <tr>
                                           <th>Upload Image</th>
                                        </tr>
                                      </thead>
                                      <tbody align="center">
                                        <?php $i=1; //dd($qGetOrderlist);?>
                                        @foreach($qGetOrderlist as $resultCartData)	                                        
                                            <tr>
                                                <td><img src="{{ url('/') }}/upload/eventshare/th_{{ $resultCartData->image}}" height="500" /></td>
                                            </tr>
                                        <?php $i++;?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                    	<div class="col-sm-12 col-xs-12 col-md-12">
                             <div class="table-responsive">
                             <form name="frm_reward" id="frm_reward"  action="{{ url('/') }}/adminarea/order/reward" method="post" class="form-horizontal" enctype="multipart/form-data" >
                              <input type="hidden" class="form-control" name="customerEmail" id="customerEmail" value="{{ $qGetOrderlist[0]->email }}" required>
                              <table class="table table-striped table-hover table-bordered">
                              	 <thead>
                                    <tr>
                                        <th colspan="2" style="text-align:center;">Reward</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  		<tr>
                                            <td width="20%">Subject</td>
                                            <td>
                                               <input type="text" class="form-control" name="subject" maxlength="200" id="subject" placeholder="Subject" value="" required >
                                            </td>
                                        </tr>
                                    	<tr>
                                            <td width="20%">Description</td>
                                            <td>
                                               <textarea id="description" name="description" required></textarea>
                                               <br> 
                                               <input type="submit" class="btn btn-warning waves-effect waves-light" name="Send" value="Send">
                                            </td>
                                        </tr>
                                   
                                    </tbody>
                                </table>
                                </form>
                             </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
   </div>
</section>

@endsection