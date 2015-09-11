@extends('app')

@section('title')
@parent
: Create
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add Roles</div>
				<div class="panel-body">

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					
					{!! Form::open(['url' => 'admin/roles', 'route' => 'admin.roles.store', 'class' => 'form-horizontal', 'autocomplete' => 'off']) !!}
						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Slug</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Level</label>
							<div class="col-md-6">
								{!! Form::select('level', array(1,2,3,4,5,6,7,8,9,10), old('level'), array('class'=>'form-control')) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Description</label>
							<div class="col-md-6">
								<textarea rows="3" name="description" placeholder="Description">{{ old('description') }}</textarea> 
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" id="Save" class="btn btn-primary">Save</button>
								<a href="{{ url('admin/roles') }}" class="btn btn-danger">Cancel</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection