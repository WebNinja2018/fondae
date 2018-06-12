<div class="modal fade" id="myModal_{{ $GetAllStaff->staffID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllStaff->firstname}} {{ $GetAllStaff->lastname}}</h4>
      </div>
      <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Name </th>
                    <td>{{ $GetAllStaff->firstname}} {{ $GetAllStaff->lastname}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Position </th>
                    <td> {{ $GetAllStaff->position}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Email </th>
                    <td>{{ $GetAllStaff->email}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Phone </th>
                    <td>{{ $GetAllStaff->telephone}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Biography </th>
                    <td> {!! $GetAllStaff->bio !!}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Display Order </th>
                    <td> {{ $GetAllStaff->displayOrder}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Date</th>
                    <td>{{ date('m/d/Y',strtotime($GetAllStaff->created_at))}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status </th>
                    <td>@if($GetAllStaff->isActive == 1) Active @else InActive @endif</td>
                </tr>
                @if(strlen($GetAllStaff->imgFileName_staff)>0)
                <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/upload/staff/{{ $GetAllStaff->imgFileName_staff }}" /></td>
                </tr>
                @endif
             </table>
       </div>
    </div>
  </div>
</div>