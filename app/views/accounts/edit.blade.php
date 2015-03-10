@extends('layouts.default')

@section('title')
@parent
: Actualizar
@stop

@section('content')
	{{ Form::open(['route' => array('accounts.update', $account->id), 'method' => 'PUT', 'class' => 'form-style', 'files' => true, 'autocomplete' => 'off']) }}
		<div style="padding:15px;background-color:#fff;border-radius:6px;">
			<fieldset>
				<h2 class="form-signin-heading text-center">Add Account</h2>
				<div class="form-group {{{ $errors->has('first_name') ? 'error' : '' }}}">
					<label for="first_name">Frist Name <span style="color:red;">(*)</span></label>
					<input type="text" id="first_name" name="first_name" required="true" class="form-control" value="{{{ Request::old('first_name', $account->first_name) }}}" />
					{{{ $errors->first('first_name') }}}
				</div>
				<div class="form-group {{{ $errors->has('last_name') ? 'error' : '' }}}">
					<label for="last_name">Last Name <span style="color:red;">(*)</span></label>
					<input type="text" id="last_name" name="last_name" required="true" class="form-control" value="{{{ Request::old('last_name', $account->last_name) }}}" />
					{{{ $errors->first('first_name') }}}
				</div>
				<div class="form-group {{{ $errors->has('phone') ? 'error' : '' }}}">
					<label for="phone">Phone</label>
					<input type="text" id="phone" name="phone" class="form-control" value="{{{ Request::old('phone', $account->phone) }}}" />
					{{{ $errors->first('number') }}}
				</div>
				<div class="form-group {{{ $errors->has('birth') ? 'error' : '' }}}">
					<label for="birth">Birth <span style="color:red;">(*)</span></label>
					@if(Input::old('birth'))
						<input type="text" id="datepicker1" data-date-format="yyyy-mm-dd" name="birth" required="true" class="datepicker form-control" value="{{{ Request::old('birth', $account->birth) }}}" />
					@else
						<input type="text" id="datepicker1" data-date-format="yyyy-mm-dd" name="birth" required="true" class="datepicker form-control" value="{{ date('Y-m-d') }}" />
					@endif
					{{{ $errors->first('birth') }}}
				</div>
				<div class="form-group {{{ $errors->has('image') ? 'error' : '' }}}">
					<label for="image">Image</label>
					<input type="file" id="image" name="image" class="form-control" />
					@if(!empty($account->image))
						<img src="{{{ url($account->image) }}}" alt="image" width="180">
					@endif
					{{{ $errors->first('image') }}}
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
			</fieldset>
		</div>
	{{ Form::close() }}
@stop