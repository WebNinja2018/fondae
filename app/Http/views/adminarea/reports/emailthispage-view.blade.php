<div class="modal fade" id="myModal_{{ $GetAllEmailthispage->recommendusID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact us information</h4>
      </div>
      <div class="modal-body">
      	<table class="table table-striped table-bordered">
          @if(strlen($GetAllEmailthispage->yourName)>0)
          	 <tr>
            	<th>Your Name </th>
                <td> {{ $GetAllEmailthispage->yourName }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->yourEmail)>0)
          	 <tr>
            	<th>Your Email</th>
                <td> {{ $GetAllEmailthispage->yourEmail }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->friendName)>0)
          	 <tr>
            	<th>Friend Name </th>
                <td> {{ $GetAllEmailthispage->friendName }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->friendEmail)>0)
          	 <tr>
            	<th>Friend Email</th>
                <td>{{ $GetAllEmailthispage->friendEmail }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->message)>0)
          	 <tr>
            	<th>Comment </th>
                <td> {{ $GetAllEmailthispage->message }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->pageLink)>0)
          	 <tr>
            	<th>Page Link </th>
                <td>{{ $GetAllEmailthispage->pageLink }}</td>
             <tr>
          @endif
          @if(strlen($GetAllEmailthispage->created_at)>0)
          	 <tr>
            	<th>Created Date </th>
                <td> {{ $GetAllEmailthispage->created_at }}</td>
             <tr>
          @endif
          </table>
       </div>
    </div>
  </div>
</div>