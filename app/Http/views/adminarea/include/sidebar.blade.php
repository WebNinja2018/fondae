<?php $filename=(Request::segment(1))?(Request::segment(1)):''?>
<section class="sidebar">
  <!-- Sidebar user panel -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  
	<?php /*?><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					Collapsible Group Item #3
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				</div>
			</div>
		</div>
	</div><?php */?>
    <!-- leftside menu area-->
        <ul class="sidebar-menu">
        	<?php
				  use App\Http\Models\Adminmenu;
				  $adminmenu= new Adminmenu;
				  $TopMenu=$adminmenu->getAllParent(0,1,session()->get('admin_role'));
				  foreach( $TopMenu['data'] as $menu ){
				  $subMenu=$adminmenu->getAllParent($menu->menuID,1,session()->get('admin_role'));
			  ?>
				  <li class="treeview">
					  <a href="<?php if( $menu->menuLink=='javascript:;' ){?>javascript:;<?php }else{?> <?php echo url('/'); ?>/adminarea/<?php echo $menu->menuLink;?><?php }?>"><i class="<?php echo $menu->classname;?>"></i> <span><?php echo $menu->menuName;?></span> <?php if( $subMenu['rows']>0 ){?><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span><?php }?></a>
					  <?php if( $subMenu['rows']>0 ){?>
						  <ul class="treeview-menu">
							  <?php foreach( $subMenu['data'] as $submenu ){ ?>
							  <li><a href="<?php echo url('/'); ?>/adminarea/<?php echo $submenu->menuLink;?>"><i class="<?php echo $menu->classname;?>"></i><span><?php echo $submenu->menuName;?></span></a></li>
							  <?php }?>
						  </ul>
					  <?php }?>
				  </li>
			<?php }?>

			<?php 

			if(Session::get('admin_role')!=1)
			{ 

				if(!Session::get('stripeSK') || Session::get('stripeSK') == "" || !Session::get('stripePK') || Session::get('stripePK') == "")
					{ ?>
					<li class="btn  ">           
						<a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_8wHMRtjP9cD3h5BOXfKgiNJCWkBqf6V3&scope=read_write&response_type=code&approval_prompt=auto&stripe_landing=login" class="btn-green hvr-shutter-out-horizontal" style="margin: 10px;border-radius: 5px; color: white;"><span> <i class="fa fa-arrow-right" aria-hidden="true"></i> Add You'r Stripe A/C</span></a>
							  
					</li>

			 <?php }
			}	 
			 ?>
        </ul>
      <!-- end leftside menu area-->
</section>