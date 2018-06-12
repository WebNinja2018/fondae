<script type="text/javascript">
	function fun_pagenavigation(pageNo){
		frmobj = window.document.frm_news;
		frmobj.currentPage.value = pageNo;
		frmobj.submit();
	}
	function funGetStaffCategory()
	{
		frmobj = window.document.frm_staff;
		var catgory = frmobj.category.value;
		if(catgory!=''){
			frmobj.action="{{url('/')}}/staff/"+catgory;
		}else{
			frmobj.action="{{url('/')}}/staff";
		}
		frmobj.submit();
	}
</script>

@if($staffRecordCount > 0)
    <?php /*?><form name="frm_staff" method="post" id="frm_staff" action="">
        <div class="col-xs-6 col-sm-4 col-md-3 pull-right">
            <div class="row">
                <div class="select_categories">
                    <select name="category" id="category" class="form-control" onchange="return funGetStaffCategory();">
                        <option value="">All Categories</option>
                        @foreach($qGetStaffCategoryData as $resultStaffCategory )
                        	<option value="{{$resultStaffCategory->urlName}}" @if($resultStaffCategory->urlName==$staffCategory) selected='selected' @endif >{{$resultStaffCategory->categoryname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form><?php */?>
     <div class="section staff-list best-staff">
        @foreach($qGetStaffData as $resultStaffData){{--Display All News Record--}}
        <div class="col-md-3 col-sm-4 col-xs-6 our_staff">  
            <div class="staff-item customize">
                <div class="staff-item-wrapper">
                    <div class="staff-info">	
                        <a href="{{url('/').'/staff_details/'.$resultStaffData->url_title}}" class="staff-avatar">
                        	<div class="staff_img_size">
                                @if((file_exists(public_path().'/upload/staff/th_'.$resultStaffData->imgFileName_staff) && strlen($resultStaffData->imgFileName_staff) > 0 && $resultStaffData->position_public==1)) {{--Conditon For if News image is Delete in folder. And 'rootPath' is set in config file--}}
                                    <img class="img-responsive" src="{{url('/').'/upload/staff/th_'.$resultStaffData->imgFileName_staff}}" alt="{{$resultStaffData->firstname}}" title="{{$resultStaffData->firstname}}">
                                @else
                                    <img class="img-responsive" src="{{url('/').'/components/images/no-images.png'}}" alt="{{$resultStaffData->firstname}}" title="{{$resultStaffData->firstname}}">
                                @endif
                            </div>
                        </a>
                        <a href="#" class="staff-name">@if($resultStaffData->firstname_public==1){{$resultStaffData->firstname}}@endif @if($resultStaffData->lastname_public==1){{$resultStaffData->lastname}}@endif</a>
                        <div class="staff-job">@if($resultStaffData->position_public==1){{$resultStaffData->position}}@endif</div>
                        <div><a href="{{url('/').'/staff_details/'.$resultStaffData->url_title}}" class="btn read_more">Read More..</a></div>
                     </div>
               </div>
               	<div class="staff-socials">
                  <a @if(strlen($resultStaffData->facebook)>0) href="{{$resultStaffData->facebook}}" target="_blank"  @else href="##" @endif  class="facebook">
                      <i class="fa fa-facebook"></i>
                  </a>
                  <a @if(strlen($resultStaffData->google)>0) href="{{$resultStaffData->google}}" target="_blank"  @else href="##" @endif class="google">
                      <i class="fa fa-google-plus"></i>
                  </a>
                  <a @if(strlen($resultStaffData->twitter)>0) href="{{$resultStaffData->twitter}}" target="_blank"  @else href="##" @endif class="twitter">
                      <i class="fa fa-twitter"></i>
                  </a>
                </div>
            </div>
        </div>		
        @endforeach
    </div>
	<?php /*?><nav class="pagination col-md-12">
        <ul class="pagination__list">
            <li class="pagination__previous btn-squae"> @include('include.pagination', ['paginator' => $qGetStaffData])</li>
        </ul>
    </nav><?php */?>
@else
	<h3 align="center">Record not found</h3>
@endif