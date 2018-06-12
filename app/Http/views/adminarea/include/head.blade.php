<?php /*?>@if(!(session()->get('pms_user'))) redirect('login') @endif<?php */?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <link rel="shortcut icon" href="{{ url('/components/images/favicon.png') }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ url('/components/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/components/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ url('/components/css/ionicons.css') }}">
  <link rel="stylesheet" href="{{ url('/components/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ url('/components/css/skins/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ url('/components/plugins/iCheck/flat/orange.css') }}">
  <link href="{{ url('/components/css/simply-tag.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ url('/components/css/style.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ url('/components/css/responsive.css') }}" >
  <link rel="stylesheet" href="{{ url('/components/css/jquery.dataTables.min.css') }}" >
  <link rel="stylesheet" href="{{ url('/components/plugins/select2/select2.min.css') }}" >
  <link rel="stylesheet" href="{{ url('/components/css/bootstrapValidator.css') }}" >
  <?php /*?><link rel="stylesheet" href="{{ url('/') }}/adminarea/css/browse.css"><?php */?>
  <link href="{{url('/components/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('/components/css/bootstrapValidator.css') }}"/>

  <!--- redactor ----->
	<script src="{{url('/components/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
	
	<script src="{{url('/components/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{url('/components/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
	<script src="{{url('/components/js/app.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript" src="{{ url('/components/js/bootstrapValidator.js') }}"></script>
     <!-- AdminLTE for demo purposes -->

<?php /* ======================   Custom JS and Css which are use from our side[START]   ========================== */ ?>
    <script src="{{ url('/') }}/components/js/general.js" type="text/javascript"></script>
	<script src="{{ url('/') }}/components/plugins/select2/select2.full.min.js"></script>
        <script type="text/javascript">
          $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
          });
        </script>
    
    
	<?php /* For Validation [START] */ if(Request::segment(1)=='lease'){?>
			<script type="text/javascript" src="{{ url('/') }}/components/js/formValidation.js"></script>
            <script type="text/javascript" src="{{ url('/') }}/components/js/framework/bootstrap.js"></script>
	<?php }else{?>
			<script src="{{ url('/') }}/components/js/jquery.metadata.js" type="text/javascript"></script>
            <script src="{{ url('/') }}/components/js/jquery.validate.js" type="text/javascript"></script>
            <script src="{{ url('/') }}/components/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<?php }/* For Validation [END] */ ?>
    
    <?php /* For Thickbox [START] */ ?>
        <link rel="stylesheet" href="{{ url('/') }}/components/css/thickbox.css">
		<script src="{{ url('/') }}/components/js/jquery-migrate-1.1.1.min.js"></script>
        <script src="{{ url('/') }}/components/js/thickbox.js"></script>
    <?php /* For Validation [END] */ ?>	
    
    <?php /* For Confirmbox [START] */ ?>
        <link rel="stylesheet" href="{{ url('/') }}/components/css/jquery-confirm.css">
    	<script src="{{ url('/') }}/components/js/jquery-confirm.js" type="text/javascript"></script>
    <?php /* For Confirmbox [END] */ ?>
	
	<?php /* For Thickbox [END] */ ?>
    
	<?php /* For Cluletip[START] */ ?>
		<?php /*?><link rel="stylesheet" href="{{ url('/') }}/components/css/jquery.cluetip.css">
		<script src="{{ url('/') }}/components/js/jquery.hoverIntent.js" type="text/javascript"></script>
		<script src="{{ url('/') }}/components/js/jquery.cluetip.js" type="text/javascript"></script><?php */?>
	<?php /* For Cluletip[END] */ ?>
    
    <?php /* For Redactor[START] */ ?>
    <link rel="stylesheet" href="{{ url('/') }}/components/redactor/redactor.css" />
	<script src="{{ url('/') }}/components/redactor/redactor.min.js"></script>
    <?php /* For Redactor[END] */ ?>   
    
	<script type="text/javascript">
	/* Advance Search area show[START] */	
		function funToggleSearch(obj)
			{
				$("#searchSection"+obj).slideToggle();
				$.ajax({
						   type: "POST",
						   url: "{{ url('/') }}/adminarea/home/setsearch",
						   data: "obj="+obj,
						   success: function(result){
					   }
				 });
			}
	/* Advance Search area show[END] */
		$( document ).ready(function() {
		$( "#srch_keyword" ).keyup(function() {
			var srch_keyword = $("#srch_keyword").val();
				$.ajax({
						   type: "POST",
						   url: "{{ url('/') }}/adminarea/ajax/search_keyword",
						   data: "srch_keyword="+srch_keyword+"&filename={{Request::segment(1)}}",
						   success: function(response){
								$("#searchResult").html(response);
								$("#paggination").hide();
					   }
			 	});
			});
		});
	</script>

	 <?php /* For File Upload  [START] */ ?>
		<link href="{{ url('/') }}/components/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
		<script src="{{ url('/') }}/components/js/fileinput.js" type="text/javascript"></script>
    <?php /* For File Upload [END] */ ?>	
  
<?php /* ======================   Custom JS and Css which are use from our side[END]   ========================== */ ?>


