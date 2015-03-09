
@if (count($errors) > 0)
<div class="alert alert-error alert-block">
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success">
	<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
	<strong>Success:</strong>
	{{{ $message }}}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger">
	<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
	<strong>Error:</strong>
	{{{ $message }}}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning">
	<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
	<strong>Warning:</strong>
	{{{ $message }}}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info">
	<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
	<strong>Inform:</strong>
	{{{ $message }}}
</div>
@endif
