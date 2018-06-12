@extends('adminarea.home')
@section('content')
@include('adminarea.adminmenu.adminmenu-js')
<?php
    use App\Http\Models\Adminmenu;
	$menuID=Input::get('menuID')?Input::get('menuID'):'';
	$totalrow=Input::get('totalrow')?Input::get('totalrow'):'';
	$currentrow=Input::get('currentrow')?Input::get('currentrow'):'';
	$menuName=Input::get('menuName')?Input::get('menuName'):'';
	$srch_menuParentID=Input::get('srch_menuParentID')?Input::get('srch_menuParentID'):'';
	$srch_status=Input::get('srch_status')? Input::get('srch_status'):'';
?>

<form class="form-inline" role="form" name="frm_adminmenu_list" method="post" action="{{ url('/') }}/adminarea/adminmenu/index">
<input type="hidden" name="status" value=""  />
<input type="hidden" value="" name="menuID" />
<input type="hidden" name="method" value="" />
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="right_side" role="main">
    <div class="center_container">
        <ul class="breadcrumb">
          <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
          <li class="active">Adminmenu Management</li>
        </ul>
    </div>
    <div class="panel row">
      <div class="panel-body">
        <div class="col-md-13" role="main">
        	@include('adminarea.include.message')
            <div class="main_row">
                <div class="btn-group">
                  <a href="javascript:fun_edit(0);" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Add New Adminmenu</a>
                  <a href="javascript:fun_active_inactive(1);" class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Active</a>
                  <a href="javascript:fun_active_inactive(0);" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;Inactive</a>
                  <a href="javascript:fun_multipleDelete();" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Delete</a>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered">
				<tr>
                	<th width="1%">
                        <input name="checkall" id= "checkall" value="" type="checkbox" />
                    </th>
                    <th width="2%">Actions</th>
                    <th width="30%">Menu Name</th>
                    <th width="15%">Link</th>
                    <th width="15%">Display Order</th>
                    <th width="10%">Status</th>
                  </tr>
                  
                  <?php $adminmenu= new Adminmenu;
						if(isset($data['recordcount'])){ $no_row=1;?>
                     <?php foreach($data['qGetAllAdminmenu'] as $GetAllAdminmenu){ 
					 			$subTopMenu=$adminmenu->getAllParent($GetAllAdminmenu->menuID,'',session()->get('admin_role'));
								?>
                                   
                     <tr id="ID_<?php echo $GetAllAdminmenu->menuID; ?>" <?php if($GetAllAdminmenu->menuID==$menuID) { ?> class="bg-warning" <?php } ?>>
                      	<td  valign="top">
                        	<input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="<?php echo $GetAllAdminmenu->menuID; ?>" type="checkbox" />
                        </td>
                        <td>
                            <a class="glyphicon glyphicon-pencil" href="javascript:fun_edit(<?php echo $GetAllAdminmenu->menuID; ?>);" title="Edit"></a>&nbsp;&nbsp;
                            <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete(<?php echo $GetAllAdminmenu->menuID; ?>);" title="Delete"></a>
                        </td>
                        <td><?php echo $GetAllAdminmenu->menuName; ?></td>
                        <td><?php echo $GetAllAdminmenu->menuLink; ?></td>
                        <td><?php echo $GetAllAdminmenu->displayOrder; ?></td>
                        <td>
                        	<a href="javascript:fun_single_status(<?php echo $GetAllAdminmenu->menuID; ?>);">
								<span id="status_<?php echo $GetAllAdminmenu->menuID; ?>">
									<?php if($GetAllAdminmenu->isActive==1){ echo"Active"; }else{ echo"Inactive";} ?>
                                </span>
                        	</a>
                        </td>
                      </tr>
                      
                      <?php if( $subTopMenu['rows']>0 ){?>
                      	    
                            <?php foreach($subTopMenu['data'] as $GetSubAdminmenu){ ?>

                     	 		<tr id="ID_<?php echo $GetSubAdminmenu->menuID; ?>">
                                    <td  valign="top">
                                        <input  class="checkbox" name="checkUncheck[]"  id="checkAllAuto" value="<?php echo $GetSubAdminmenu->menuID; ?>" type="checkbox" />
                                    </td>
                                    <td>
                                        <a class="glyphicon glyphicon-pencil" href="javascript:fun_edit(<?php echo $GetSubAdminmenu->menuID; ?>);" title="Edit"></a>&nbsp;&nbsp;
                                        <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete(<?php echo $GetSubAdminmenu->menuID; ?>);" title="Delete"></a>
                                    </td>
                                    <td> <i class="glyphicon glyphicon-chevron-right"></i> <?php echo $GetSubAdminmenu->menuName; ?></td>
                                    <td><?php echo $GetSubAdminmenu->menuLink; ?></td>
                                  	<td><?php echo $GetSubAdminmenu->displayOrder; ?></td>
                                    <td>
                                        <a href="javascript:fun_single_status(<?php echo $GetSubAdminmenu->menuID; ?>);">
                                            <span id="status_<?php echo $GetSubAdminmenu->menuID; ?>">
                                                <?php if($GetSubAdminmenu->isActive==1){ echo"Active"; }else{ echo"Inactive";} ?>
                                            </span>
                                        </a>
                                    </td>
                                  </tr>
                      		<?php }?>
                      <?php }?>
                    <?php $no_row++; } ?>
                  <?php }else{ ?>
                   <tr>
                    <td colspan="7" style="text-align:center;">Recoed Not Found</td>
                  </tr>
                  <?php }?>
              </table>
            </div>
         </div>
        <div class="main_row">
            <ul class="pagination pagenevigation">
            	 <?php /*?>{!! $data['qGetAllRole']->render() !!}<?php */?> 
                <?php /*?>@include('adminarea.adminarea.pagination', ['paginator' => $data['qGetAllAdminmenu']])<?php */?>
            </ul>
        </div>
      </div>
    </div>
</div>
</form>
@endsection