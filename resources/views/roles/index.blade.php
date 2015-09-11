@extends('app')

@section('title')
@parent
: Roles
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Roles</div>
				<div class="panel-body">
					<!-- Notifications -->
					@include('notifications')
					<!-- End Notifications -->
					<div class="row">
						<div class="col-xs-6 col-md-6">
							{!! link_to_route('admin.roles.create', 'Add Roles', array(), array('class' => 'btn btn-primary')) !!}
						</div>
						<div class="col-xs-6 col-md-6">
							{!! Form::open(['url' => 'admin/roles', 'method' => 'GET', 'class' => 'navbar-form pull-right', 'role' => 'search']) !!}
								<div class="">
									<label style="padding:5px;" for="name">Search: </label>
									@if ($uid)
										<input type="hidden" name="uid" value="{{ $uid }}" />
									@endif
									<input type="text" id="q" name="q" autofocus="true" class="form-control" placeholder="Search..." />
								</div>
							{!! Form::close() !!}
						</div>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{!! link_to_route('admin.roles.index', 'ID', $attributes[0]) !!}</th>
								<th>{!! link_to_route('admin.roles.index', 'Name', $attributes[1]) !!}</th>
								<th>{!! link_to_route('admin.roles.index', 'Slug', $attributes[2]) !!}</th>
								<th>{!! link_to_route('admin.roles.index', 'Level', $attributes[3]) !!}</th>
								<th>{!! link_to_route('admin.roles.index', 'Description', $attributes[4]) !!}</th>
								@if ($uid) 
									<th>Add Role</th> 
								@endif
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
									<td>{{{ $value->slug }}}</td>
									<td>{{{ $value->level }}}</td>
									<td>{{{ $value->description }}}</td>
									@if ($uid) 
										<td><a href="javascript:void(0);" data-id="{{ $uid }}" id="role-{{ $id }}" class="btn btn-primary user-roles">Add Role</a></td> 
									@endif
									<td>{!! link_to_route('admin.roles.show', 'Show', array($id), array('class' => 'btn btn-info')) !!}</td>
									<td>{!! link_to_route('admin.roles.edit', 'Edit', array($id), array('class' => 'btn btn-warning')) !!}</td>
									<td>
										{!! Form::open(array('method' => 'DELETE', 'route' => array('admin.roles.destroy', $id))) !!}
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