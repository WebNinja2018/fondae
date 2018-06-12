<div class="modal fade" id="myModal_{{ $GetAllFormbuilder->formID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Form information</h4>
      </div>
      <div class="modal-body">
      	<table class="table table-striped table-bordered">
	  			@if(strlen($GetAllFormbuilder->formName)>0)
            	<tr>
                    <th>Form Name </th>
                    <td>{{ $GetAllFormbuilder->formName }}</td>
                 <tr>
              @endif
              @if(strlen($GetAllFormbuilder->formLabel)>0)
              	<tr>
                    <th>Form Label </th>
                    <td>{{ $GetAllFormbuilder->formLabel }}</td>
                 <tr>
              @endif
              @if(strlen($GetAllFormbuilder->created_at)>0)
              <tr>
                    <th>Created Date  </th>
                    <td> {{ $GetAllFormbuilder->created_at }}</td>
                 <tr>
	  			@endif
         </table>
      </div>
    </div>
  </div>
</div>