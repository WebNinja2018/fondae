<script>
function fun_emptycart(cartID)
	{
		if(confirm("Are you sure want to delete selected event? "))
		{
			$.ajax({
					type: "POST",
					url: "{{ url('/') }}/ajax/deleteCart",
					data: "cartID="+cartID,
					success: function(result)
					{
						window.location.reload();
					}
				});
		}
	}
</script>
<!--<div class="check_out_right">
  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 step_bg">
  <h2>Event Summary  <a class="edit" title="Edit" href="{{url('/explore')}}">Edit</a></h2>
  </div>
  <!-- checkout right side border area>
  <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 ">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 checkout_product_panel">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 checkout_product">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Event name</th>
                        <th style="width:16%">Image</th>
                    </tr>
                    <?php //dd($qGetCartData);?>
					@foreach($qGetCartData as $resultProductData)
                    <tr>
                        <td><p class="product_title">{{$resultProductData->productName}}&nbsp;&nbsp;&nbsp;<a onclick="fun_emptycart({{$resultProductData->cartID}})"><span style="color:#e8ae00;" class="glyphicon glyphicon-trash"></span></a></p></td>
                        <td>
                        @if(strlen($resultProductData->prodcutImage)>0)
                          <img src="{{ url('/') }}/upload/product/mainimages/{{ $resultProductData->prodcutImage }}" height="50" width="50" />
                        @endif
                        </td>
					</tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
  </div>
  <!-- checkout right side border area end>
</div -->