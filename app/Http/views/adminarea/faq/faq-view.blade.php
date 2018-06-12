<div class="modal fade" id="myModal_{{ $GetAllFaq->faqID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">FAQ View</h4>
      </div>
      <div class="modal-body">
      	<table class="table table-striped table-bordered">
            <tr>
                <th style="width:30%;">Question </th>
                <td>{{ $GetAllFaq->question }}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Answer</th>
                <td>{!! $GetAllFaq->answer !!}</td>
            </tr>
            <tr>	
                <th style="width:30%;">Status</th>
                <td>@if($GetAllFaq->isActive == 1) Active @else InActive @endif</td>
            </tr>
         </table>
      </div>
    </div>
  </div>
</div>