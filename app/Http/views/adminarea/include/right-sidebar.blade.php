 <!-- Create the tabs -->
	<ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
	<!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab"></div>
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab"></div>
      <!-- /.tab-pane -->
    </div>
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <?php if(Request::segment(1)=='home'){?>
		<script>
        	$.widget.bridge('uibutton', $.ui.button);
        </script>
	<?php }?>
	<script src="{{ url('/') }}/components/js/demo.js" type="text/javascript"></script>