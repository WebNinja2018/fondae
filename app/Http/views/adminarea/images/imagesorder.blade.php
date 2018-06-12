@extends('adminarea.home')
@section('content')
@include('adminarea.images.images-js')
<script type="text/javascript" src="{{ url('/components/js/jquery-ui_drop.js') }}"></script>

<script>
	$(function() {
		  $('.submitbuttonSave').click(function()
		  {
			  var h = [];
			  $(".innerproduct_order_col").each(function() {  h.push($(this).attr('id').substr(9));  });
			  $.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/images/saveorder",
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
	$title=Input::get('srach_title')?Input::get('srach_title'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
	$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
?>

<form class="form-inline" role="form" name="frm_images_addedit" method="post" action="{{ url('/') }}/adminarea/images/saveorder">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="imagesID" />
<input type="hidden" value="{{ $redirects_to }}" name="redirects_to"  id="redirects_to"/>

<div class="right_side" role="main">
    <div class="center_container">
        <ul class="breadcrumb">
          <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
          <?php /*?><li><a href="{{ url('/') }}/adminarea/images">Images Management</a></li><?php */?>
          <li class="active">Images Order</li>
        </ul>
    </div>
    <div class="panel row">
      <div class="panel-body">
        <div class="col-md-6" role="main">
        	 @include('adminarea.include.message')
            <div class="table-responsive">
              <table class="table table-bordered">
				  <tr>
                    <th width="23%">Images Title</th>
                  </tr>
                  <tr>
                      <td colspan="2">
                            <div id="sortable">
								@if(isset($recordcount)) 
								<?php $no_row=1; ?>
                                     @foreach($qGetAllImages as $GetAllimages)
                                      <div id="image_li_{{$GetAllimages->imagesID}}" class="innerproduct_order_col ui-sortable-handle" >
                                         {{ $GetAllimages->imagesName}}
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
                           <button type="button" class="btn btn-default" type="button" onclick="fun_back()">Back</button>
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