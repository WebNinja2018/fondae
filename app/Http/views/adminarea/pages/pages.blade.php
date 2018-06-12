@extends('adminarea.home')
@section('content')
@include('adminarea.pages.pages-js')

<script type="text/javascript" src="{{ url('/components/js/jquery.tablednd.js') }}"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function()
	{
		$("#table-1").tableDnD();
	})		
</script>


<style>
	.dtree *{color:#666 !important;}
</style>
<?php  use App\Http\Models\Pages;
	$pageID=Input::get('pageID')?Input::get('pageID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$srch_name=Input::get('srch_name')?Input::get('srch_name'):'';
	$startDate=Input::get('startDate')? date('m/d/Y',strtotime(Input::get('startDate'))):'';
	$endDate=Input::get('endDate')? date('m/d/Y',strtotime(Input::get('endDate'))):'';
	$srch_status=Input::get('srch_status')?Input::get('srch_status'):'';
	$srch_pageID=Input::get('srch_pageID')?Input::get('srch_pageID'):'';

$tmp = "";

function fun_getparent($id)
{
	global $tmp;

	//$q_select_row = Pages::find($id);
	$parentIDListDate = array('pageID'=>$id);
	$q_get_result = Pages::where($parentIDListDate)->get();
	//$q_get_result = $q_select_row->release;

	if(count($q_get_result) > 0)
	{
		$tmp = $q_get_result.",".$tmp;
		fun_getparent($q_get_result[0]->parentID);
	}
	else
	{
		$_SESSION['str2']=$tmp;
	}
}

fun_getparent($srch_pageID);

$str_str = strrev(substr(strrev($_SESSION['str2']),1));
$str_array = explode(",",$str_str);
array_push($str_array,$srch_pageID);

function funmainPages($parentID,$srch_pageID,$obj,$str_array)
{
	$parentIDListDate = array('parentID'=>$parentID);
	$result = Pages::where($parentIDListDate)->orderBy('displayOrder', 'ASC')->get();
	//print_r($result);exit;
    $MainPagesrecord=count($result);
	$qGetAllMainPages=$result;
	
	foreach($qGetAllMainPages as $GetAllMainPages){
			$obj=0;
			if($GetAllMainPages->parentID>0)
			  {
				 $obj++;
			  }
	?>
    		@if($obj>0)
    		<div style="padding-left:20px;">
            @endif
		   <?php 
              $pageIDListDate = array('parentID'=>$GetAllMainPages->pageID);
			  $subresult = Pages::where($pageIDListDate)->orderBy('displayOrder', 'ASC')->get();
			  $data['subPagesrecord']=count($subresult);
			  $isedit = 0;
              if( $data['subPagesrecord']==0 )
              {
                $isedit = 1;
                $var_img = 'page.gif';$var_img_icon = 'minus.gif';
              }
              elseif( $GetAllMainPages->pageID == $srch_pageID || strlen(array_search($GetAllMainPages->pageID,$str_array))>0 )
              {
                $var_img = 'folderopen.gif';$var_img_icon = 'minus.gif';
              }
              else
              {
                $var_img = 'folder.gif';$var_img_icon = 'plus.gif';
              }
           ?>
          @if($isedit==1)
              <a href="javascript:fun_edit({{ $GetAllMainPages->pageID }})"><img src="{{ url('/') }}/components/images/{{ $var_img_icon }}"/></a>
              <img src="{{ url('/') }}/components/images/{{ $var_img }}" alt="" title=""/>
              <a href="javascript:fun_edit({{ $GetAllMainPages->pageID }})">{{ $GetAllMainPages->pageName }}</a><br />
          @else
              <a href="javascript:fun_selectsection({{ $GetAllMainPages->pageID }})"><img src="{{ url('/') }}/components/images/{{ $var_img_icon }}"/></a>
              <img src="{{ url('/') }}/components/images/{{ $var_img }}" alt="" title=""/>
              <a href="javascript:fun_selectsection({{ $GetAllMainPages->pageID }})">{{ $GetAllMainPages->pageName }}</a><br />
          @endif
          
          <?php 
		  	  if( $GetAllMainPages->pageID == $srch_pageID || strlen(array_search($GetAllMainPages->pageID,$str_array))>0 )
			  {
				  funmainPages($GetAllMainPages->pageID,$srch_pageID,$obj,$str_array);
			  }
		  ?>
          @if($obj>0)
          </div>
          @endif
    <?php }
}
?>

<form role="form" name="frm_Pages_list" method="post" action="{{ url('/') }}/adminarea/pages/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" name="formname" id="formname" value="frm_pages_list"  />
<input type="hidden" name="formname" id="formname" value="frm_pages_list"  />
<input type="hidden" value="" name="pageID" id="pageID" />
<input type="hidden" name="fieldname" value="{{ Input::get('fieldname') }}" />
<input type="hidden" name="order" value="{{ Input::get('order') }}" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="srch_pageID" id="srch_pageID" value="{{ $srch_pageID }}" />
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages Management</li>
    </ol>
    <section class="content-header top_header_content">
        <div class="addproperty_button">
            <div class="col-sm-12 col-md-12 col-xs-12">
               <div class="row">
                    <div class="">
                        <a href="javascript:fun_edit(0);" class="add_edit_btn"><i class="fa fa-plus"></i>&nbsp; Add New Pages</a>
                        <a class="add_edit_btn" href="#" id="advance_search" onclick="funToggleSearch('Pages');"><i class="fa fa-search"></i>&nbsp; Search</a>
                    </div>
               </div>
            </div>
        </div>
    </section>
	<section class="content-header top_header_content" id="searchSectionPages" @if(Session::get('searchSectionPages')!= 1) style=" display:none;" @endif> 
         <div class="box search_area">
                <div class="box-title with-border">
                    <h2>Search Area</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                            <ul class="pagination pagination-sm search_by_alphabetic">
                              <li><a href="javascript:fun_pagesSearch('')">All</a></li>
                              @for($i=65;$i<=90;$i++)
                                  <li><a href="javascript:fun_pagesSearch('{{ chr($i) }}')">{{ chr($i) }}</a></li>
                              @endfor
                            </ul>
                            <div class="form-group">
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <input type="text" name="srch_name" class="form-control" id="srch_name" value="{{ $srch_name }}" placeholder="Pages Title">
                                 </div>
                                 <div class="col-sm-2 col-md-2 col-xs-2">
                                    <select class="form-control" id="srch_status" name="srch_status">
                                        <option value="">====SELECT====</option>
                                        <option value="1" @if(@$_POST['srch_status']== "1") selected='selected' @endif>Active</option>
                                        <option value="0" @if(@$_POST['srch_status']== "0") selected='selected' @endif>InActive</option>
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
	<!--strat section Main content -->
	<section class="content-header top_header_content">
		<div class="col-xs-12 col-sm-12 col-md-12">
        	<div class="row">
                <!-- start pages management table-->
                <div class="table-responsive data_view_table">
                  <table class="table table-bordered pages_tablemain">
                      <tr>
                          <td valign="top" width="20%">
                          <div class="dtree" align="left" style="font-size:12px;">
                              <img src="{{ url('/') }}/components/images/base.gif"/><a href="javascript:fun_selectsection(0)">Parent</a>&nbsp;<br />
                              <img src="{{ url('/') }}/components/images/plus.gif"/><a href="javascript:fun_hideshow()">Parent</a>&nbsp;<br />
                              <?php funmainPages(0,$srch_pageID,0,$str_array); ?>
                          </div> 
                          </td>
                          <td valign="top" width="80%" class="pages_tablecont">
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
                                       <th>Pages Name 
                                              <div class="pull-left">
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                      <a href="javascript:;" onclick="fun_upDown('pageName','ASC');" class="asc_desc_icon" >
                                                          <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                      </a>
                                                  </div>
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                      <a href="javascript:;" onclick="fun_upDown('pageName','DESC');" class="asc_desc_icon">
                                                          <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" ></span>
                                                      </a>
                                                  </div>
                                              </div>
                                        </th>
                                        <th>Created Date 
                                              <div class="pull-left">
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                      <a href="javascript:;" onclick="fun_upDown('pagesDate','ASC');" class="asc_desc_icon" >
                                                          <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                                                      </a>
                                                  </div>
                                                  <div class="col-md-12 col-xs-12 col-sm-12">
                                                      <a href="javascript:;" onclick="fun_upDown('pagesDate','DESC');" class="asc_desc_icon">
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
                                          @foreach($qGetAllPages as $GetAllPages)
                                              <tr id="ID_{{ $GetAllPages->pageID }}" @if($GetAllPages->pageID==$pageID) class="bg-warning" @endif>
                                                  <td>
                                                      <input class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="{{ $GetAllPages->pageID }}" type="checkbox" />
                                                  </td>
                                                  <td>
                                                      <a href="javascript:fun_edit({{ $GetAllPages->pageID }});" title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                      <a href="javascript:fun_single_delete({{ $GetAllPages->pageID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                  </td>
                                                  <td>{{ $GetAllPages->pageName }}</td>
                                                  <td>{{ date('m/d/Y',strtotime($GetAllPages->created_at)) }}</td>
                                                  <td>
                                                      <a href="javascript:fun_single_status({{ $GetAllPages->pageID }});">
                                                          <span id="status_{{ $GetAllPages->pageID }}">
                                                              @if($GetAllPages->isActive==1) Active @else Inactive @endif
                                                          </span>
                                                      </a>
                                                  </td>
                                                  <td><a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllPages->pageID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                      @include('adminarea.pages.pages-view')
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
                          </td>
                      </tr>
                    </table>
                </div>
                <!-- end pages management table-->
                <div class="pagination_box" id="paggination">
                    <nav aria-label="Page navigation">
						<?php /*?>{!! $qGetAllPages->render() !!}<?php */?>
                        @include('adminarea.pagination', ['paginator' => $qGetAllPages])
                    </nav>
                </div>
              <!-- strat box area-->
             </div>
		  </div>
	</section>
</form> 
@endsection