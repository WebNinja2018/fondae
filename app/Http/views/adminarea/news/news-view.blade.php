<div class="modal fade" id="myModal_{{ $GetAllNews->newsID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllNews->newsTitle}}</h4>
      </div>
      <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Author</th>
                    <td>{{ $GetAllNews->author}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">News date  </th>
                    <td>{{ date('m/d/Y',strtotime($GetAllNews->newsDate))}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Body </th>
                    <td> {!! $GetAllNews->body!!}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Summary </th>
                    <td> {!! $GetAllNews->summary!!}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status </th>
                    <td>@if($GetAllNews->isActive == 1) Active @else InActive @endif</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Featured </th>
                    <td>@if($GetAllNews->featured == 1) Yes @else No @endif</td>
                </tr>
                @if(strlen($GetAllNews->imgFileName_news)>0)
                <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/upload/news/th_{{ $GetAllNews->imgFileName_news}}" /></td>
                </tr>
                @else
                 <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/components/images/no-images.png" alt="" title="" /></td>
                </tr>
                @endif
             </table>
      </div>
    </div>
  </div>
</div>