@extends('app')

@section('title')
	@parent
	: Show
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Show Permissions</div>
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

						<form class="form-horizontal">
							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" value="{{ $data->name }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Slug</label>
								<div class="col-md-6">
									<input type="text" class="form-control" value="{{ $data->slug }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Model</label>
								<div class="col-md-6">
									{!! Form::select('model', array(1,2,3,4,5,6,7,8,9,10), $data->model, array('class'=>'form-control')) !!}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Description</label>
								<div class="col-md-6">
									<textarea rows="3">{{ old('description', $data->description) }}</textarea>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection