<script src="{{url('/')}}/components/front-end/js/bootstrap-portfilter.min.js"></script>
<?php 
use App\Http\Models\Product_category;
$Product_category = new Product_category?>

@if($ProductCategoryRecordCount > 0)
   <button class="button is-checked" data-filter="">
        <span><i class="fa fa-list" ></i>
        </span>
        <p>Any</p>
    </button>
    @foreach($qGetProductCategoryResult as $resultProductCategory)
          <?php //$recordProductCategory= count($Product_category->where('categoryID',$resultProductCategory->categoryID)->get()); 
                $recordProductCategory= 1;
          ?>
          @if($recordProductCategory>0)
              <button class="button" data-filter=".{{ $resultProductCategory->categoryname}}">
                <span>
                    <i class="{{$resultProductCategory->classname}}" ></i>
                </span>
                <p>{{ $resultProductCategory->categoryname}}</p>
             </button>
          @endif
    @endforeach
            
@endif