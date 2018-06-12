<div class="modal fade" id="myModal_{{ $GetAllPortfolio->portfolioID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $GetAllPortfolio->portfolioTitle}}</h4>
      </div>
      <div class="modal-body">
      		<table class="table table-striped table-bordered">
          		<tr>
                	<th style="width:30%;">Body </th>
                    <td>{{ $GetAllPortfolio->body}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">date</th>
                    <td>{{ date('m/d/Y',strtotime($GetAllPortfolio->created_at))}}</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Status </th>
                    <td>@if($GetAllPortfolio->isActive == 1) Active @else InActive @endif</td>
                </tr>
                <tr>	
                	<th style="width:30%;">Featured </th>
                    <td>@if($GetAllPortfolio->featured == 1) Yes @else No @endif</td>
                </tr>
                 @if(strlen($GetAllPortfolio->imgFileName_portfolio)>0)
                <tr>	
                	<th style="width:30%;">Image </th>
                    <td><img src="{{ url('/') }}/upload/portfolio/mainimages/th_{{ $GetAllPortfolio->imgFileName_portfolio}}" /></td>
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