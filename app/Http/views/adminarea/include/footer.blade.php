<strong>{{Config::get('config.copyright','© Copyright 2017 by Fondae. All rights reserved.')}}</strong>
<script type="text/javascript">
 $(document).ready(function(){
   $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
       localStorage.setItem('activeTab', $(e.target).attr('href'));
   });
   var activeTab = localStorage.getItem('activeTab');
   //alert(activeTab);
   if(activeTab){
       $('a[href="' + activeTab + '"]').tab('show');
   }
});
</script>