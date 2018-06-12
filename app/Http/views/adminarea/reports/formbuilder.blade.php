@extends('adminarea.home')
@section('content')

<script type="text/javascript">
	function fun_emailset(formID)
	{
		frmobj=window.document.frm_formbuilder;
		frmobj.formID.value=formID;
		document.frm_formbuilder.action="{{ url('/') }}/adminarea/report/emailsetting";
		frmobj.submit();
	}
	function fun_single_delete(formID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/report/formbuildersingledelete",
				data: "formID=" + formID,
				success: function(total){
				$("#ID_"+formID).animate({ opacity: "hide" }, "slow");
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
			  frmobj=window.document.frm_formbuilder;
			  frmobj.method.value="multipleDelete";
			  document.frm_formbuilder.action="{{ url('/') }}/adminarea/report/formbuilder";
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
		var frmobj=window.document.frm_formbuilder;
		frmobj.submit();
	}
	
	
	function fun_reset()
	{
		var frmobj=window.document.frm_formbuilder;
		frmobj.srach_formName.value='';
		frmobj.startDate.value='';
		frmobj.endDate.value='';
		frmobj.action="{{ url('/') }}/adminarea/report/formbuilder";
		frmobj.submit();
	}
	function fun_formbuilderSearch(srach_formName)
	{
		var frmobj=window.document.frm_formbuilder;
		frmobj.srach_formName.value=srach_formName;
		frmobj.action="{{ url('/') }}/adminarea/report/formbuilder";
		frmobj.submit();
	}
</script>
<?php
$formID=Input::get('formID')?Input::get('formID'):'';
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$formName=Input::get('srach_formName')?Input::get('srach_formName'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_formbuilder" id="frm_formbuilder" method="post" action="{{ url('/') }}/adminarea/report/formbuilder">
<input type="hidden" name="formID" value="1" id="formID" />
<input type="hidden" name="listPage" value="contactus" id="listPage"/>
<input type="hidden" name="listPage_name" value="Formbuilder" id="listPage_name"/>
<input type="hidden" name="method" value="" id="method"/>
<input type="hidden" name="redirects_to" id="redirects_to" value="{{Request::fullUrl()}}" />

    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Formbuilder</li>
    </ol>
    
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a class="add_edit_btn" href="javascript:;" onclick="funToggleSearch('Formbuilder');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
    <section class="content-header top_header_content" id="searchSectionFormbuilder" @if(Session::get('searchSectionFormbuilder')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                               <li><a href="javascript:fun_formbuilderSearch('')">All</a></li>
                                  @for($i=65;$i<=90;$i++)
                                      <li><a href="javascript:fun_formbuilderSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                  @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="text" name="srach_formName" class="form-control" id="srach_formName" value="{{ $formName }}" placeholder="Your Name">
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
              <!-- strat box area-->
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
                             <th>Form Name</th>
                             <th>Form Label</th>
                             <th>Created Date</th>
                             <th>View</th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount)) <?php $no_row=1;?>
                                @foreach($qGetAllFormbuilder as $GetAllFormbuilder)
                                    <tr  id="ID_{{ $GetAllFormbuilder->formID }}" @if($GetAllFormbuilder->formID==$formID) class="bg-warning" @endif>
                                        <td>
                                            <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllFormbuilder->formID }}" type="checkbox" />
                                        </td>
                                        <td>
                                           <a href="javascript:javascript:fun_emailset({{ $GetAllFormbuilder->formID }});"  title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                           &nbsp;<a href="javascript:fun_single_delete({{ $GetAllFormbuilder->formID }});"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllFormbuilder->formName }}</td>
                                        <td>{{ $GetAllFormbuilder->formLabel }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllFormbuilder->created_at)) }}</td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllFormbuilder->formID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.reports.formbuilder-view')
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
                         <?php /*?>{!! $qGetAllFormbuilder->render() !!}<?php */?>
                          @include('adminarea.pagination', ['paginator' => $qGetAllFormbuilder])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
          </div>
    </section>
</form>
@endsection