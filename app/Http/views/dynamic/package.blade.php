<script type="text/javascript">
	function funGetProduct(catgory)
	{
		var frmobj=window.document.frm_product;
		var catgory=document.getElementById('category').value=catgory;
		frmobj.action="{{ url('/') }}/audio-conference/"+catgory;
		document.getElementById('frm_product').submit();
	}
</script>
<?php use App\Http\Models\Product_price;?>

@if($ProductRecordCount > 0)	
    <div class="section section-padding pricing">
        <div class="container">
            <div class="group-title-index">
				<h2 class="center-title">Annual Package</h2>
                <h4 class="top-title">Save upto <b>60%</b>, subscribe to this package now!</h4>
                <div class="bottom-title">
                    <i class="bottom-icon icon-a-1-01-01"></i>
                </div>
            </div>
            <div class="row">
                <div class="">
					@foreach($qGetProductResult as $resultProduct){{--Display All News Record--}}
						<?php 
								$Product_price= new Product_price;
								$productID=$resultProduct->productID;
								$sizeData=array('productID'=>$productID,
												 'isActive'=>1
												);
								$resultSize=$Product_price->getByAttributesQuery($sizeData);
								$price=$resultSize['data'][0]->price;
								$sizeID=$resultSize['data'][0]->sizeID;
						?>
						<form name="frm_productCart" method="post" action="{{ url('/') }}/action/addtocart">
                            <input type="hidden" name="productID" id="productID" value="{{$productID}}" />
                            <input type="hidden" name="quantity" id="quantity" value="1" />
							<input type="hidden" name="sizeID[]" id="sizeID" value="{{$sizeID}}" />
                            <div class="col-sm-3">
                                <div class="pricing-widget">
                                    <div class="pricing-header">
                                        <div class="price-cost">
                                            <div class="inner">
                                                <p data-from="0" data-to="{{$price}}" data-speed="1000" class="inner-number">{{$price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pricing-content">
                                        <h3 class="pricing-title">+</h3>
                                        <h3 class="pricing-subtitle">{{$resultProduct->productName}} </h3>
                                        <ul class="pricing-list">
                                            <li>
                                                <p>
                                                    <strong>By :</strong> {{$resultProduct->firstname}} {{$resultProduct->lastname}}
                                                </p>
                                            </li>
                                            <li>
                                                {!!$resultProduct->shortDescription!!}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pricing-button">
                                    <button type="submit" class="btn btn-grey video-btn-right pull-right" ><span><b>Add to Cart</b></span></button>
                                </div>
                            </div>
						</form>
					@endforeach
                    <nav class="pagination col-md-12">
                        <ul class="pagination__list">
                            <li>@include('include.pagination', ['paginator' => $qGetProductResult])</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@else
	<h3 align="center">Record not found</h3>
@endif