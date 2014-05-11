@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
: Account Login
@stop

{{-- Content --}}
@section('content')
	
	{{ Form::open(['class' => 'form-signin', 'autocomplete' => 'off']) }}
		<div style="padding:15px;background-color:#fff;border-radius:6px;">
			<h2 class="form-signin-heading text-center">Iniciar sesión</h2>
			
			<div class="{{{ $errors->has('email') ? 'error' : '' }}}">
				<input type="email" id="email" name="email" placeholder="Correo electrónico.." required="true" autofocus="true" class="form-control" value="{{{ Input::old('email') }}}" />
				{{{ $errors->first('email') }}}
			</div>
			
			<div class=" {{{ $errors->has('password') ? 'error' : '' }}}">
				<input type="password" id="password" name="password" placeholder="Contraseña.." required="true" class="form-control" value="" />
				{{{ $errors->first('password') }}}
			</div>
			
			<label class="checkbox">
				<input type="checkbox" value="remember-me" checked> Recordar mis datos
			</label>
			
			<button type="submit" class="btn btn-lg btn-primary btn-block">Iniciar sesión</button>
			
			<br/>
			
			<center>
				<p><a href="{{{ URL::to('password/remind') }}}">¿Has olvidado tu contraseña?</a></p>
			</center>
		</div>
	{{ Form::close() }}
@stop