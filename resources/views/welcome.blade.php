@extends('app')

@section('content')
	<style>
		.container {text-align:center;display:table-cell;vertical-align:middle;}
		.content {text-align:center;display:inline-block;}
		.title {font-size:96px;margin-bottom:40px;}
		.quote {font-size:24px;}
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="content">
					<div class="title">Laravel 5</div>
					<div class="quote">{{ Inspiring::quote() }}</div>
				</div>
			</div>
		</div>
	</div>
@endsection
