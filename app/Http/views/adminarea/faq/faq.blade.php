@extends('adminarea.home')
@section('content')
@include('adminarea.faq.faq-js')

<?php
$faqID=Input::get('faqID')?Input::get('faqID'):'';
$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
$srach_question=Input::get('srach_question')?Input::get('srach_question'):'';
$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_faq_list" id="frm_faq_list" method="post" action="{{ url('/') }}/adminarea/faq/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="faqID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">FAQ Management</li>
    </ol>
    <?php /*?><div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
        <div class="advance_button">
            <a class="" href="javascript:;" onclick="funToggleSearch('Property');"><i class="fa fa-search"></i>&nbsp; Search</a>
        </div>
    </div><?php */?>
    
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New FAQ</a>
                        <a href="javascript:fun_changeOrder();" class="add_edit_btn"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Display Order</a>
						<a class="add_edit_btn" href="javascript:;" onclick="funToggleSearch('Faq');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
    <section class="content-header top_header_content" id="searchSectionFaq" @if(Session::get('searchSectionFaq')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                               <li><a href="javascript:fun_faqSearch('')">All</a></li>
                                  @for($i=65;$i<=90;$i++)
                                      <li><a href="javascript:fun_faqSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                                  @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                     <input type="text" name="srach_question" class="form-control" id="srach_question" value="{{ $srach_question }}" placeholder="FAQ Title">
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <select class="form-control" id="srch_status" name="srch_status">
                                        <option value="">====SELECT====</option>
                                        <option value="1" @if(@$_POST['srch_status']== "1") selected="selected" @endif>Active</option>
                                        <option value="0" @if(@$_POST['srch_status']== "0") selected="selected" @endif>InActive</option>
                                    </select>
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
                                      <li><a href="javascript:fun_active_inactive(1);"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a></li>
                                      <li><a href="javascript:fun_active_inactive(0);" ><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a></li>
                                      <li><a href="javascript:fun_multipleDelete();" ><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                  </ul>
                                </div>
                             </th>
                             <th>Actions</th>
                             <th>FAQ Title
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('question','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div> 
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('question','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                             <th>Display Order
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('displayOrder','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('displayOrder','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Created Date
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('created_at','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('created_at','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>Status
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('isActive','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                             </th>
                             <th>View</th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount)) <?php $no_row=1;?>
                                @foreach($qGetAllFaq as $GetAllFaq)
                                    <tr  id="ID_{{ $GetAllFaq->faqID }}" @if($GetAllFaq->faqID==$faqID) class="bg-warning" @endif>
                                        <td>
                                            <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllFaq->faqID }}" type="checkbox" />
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetAllFaq->faqID }} );" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetAllFaq->faqID }} );"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllFaq->question }}</td>
                                        <td>{{ $GetAllFaq->displayOrder }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllFaq->created_at)) }}</td>
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetAllFaq->faqID }});">
                                                <span id="status_{{ $GetAllFaq->faqID }}">
                                                    @if($GetAllFaq->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllFaq->faqID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.faq.faq-view')
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
                         <?php /*?>{!! $qGetAllFaq->render() !!}<?php */?>
                          @include('adminarea.pagination', ['paginator' => $qGetAllFaq])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
          </div>
    </section>
</form>
@endsection