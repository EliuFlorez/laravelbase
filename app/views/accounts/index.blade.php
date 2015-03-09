@extends('layouts.default')

@section('title')
@parent
: Account
@stop

@section('content')
	<div style="padding:35px;background-color:#fff;border-radius:6px;">
		<fieldset>
			<legend>Cuentas</legend>
			<div class="row">
				<div class="col-xs-6 col-md-6">
					{{ link_to_route('accounts.create', 'Agregar Cuenta', array(), array('class' => 'btn btn-primary')) }}
				</div>
				<div class="col-xs-6 col-md-6">
					{{ Form::open(['url' => 'accounts', 'method' => 'GET', 'class' => 'navbar-form pull-right', 'role' => 'search']) }}
						<div class="{{{ $errors->has('q') ? 'error' : '' }}}">
							<label style="padding:5px;" for="name">Buscar: </label>
							<input type="text" id="q" name="q" autofocus="true" class="form-control" placeholder="Por nombre..." />
							{{{ $errors->first('q') }}}
						</div>
					{{ Form::close() }}
				</div>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>{{ link_to_route('accounts.index', 'ID', $attributes[0]) }}</td>
						<td>{{ link_to_route('accounts.index', 'First', $attributes[1]) }}</td>
						<td>{{ link_to_route('accounts.index', 'Last', $attributes[2]) }}</td>
						<td>{{ link_to_route('accounts.index', 'Phone', $attributes[3]) }}</td>
						<th>View</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
				@foreach($accounts as $key => $value)
					<tr>
						<td>{{ $accountId = $value->id }}</td>
						<td>{{{ $value->first_name }}}</td>
						<td>{{{ $value->last_name }}}</td>
						<td>{{{ $value->phone }}}</td>
						<td>{{ link_to_route('accounts.show', 'View', array($accountId), array('class' => 'btn btn-info')) }}</td>
						<td>{{ link_to_route('accounts.edit', 'Edit', array($accountId), array('class' => 'btn btn-warning')) }}</td>
						<td>
							{{ Form::open(array('method' => 'DELETE', 'route' => array('accounts.destroy', $accountId))) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
							{{ Form::close() }}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<?php 
				if ($aLinks) {
					echo $accounts->appends($aLinks)->links();
				} else {
					echo $accounts->links(); 
				}
			?>
		</fieldset>
	</div>
@stop