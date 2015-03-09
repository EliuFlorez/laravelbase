@extends('layouts.default')

@section('title')
@parent
: Remind
@stop

@section('content')
	{{ Form::open(['class' => 'form-signin', 'autocomplete' => 'off']) }}
		<div style="padding:15px;background-color:#fff;border-radius:6px;">
			<h2 class="form-signin-heading text-center">Resetiar contraseña</h2>
			@if (Session::has('error'))
				<p style="color:red;">{{ Session::get('error') }}</p>
			@elseif (Session::has('status'))
				<p style="color:green;">{{ Session::get('status') }}</p>
			@endif
			<div class="{{{ $errors->has('email') ? 'error' : '' }}}">
				<input type="email" id="email" name="email" placeholder="Correo Electrónico.." required="true" autofocus="true" class="form-control" value="{{{ Input::old('email') }}}" />
				{{{ $errors->first('email') }}}
			</div>
			<br/>
			<button type="submit" class="btn btn-lg btn-primary btn-block">Enviar</button>
			<br/>
			<center>
				<p><a href="{{{ URL::to('account/login') }}}">Iniciar sesión</a></p>
			</center>
		</div>
	{{ Form::close() }}
@stop