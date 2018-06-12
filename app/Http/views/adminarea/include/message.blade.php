<?php /*?><?php print_r($errors); ?><?php */?>
@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @foreach ($errors as $error)
        	<p>{{$error}}</p>
        @endforeach
    </div>
@endif
<?php /*?>@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @foreach ($errors->all() as $error)
        	<p>{{$error}}</p>
        @endforeach
		
    </div>
@endif<?php */?>
@if(Session::has('flash_message'))
<p class="alert alert-info">{{ Session::get('flash_message') }}</p>
@endif

