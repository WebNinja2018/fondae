@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @foreach ($errors->all() as $error)
        	<p>{{$error}}</p>
        @endforeach
		
    </div>
@endif
@if(Session::has('flash_message'))
<p class="alert alert-info">{{ Session::get('flash_message') }}</p>
@endif
@if(Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif

@if(Session::has('activation'))
    <p class="alert alert-info">{{ Session::get('activation') }}</p>
@endif








