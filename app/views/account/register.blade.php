@extends('layouts.default')

@section('title')
@parent
: Account Register
@stop

@section('content')
	{{ Form::open(['class' => 'form-signin', 'autocomplete' => 'off']) }}
		<div style="padding:15px;background-color:#fff;border-radius:6px;">
			<h2 class="form-signin-heading text-center">Registrate!</h2>
			
			<div class="{{{ $errors->has('name') ? 'error' : '' }}}">
				<input type="text" id="name" name="name" placeholder="Nombre.." required="true" autofocus="true" class="form-control" value="{{{ Input::old('name') }}}" />
				{{{ $errors->first('name') }}}
			</div>
			
			<div class="{{{ $errors->has('email') ? 'error' : '' }}}">
				<input type="email" id="email" name="email" placeholder="Correo Electrónico.." required="true" class="form-control inputs" value="{{{ Input::old('email') }}}" />
				{{{ $errors->first('email') }}}
			</div>
			
			<div class=" {{{ $errors->has('password') ? 'error' : '' }}}">
				<input type="password" id="password" name="password" placeholder="Contraseña.." required="true" class="form-control inputs" value="" />
				{{{ $errors->first('password') }}}
			</div>
			
			<div class=" {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
				<input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña.." required="true" class="form-control" value="" />
				{{{ $errors->first('password_confirmation') }}}
			</div>
			
			<button type="submit" class="btn btn-lg btn-primary btn-block">Registrate!</button>
			
			<br/>
			
			<center>
				<p><a href="{{{ URL::to('account/login') }}}">Ya tiene una cuenta? inicia sesión</a></p>
			</center>
		</div>
	{{ Form::close() }}
@stop