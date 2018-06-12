<div class="modal fade" id="myModal_{{ $GetAllEmailnews->mailingID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact us information</h4>
      </div>
      <div class="modal-body">
      	<table class="table table-striped table-bordered">
             @if(strlen($GetAllEmailnews->email)>0)
             	 <tr>	
                	<th style="width:30%;">Email </th>
                    <td>{{ $GetAllEmailnews->email }}</td>
                </tr>
              @endif
              @if(strlen($GetAllEmailnews->created_at)>0)
              	 <tr>	
                	<th style="width:30%;">Created Date </th>
                    <td>{{ $GetAllEmailnews->created_at }}</td>
                </tr>
            @endif
      	</table>
      </div>
    </div>
  </div>
</div>