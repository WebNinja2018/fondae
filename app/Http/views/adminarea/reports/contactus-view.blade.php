<div class="modal fade" id="myModal_{{ $GetAllContact->contactusID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Contact us information</h4>
      	</div>
      <div class="modal-body">
      	<table class="table table-striped table-bordered">
          @if(strlen($GetAllContact->firstName)>0)
             <tr>
            	<th>First Name </th>
                <td>{{ $GetAllContact->firstName }}</td>
             <tr>
          @endif
          @if(strlen($GetAllContact->lastName)>0)
          	<tr>
            	<th>Last Name </th>
                <td> {{ $GetAllContact->lastName }}</td>
             <tr>
          @endif
          @if(strlen($GetAllContact->email)>0)
          	<tr>
            	<th>Email </th>
                <td> {{ $GetAllContact->email }}</td>
             <tr>
          @endif
          @if(strlen($GetAllContact->phone)>0)
          	<tr>
            	<th>Phone</th>
                <td>{{ $GetAllContact->phone }}</td>
             <tr>
          @endif
          @if(strlen($GetAllContact->comment)>0)
          	<tr>
            	<th>Comment</th>
                <td> {{ $GetAllContact->comment }}</td>
             <tr>
          @endif
          @if(strlen($GetAllContact->created_at)>0)
          	<tr>
            	<th>Created Date</th>
                <td> {{ $GetAllContact->created_at }}</td>
             <tr>
          @endif
       </table>
     </div>
    </div>
  </div>
</div>