@extends('adminarea.home')
@section('content')
@include('adminarea.news.news-js')

<?php
	$newsID=Input::get('newsID')?Input::get('newsID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$srach_newsTitle=Input::get('srach_newsTitle')?Input::get('srach_newsTitle'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
?>

<form role="form" name="frm_news_list" method="post" action="{{ url('/') }}/adminarea/news/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="newsID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="redirects_to" value="{{Request::fullUrl()}}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">News Management</li>
    </ol>
    <?php /*?><div class="col-sm-6 col-md-6 col-xs-6 pull-right text-right">
        <div class="advance_button">
            <a class="" href="#" id="advance_search" onclick="funToggleSearch('Property');"><i class="fa fa-search"></i>&nbsp; Search</a>
        </div>
    </div><?php */?>

    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New News</a>
						<a href="javascript:fun_changeOrder();" class="add_edit_btn"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Display Order</a>
                        <a class="add_edit_btn" href="#" id="advance_search" onclick="funToggleSearch('News');"><i class="fa fa-search"></i>&nbsp; Search</a>
                        <?php /*?><a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Active</a>
                        <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> &nbsp; Inactive </a>
                        <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a><?php */?>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content" id="searchSectionNews" @if(Session::get('searchSectionNews')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                              <li><a href="javascript:fun_newsSearch('')">All</a></li>
                              @for($i=65;$i<=90;$i++)
                                  <li><a href="javascript:fun_newsSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                              @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                      <input type="text" name="srach_newsTitle" class="form-control" id="srach_newsTitle" value="{{ $srach_newsTitle }}" placeholder="News">
                                 </div>
                                 <div class="col-md-2 col-xs-2 col-sm-2">
                                    <select class="form-control" id="srch_status" name="srch_status">
                                        <option value="">====SELECT====</option>
                                        <option value="1" @if(@$_POST['srch_status']== "1") selected='selected' @endif>Active</option>
                                        <option value="0" @if(@$_POST['srch_status']== "0") selected='selected' @endif>InActive</option>
                                    </select>
                                 </div>
                                 <div class="col-md-2 col-xs-2 col-sm-2">
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
                                 <div class="col-md-2 col-xs-2 col-sm-2">
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
                                 <div class="col-md-2 col-xs-2 col-sm-2">
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
	<!--strat section Main content -->
	<section class="content-header top_header_content">
		<div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="row">
                <!-- start news management table-->
                <div class="table-responsive data_view_table">
                  <table id="example" class="table-bordered table-striped table-hover table">
                        <thead>
                             <th ><input name="checkall" id="checkall" value="" type="checkbox">
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
                             <th>News Title 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsTitle','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsTitle','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                              <th>News Date 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsDate','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsDate','DESC');" class="asc_desc_icon">
                                                <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                            </a>
                                        </div>
                                    </div>
                              </th>
                              <?php /*?><th>Display Order
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
                              </th><?php */?>
                              <th>Created Date 
                                    <div class="pull-left">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsDate','ASC');" class="asc_desc_icon" >
                                                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <a href="javascript:;" onclick="fun_upDown('newsDate','DESC');" class="asc_desc_icon">
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
                                </div
                             ></th>
                             <th>View</th>
                        </thead>
                        <tbody>
                        @if (($recordcount)>0)
                            @if(isset($recordcount))<?php $no_row=1; ?>
                                @foreach($qGetAllNews as $GetAllNews)
                                    <tr id="ID_{{ $GetAllNews->newsID }}" @if($GetAllNews->newsID==$newsID) class="bg-warning" @endif>
                                        <td>
                                            <input class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllNews->newsID }}" type="checkbox" />
                                        </td>
                                        <td>
                                            <a href="javascript:fun_edit({{ $GetAllNews->newsID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="javascript:fun_single_delete({{ $GetAllNews->newsID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $GetAllNews->newsTitle }}</td>
                                        <td>{{ date('m/d/Y',strtotime($GetAllNews->newsDate)) }}</td>
                                        <?php /*?><td>{{ $GetAllNews->displayOrder }}</td><?php */?>
                                        <td>{{ date('m/d/Y',strtotime($GetAllNews->created_at)) }}</td>
                                        <td>
                                            <a href="javascript:fun_single_status({{ $GetAllNews->newsID }});">
                                                <span id="status_{{ $GetAllNews->newsID }}">
                                                    @if($GetAllNews->isActive==1) Active @else Inactive @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td><a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllNews->newsID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @include('adminarea.news.news-view')
                                        </td>
                                    </tr>
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
                <!-- end news management table-->
                <div class="pagination_box" id="paggination">
                <nav aria-label="Page navigation">
					<?php /*?>{!! $qGetAllNews->render() !!}<?php */?>
                    @include('adminarea.pagination', ['paginator' => $qGetAllNews])
                </nav>
            </div>
              <!-- strat box area-->
             </div>
		  </div>
	</section>
</form> 
@endsection