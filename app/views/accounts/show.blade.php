@extends('layouts.default')

@section('title')
@parent
: View
@stop

@section('content')
	<div class="form-signin" style="padding:15px;background-color:#fff;border-radius:6px;">
		<fieldset>
			<h2 class="form-signin-heading text-center">Account View</h2>
			<div class="form-group">
				<label for="first_name">First Name: </label>
				<span>{{{ $account->first_name }}}</span>
			</div>
			<div class="form-group">
				<label for="last_name">Last Name: </label>
				<span>{{{ $account->last_name }}}</span>
			</div>
			<div class="form-group">
				<label for="phone">Phone number: </label>
				<span>{{{ $account->phone }}}</span>
			</div>
			<div class="form-group">
				<label for="birth">Birth: </label>
				<span>{{{ $account->birth }}}</span>
			</div>
			<div class="col-md-12" style="padding:10px;">
				{{ link_to_route('accounts.create', 'Add', array(), array('class' => 'btn btn-primary')) }}
				{{ link_to_route('accounts.edit', 'Edit', array($account->id), array('class' => 'btn btn-primary')) }}
			</div>
		</fieldset>
	</div>
@stop