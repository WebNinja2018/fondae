@extends('adminarea.home')
@section('content')
@include('adminarea.adminmenu.adminmenu-js')
<style>
	.fa{margin-right:5px;}
	.form-group .list-group-item{ border: 0 none;float: left;margin: 2px 0 0 8px; padding: 0;}
</style>
<script type="application/javascript">

  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<?php 
use App\Http\Models\Adminmenu;
use App\Http\Models\Menurole;
$menuID=Input::get('menuID')?Input::get('menuID'):'0';
if($menuID==0){
$menuID=Session::get('menuID')?Session::get('menuID'):'0';
}
$menuName=old('menuName')?old('menuName'):'';
$menuParentID=old('menuParentID')?old('menuParentID'):'';
$menuLink=old('menuLink')?old('menuLink'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):1;
$classname=old('classname')?old('classname'):'';

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}
if($menuID != NULL && $menuID >0)
{
	if(isset($data['getsingleadminmenu']))
	{
		    $menuName=$data['getsingleadminmenu']->menuName;
			$menuParentID=$data['getsingleadminmenu']->menuParentID;
			$menuLink=$data['getsingleadminmenu']->menuLink;
			$displayOrder=$data['getsingleadminmenu']->displayOrder;
			$isActive=$data['getsingleadminmenu']->isActive;
			$classname=$data['getsingleadminmenu']->classname;
	}
}?>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/') }}/adminarea/adminmenu">Adminmenu Management</a></li>
        <li class="active">@if($menuID != NULL && $menuID >0) Edit @else Add @endif Adminmenu </a></li>
    </ol>
    @include('adminarea.include.message')
    <form name="frm_adminmenu_addedit" id="frm_adminmenu_addedit"  action="{{ url('/') }}/adminarea/adminmenu/saveadminmenu" method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" class="form-control" name="menuID" id="menuID" value="{{ $menuID }}">
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
        <!--start add user -->
        <section class="content-header top_header_content">
        	<div class="box">
                <div class="property_add">
                    <!-- strat box header-->
                    <div class="box-title with-border">
                        <h2>@if($menuID != NULL && $menuID >0) Edit @else Add @endif Adminmenu</h2>
                    </div>
                  <!-- end box -header -->
                    <!-- strat box-body area-->
                        <!-- start general & seo tab-->
                         <div class="tab-content">
                             <div class="active tab-pane">
                                <div class="addunit_forms">
                                    <div class="box-body">
                                       <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Parent Menu</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <select name="menuParentID" id="menuParentID" class="form-control">
                                                    <option value="">= = = Select = = =</option>
                                                    @foreach($data['qGetAllParent'] as $GetAllParent)
                                                        <option value="{{ $GetAllParent->menuID }}" @if($GetAllParent->menuID==$menuParentID) selected="selected" @endif >{{ $GetAllParent->menuName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Adminmenu Name <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="menuName" id="menuName" value="{{ $menuName }}" maxlength="50" placeholder="Adminmenu Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Menu Link <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="menuLink" id="menuLink" maxlength="100" placeholder="Menu Link" value="{{ $menuLink }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Display Order <span class="mandatory_field">*</span></label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="text" class="form-control" name="displayOrder" id="displayOrder" maxlength="4" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left active_or_not">Is Active?</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <input type="checkbox" value="1" <?php if($isActive==1){ echo "checked='checked'";} ?> name="isActive">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left active_or_not">Assign to role</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                @foreach($data['qGetAllRole'] as $GetAllRole)
													<?php $menurole= new Menurole; 
                                                         $resCheckMenuRole = $menurole->getCheckMenuRole($menuID,$GetAllRole->roleID); ?>
                                                    <input type="checkbox" value="{{ $GetAllRole->roleID }}" name="roleID[]" @if( $resCheckMenuRole['rows']>0 ) checked="checked" @endif />&nbsp; {{ $GetAllRole->name }} &nbsp;&nbsp;
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Class</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-chevron-right" <?php if($classname=='fa fa-chevron-right' || strlen($classname)==0){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-chevron-right"></i>&nbsp;sub menu-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-file-text-o" <?php if($classname=='fa fa-file-text-o'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-file-text-o"></i>&nbsp;file-text-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-newspaper-o" <?php if($classname=='fa fa-newspaper-o'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-newspaper-o"></i>&nbsp;newspaper-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-question" <?php if($classname=='fa fa-question'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-question"></i>&nbsp;question-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-link" <?php if($classname=='fa fa-link'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-link"></i>&nbsp;link-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-image" <?php if($classname=='fa fa-image'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-image"></i>&nbsp;sliders-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-group" <?php if($classname=='fa fa-group'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-group"></i>&nbsp;staff-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-comments-o" <?php if($classname=='fa fa-comments-o'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-comments-o"></i>&nbsp;testimonials-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-cogs" <?php if($classname=='fa fa-cogs'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-cogs"></i>&nbsp;management-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-user" <?php if($classname=='fa fa-user'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-user"></i>&nbsp;user-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-lock" <?php if($classname=='fa fa-lock'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-lock"></i>&nbsp;role-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-line-chart" <?php if($classname=='fa fa-line-chart'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-line-chart"></i>&nbsp;report-o</a>
                                                </div>
                                                <div style="clear:both;">
                                                    <input type="radio" name="classname" style="float:left;" value="fa fa-phone" <?php if($classname=='fa fa-phone'){?>checked="checked"<?php }?> /><a class="list-group-item"><i class="fa fa-phone"></i>&nbsp;contact-o</a>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                             </div>
                        </div>
                        <!-- end general & seo tab-->
                    <!-- end box-body area-->
                 </div>
                <!-- strat box footer area-->
                <div class="box-footer">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                         <div class="col-xs-12 col-md-12 col-sm-12">
                            <!--<button class="btn btn-warning waves-effect waves-light">Submit</button>-->
                            <input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Submit">
                            <button type="button" class="btn btn-primary waves-effect waves-light m-l-5"  onclick="fun_back()">Back</button>
                         </div>
                    </div>
                  </div>
                <!-- end box-footer area-->
            </div>
       </section>
       <!-- end add pages--> 
    </form>
@endsection