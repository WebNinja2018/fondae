<div class="modal fade" id="myModal_{{ $GetAllCommonmessage->commonmessageID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllCommonmessage->variableName}}</h4>
      </div>
      <div class="modal-body">
          <table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Name </th>
                    <td>{{ $GetAllCommonmessage->variableName}}</td>
                </tr>
               <tr>
                	<th style="width:30%;">Value </th>
                    <td>{{ $GetAllCommonmessage->description}}</td>
                </tr>
           </table>
      </div>
    </div>
  </div>
</div>