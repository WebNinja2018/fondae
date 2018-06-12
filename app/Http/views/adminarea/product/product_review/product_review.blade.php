<div class="col-md-13"role="main">
    <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
                <!--<th width="5%">
                    <input name="checkall" id= "checkall" value="" type="checkbox" />
                </th>-->
                <th width="5%">Action</th>
                <th width="10%">Customer Name</th>
                <th width="10%">Title</th>
                 <th width="40%">Review</th>
                <th width="15%">Created Date</th>
                <th width="10%">Status</th>
              </tr>
              @if($GetSingleProductReview > 0) <?php $no_row=1;?>
                 @foreach($GetSingleProductReview['data'] as $SingleProductReview)
                  <tr id="ID_{{$SingleProductReview->reviewID}}">
                    <td>
                        <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete_review({{ $SingleProductReview->reviewID}});"></a>
                    </td>
                    <td>
                        {{$SingleProductReview->customerFirstname}} {{$SingleProductReview->customerLastame}}
                    </td>
                    <td>{{$SingleProductReview->reviewTitle}}</td>
                    <td>
                        {{$SingleProductReview->productreview}}
                    </td>
                    <td>{{date('m/d/Y',strtotime($SingleProductReview->createdDate))}}</td>
                    <td>
                        <a href="javascript:fun_single_status_review({{$SingleProductReview->reviewID}});">
                            <span id="status_{{$SingleProductReview->reviewID}}">
                                @if($SingleProductReview->isActive==1) Active @else Inactive @endif
                            </span>
                        </a>
                    </td>
                <?php $no_row++; ?>
				@endforeach
              @else
               <tr>
                    <td colspan="6" align="center">Record Not Found</td>
              </tr>
              @endif
          </table>
    </div>
</div>