@extends('layouts.default')

@section('title')
@parent
: Add
@stop

@section('content')
	{{ Form::open(['url' => 'accounts', 'route' => 'accounts.store', 'class' => 'form-style', 'autocomplete' => 'off']) }}
		<div style="padding:15px;background-color:#fff;border-radius:6px;">
			<fieldset>
				<h2 class="form-signin-heading text-center">Add Account</h2>
				<div class="form-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
					<label for="first_name">Frist Name <span style="color:red;">(*)</span></label>
					<input type="text" id="first_name" name="first_name" required="true" class="form-control" value="{{{ Input::old('first_name') }}}" />
					{{{ $errors->first('first_name') }}}
				</div>
				<div class="form-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
					<label for="last_name">Last Name <span style="color:red;">(*)</span></label>
					<input type="text" id="last_name" name="last_name" required="true" class="form-control" value="{{{ Input::old('last_name') }}}" />
					{{{ $errors->first('first_name') }}}
				</div>
				<div class="form-group {{{ $errors->has('phone') ? 'error' : '' }}}">
					<label for="phone">Phone</label>
					<input type="text" id="phone" name="phone" class="form-control" value="{{{ Input::old('phone') }}}" />
					{{{ $errors->first('number') }}}
				</div>
				<div class="form-group {{{ $errors->has('birth') ? 'error' : '' }}}">
					<label for="birth">Birth <span style="color:red;">(*)</span></label>
					@if(Input::old('birth'))
						<input type="text" id="datepicker1" data-date-format="yyyy-mm-dd" name="birth" required="true" class="datepicker form-control" value="{{{ Input::old('birth') }}}" />
					@else
						<input type="text" id="datepicker1" data-date-format="yyyy-mm-dd" name="birth" required="true" class="datepicker form-control" value="{{ date('Y-m-d') }}" />
					@endif
					{{{ $errors->first('birth') }}}
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Agregar</button>
			</fieldset>
		</div>
	{{ Form::close() }}
@stop