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
				<div class="panel-heading">Show Roles</div>
				<div class="panel-body">
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
							<label class="col-md-4 control-label">Level</label>
							<div class="col-md-6">
								{!! Form::select('level', array(1,2,3,4,5,6,7,8,9,10), $data->level, array('class'=>'form-control')) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Description</label>
							<div class="col-md-6">
								<textarea rows="3">{{ $data->description }}</textarea> 
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection