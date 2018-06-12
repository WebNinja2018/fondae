@extends('adminarea.home')
@section('content')

<script type="text/javascript">
	function fun_emailset(formID)
	{
		frmobj=window.document.frm_emailnews;
		frmobj.formID.value=formID;
		document.frm_emailnews.action="{{ url('/') }}/adminarea/report/emailsetting";
		frmobj.submit();
	}
	function fun_single_delete(mailingID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/report/emailnewssingledelete",
				data: "mailingID=" + mailingID,
				success: function(total){
				$("#ID_"+mailingID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
	function fun_multipleDelete()
	{
	  var count = $(":checkbox:checked").length;
	  if(count > 0)
	  {
		  var status = confirm("Are you sure want to delete this record?");
		  if(status==true)
		  {
			  frmobj=window.document.frm_emailnews;
			  frmobj.method.value="multipleDelete";
			  document.frm_emailnews.action="{{ url('/') }}/adminarea/report/emailnews";
			  frmobj.submit();
		  }
	  }
	  else
	  {
		alert('Please select atleast one record.');
	  }
	}

	function fun_search()
	{
		var frmobj=window.document.frm_emailnews;
		frmobj.submit();
	}
	
	
	function fun_reset()
	{
		var frmobj=window.document.frm_emailnews;
		frmobj.srach_email.value='';
		frmobj.startDate.value='';
		frmobj.endDate.value='';
		frmobj.action="{{ url('/') }}/adminarea/report/emailnews";
		frmobj.submit();
	}
	function fun_emailnewsSearch(srach_email)
	{
		var frmobj=window.document.frm_emailnews;
		frmobj.srach_email.value=srach_email;
		frmobj.action="{{ url('/') }}/adminarea/report/emailnews";
		frmobj.submit();
	}
	/******************* CHECK ALL CHECKBOX *****************/
	jQuery(document).ready(function($)
	{
		$('#checkall').click(function()
		{
			$(':checkbox').each(function()
			{
				if(this.checked)
				{
					this.checked = false;
				}
				else
				{
					this.checked = true;
				}
			});
			return false;
		}); 
	}); 
	/***************** DATE PICKER ******************/
</script>
<?php
$mailingID=Input::get('mailingID')?Input::get('mailingID'):'';
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$email=Input::get('srach_email')?Input::get('srach_email'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_emailnews" id="frm_emailnews" method="post" action="{{ url('/') }}/adminarea/report/emailnews">
<input type="hidden" name="formID" value="2"  />
<input type="hidden" name="listPage" value="contactus" />
<input type="hidden" name="listPage_name" value="Email News" />
<input type="hidden" value="" name="mailingID" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" id="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Email News</li>
    </ol>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_emailset(2);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp;&nbsp;Email Setting</a>
						<a class="export_contact" href="{{url('/adminarea/report/getExportEmailnews')}}"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export List</a>
                        <a class="add_edit_btn" href="javascript:;" onclick="funToggleSearch('Emailnews');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
    <section class="content-header top_header_content" id="searchSectionEmailnews" @if(Session::get('searchSectionEmailnews')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                               <li><a href="javascript:fun_emailnewsSearch('')">All</a></li>
                                  @for($i=65;$i<=90;$i++)
                                      <li><a href="javascript:fun_emailnewsSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                  @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="text" name="srach_email" class="form-control" id="srach_email" value="{{ $email }}" placeholder="Your Name">
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <div id="sandbox-container" class="date_for_search">
                                        <input type="text" class="form-control" name="startDate" placeholder="Date From" value="{{ $startDate }}" id="startDate">
                                    </div>
                                    <script type="text/javascript">
                                        $('#startDate').datepicker({
                                        multidateSeparator: "dd-mm-yyyy",
                                        keyboardNavigation: false,
                                        forceParse: false
                                        });
                                    </script>
                                    <span class="input-group-addon date_icon"><i class="glyphicon glyphicon-calendar"></i></span>
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <div id="sandbox-container" class="date_for_search">
                                        <input class="form-control" type="text" name="endDate" placeholder="Date To" value="{{ $endDate }}" id="endDate">
                                    </div>
                                    <script type="text/javascript">
                                        $('#endDate').datepicker({
                                        multidateSeparator: "dd-mm-yyyy",
                                        keyboardNavigation: false,
                                        forceParse: false
                                        });
                                    </script>
                                    <span class="input-group-addon date_icon"><i class="glyphicon glyphicon-calendar"></i></span>
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <button type="button" class="btn btn-warning waves-effect waves-light" onclick="fun_search();">Search</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="fun_reset();">Reset</button> 
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer-->
           </div>
    </section>
	<section class="content-header top_header_content">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <!-- start user management table-->
                <div class="table-responsive">
                  <table id="example" class="table-bordered table-striped table-hover table">
                        <thead>
                             <th style="width:5%;"><input name="checkall" id="checkall" value="" type="checkbox">
                                <div class="dropdown" style="float:right;">
                                  <a href="#" data-toggle="dropdown">
                                  <span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="javascript:fun_multipleDelete();" ><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                  </ul>
                                </div>
                             </th>
                             <th>Actions</th>
                             <th>Email</th>
                             <th>Created Date</th>
                             <th>View</th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount)) <?php $no_row=1;?>
                                @foreach($qGetAllEmailnews as $GetAllEmailnews)
                                    <tr  id="ID_{{ $GetAllEmailnews->mailingID }}" @if($GetAllEmailnews->mailingID==$mailingID) class="bg-warning" @endif>
                                        <td>
                                            <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllEmailnews->mailingID }}" type="checkbox" />
                                        </td>
                                        <td>
                                           <a href="javascript:fun_single_delete({{ $GetAllEmailnews->mailingID }} );"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllEmailnews->email }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllEmailnews->created_at)) }}</td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllEmailnews->mailingID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.reports.emailnews-view')
                                        </td>
                                    </tr>
                                    <?php $no_row++;?> 
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <td colspan="7" align="center">Record not found.</td>
                            </tr>
                        @endif
                                
                        </tbody>
                  </table>
                </div>
                <!-- end user management table-->
                <div class="pagination_box" id="paggination">
                    <nav aria-label="Page navigation">
                         <?php /*?>{!! $qGetAllEmailnews->render() !!}<?php */?>
                          @include('adminarea.pagination', ['paginator' => $qGetAllEmailnews])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
          </div>
    </section>
</form>
@endsection