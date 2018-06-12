@extends('adminarea.home')
@section('content')
@include('adminarea.product.product-js')
<script type="text/javascript" src="{{ url('/components/js/jquery-ui_drop.js') }}"></script>

<script>
	$(function() {
		  $('.submitbuttonSave').click(function()
		  {
			  var h = [];
			  $(".innerproduct_order_col").each(function() {  h.push($(this).attr('id').substr(9));  });
			  $.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/product/saveorder",
				data: 'item='+h,
				success: function(data)
				{
					window.location.reload();
				}
				});
				setTimeout(function(){
				  $(".flash").slideUp("slow", function () {
				  $(".flash").hide();
				}); }, 3000);
			});
		  
			$( "#sortable" ).sortable({
			revert: true
			});
			$( "ul, li" ).disableSelection();
		});
</script>


<style>
	.innerproduct_order_col{border:1px solid #dddddd; line-height:1.42857;padding:8px;border-collapse:collapse;cursor:pointer;}
	.ui-sortable-helper{padding:8px !important;line-height:1.42857 !important; height:38px !important;}
</style>

<?php
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$srach_name=Input::get('srach_name')?Input::get('srach_name'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';

	$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
	if(strlen($redirects_to)==0){
	$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/product';
	}
?>

<form class="form-inline" role="form" name="frm_product_addedit" method="post" action="{{ url('/') }}/adminarea/product/saveorder">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="productID" />
<input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >


<div class="right_side" role="main">
    <div class="center_container">
        <ul class="breadcrumb">
          <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
          <li><a href="{{ url('/') }}/adminarea/product">Product Management</a></li>
          <li class="active">Product Order</li>
        </ul>
    </div>
    <div class="panel row">
      <div class="panel-body">
        <div class="col-md-6" role="main">
        	 @include('adminarea.include.message')
            <div class="table-responsive">
              <table class="table table-bordered">
				  <tr>
                    <th width="23%">Product Title</th>
                  </tr>
                  <tr>
                      <td colspan="2">
                            <div id="sortable">
								@if(isset($recordcount)) 
								<?php $no_row=1; ?>
                                     @foreach($qGetAllProduct as $GetAllproduct)
                                      <div id="image_li_{{$GetAllproduct->productID}}" class="innerproduct_order_col ui-sortable-handle" >
                                         {{ $GetAllproduct->productName}}
                                      </div>
                                    <?php $no_row++; ?>
									@endforeach
                                 @else
                                       <div>Record Not Found</div>
                                 @endif
                            </div>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="6">
                        <div class="col-sm-offset-2 col-sm-10">
                           <button type="button" class="btn btn-default btn-primary submitbuttonSave">Save</button>
                           <button class="btn btn-default" type="button" onclick="fun_back_ganaral(0)">Back</button>
                        </div>
                    </td>
                  </tr>
              </table>
            </div>
         </div>
      </div>
    </div>
</div>
</form>
@endsection