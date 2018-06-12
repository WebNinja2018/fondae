<div class="modal fade" id="myModal_{{  $GetAllLinks->linksID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Links View</h4>
      </div>
      <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Name </th>
                    <td>{{ $GetAllLinks->name }}</td>
                </tr>
                @if(strlen($GetAllLinks->linksImage)>0)
                <tr>	
                	<th style="width:30%;">Image</th>
                    <td><img src="{{ url('/') }}/upload/links/{{ $GetAllLinks->linksImage }}"/></td>
                </tr>
                @endif
                <tr>	
                	<th style="width:30%;">Description </th>
                    <td> {!! $GetAllLinks->description !!}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Display Order </th>
                    <td> {{ $GetAllLinks->displayOrder }}</td>
                </tr>
                 <tr>	
                	<th style="width:30%;">Status </th>
                    <td>@if($GetAllLinks->isActive == 1) Active @else InActive @endif</td>
                </tr>
             </table>
      </div>
      <?php /*?><div class="modal-body">
        <b>isFeatured ? : </b>@if($GetAllLinks->isFeature == 1) Yes @else No @endif
      </div><?php */?>
    </div>
  </div>
</div>