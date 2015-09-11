@extends('app')

@section('title')
@parent
: Users
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Users</div>
				<div class="panel-body">
					<!-- Notifications -->
					@include('notifications')
					<!-- End Notifications -->
					<div class="row">
						<div class="col-xs-6 col-md-6">
							{!! link_to_route('admin.users.create', 'New Users', array(), array('class' => 'btn btn-primary')) !!}
						</div>
						<div class="col-xs-6 col-md-6">
							{!! Form::open(['url' => 'admin/users', 'method' => 'GET', 'class' => 'navbar-form pull-right', 'role' => 'search']) !!}
								<div class="">
									<label style="padding:5px;" for="name">Search: </label>
									<input type="text" id="q" name="q" autofocus="true" class="form-control" placeholder="..." />
								</div>
							{!! Form::close() !!}
						</div>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{!! link_to_route('admin.users.index', 'ID', $attributes[0]) !!}</th>
								<th>{!! link_to_route('admin.users.index', 'Name', $attributes[1]) !!}</th>
								<th>{!! link_to_route('admin.users.index', 'Email', $attributes[2]) !!}</th>
								<th>Roles</th>
								<th>Permissions</th>
								<th>Show</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas as $key => $value)
								<tr>
									<td>{{ $id = $value->id }}</td>
									<td>{{{ $value->name }}}</td>
									<td>{{{ $value->email }}}</td>
									<td>{!! link_to_route('admin.roles.index', 'Add Roles', array('uid' => $id), array('class' => 'btn btn-info')) !!}</td>
									<td>{!! link_to_route('admin.permissions.index', 'Add Permissions', array('uid' => $id), array('class' => 'btn btn-info')) !!}</td>
									<td>{!! link_to_route('admin.users.show', 'Show', array($id), array('class' => 'btn btn-info')) !!}</td>
									<td>{!! link_to_route('admin.users.edit', 'Edit', array($id), array('class' => 'btn btn-warning')) !!}</td>
									<td>
										{!! Form::open(array('method' => 'DELETE', 'route' => array('admin.users.destroy', $id))) !!}
										{!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@if ($aLinks)
						{!! $datas->appends($aLinks)->render() !!}
					@else
						{!! $datas->render() !!}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection