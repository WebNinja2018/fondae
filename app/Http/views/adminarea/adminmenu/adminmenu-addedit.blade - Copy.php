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
$menuName=old('menuName')?old('menuName'):'';
$menuParentID=old('menuParentID')?old('menuParentID'):'';
$menuLink=old('menuLink')?old('menuLink'):'';
$displayOrder=old('displayOrder')?old('displayOrder'):'';
$isActive=old('isActive')?old('isActive'):'';
$classname=old('classname')?old('classname'):'';
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

    <div class="right_side" role="main">
		<div class="center_container">
			<ul class="breadcrumb">
			  <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
			  <li><a href="{{ url('/') }}/adminarea/adminmenu">Adminmenu Management</a></li>
			  <li class="active">@if($menuID != NULL && $menuID >0) Edit @else Add @endif Adminmenu </a></li>
			</ul>
		</div>
        
        <div class="panel row">
            <div class="panel-body">
                <div class="col-md-13" role="main">
                    <div class="panel panel-default">
                       @include('adminarea.include.message')
                        <div class="panel-heading">
                            <h3 class="panel-title">@if($menuID != NULL && $menuID >0) Edit @else Add @endif Adminmenu </a></h3>
                        </div>
                        <div class="col-md-12" role="main">
                            <div class="col-md-12" role="main">&nbsp;</div>
                            <div class="row">
                                <form name="frm_adminmenu_addedit" id="frm_adminmenu_addedit"  action="{{ url('/') }}/adminarea/adminmenu/saveadminmenu" method="post" class="form-horizontal" enctype="multipart/form-data" >
                                <input type="hidden" class="form-control" name="menuID" id="menuID" value="{{ $menuID }}">
                                {!! Form::hidden('redirects_to', URL::previous()) !!}
                                    <ul class="nav nav-tabs" role="tablist">
                                    	<li class="active"><a href="##salable_tab" role="tab" data-toggle="tab">General Tab</a></li>
                                    </ul>
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="salable_tab">
                                            <!--================================Adminmenu Form Start=====================================-->
                                              <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">&nbsp;</label>
                                                <div class="col-md-4">
                                                    &nbsp;
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Parent Menu</label>
                                                <div class="col-md-4">
                                                    <select name="menuParentID" id="menuParentID" class="form-control">
                                                        <option value="">= = = Select = = =</option>
                                                        @foreach($data['qGetAllParent'] as $GetAllParent)
                                                            <option value="{{ $GetAllParent->menuID }}" @if($GetAllParent->menuID==$menuParentID) selected="selected @endif >{{ $GetAllParent->menuName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="menuName" class="col-sm-2 control-label">Adminmenu Name <span class="mandatory_field">*</span></label>
                                                <div class="col-md-4">
                                                  <input type="text" class="form-control" name="menuName" id="menuName" value="{{ $menuName }}" maxlength="50" placeholder="Adminmenu Name">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="menuLink" class="col-sm-2 control-label">Menu Link *</label>
                                                <div class="col-md-4">
                                                  <input type="text" class="form-control" name="menuLink" id="menuLink" maxlength="100" placeholder="Menu Link" value="{{ $menuLink }}">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="displayOrder" class="col-sm-2 control-label">Display Order *</label>
                                                <div class="col-md-4">
                                                  <input type="text" class="form-control" name="displayOrder" id="displayOrder" maxlength="4" placeholder="Display Order" value="{{ $displayOrder }}" onkeypress="return isNumberKey(event)">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label for="displayOrder" class="col-sm-2 control-label">Is Active?</label>
                                                <div class="col-md-4">
                                                    <input type="checkbox" value="1" <?php if($isActive==1){ echo "checked='checked'";} ?> name="isActive"> 
                                                </div>
                                                </div>
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Assign to role</label>
                                                <div class="col-md-4">
                                                	@foreach($data['qGetAllRole'] as $GetAllRole)
                                                        <?php $menurole= new Menurole; 
															 $resCheckMenuRole = $menurole->getCheckMenuRole($menuID,$GetAllRole->roleID); ?>
                                                        <input type="checkbox" value="{{ $GetAllRole->roleID }}" name="roleID[]" @if( $resCheckMenuRole['rows']>0 ) checked="checked" @endif />&nbsp; {{ $GetAllRole->name }} <br /><br />
                                                    @endforeach
                                                </div>
                                              </div>
                                              
                                              <div class="form-group">
                                                <label for="categoryname" class="col-sm-2 control-label">Class</label>
                                                <div class="col-md-4">
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
                                            <!--================================Adminmenu Form Start=====================================-->
                                        </div>
                                    </div>
                                    <!---general information[end]--->
                                    <div class="form-group">
                                       <div class="col-sm-offset-2 col-sm-10">
                                         <button type="submit" class="btn btn-default btn-primary">Submit</button>
                                         <button class="btn btn-default" type="button" onclick="fun_back()">Back</button>
                                       </div>
                                     </div>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection