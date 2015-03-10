<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<meta name="csrf-token" content="{{{ csrf_token() }}}">
<title>
	@section('title')
		Laravel Base
	@show
</title>

<!-- Style -->
<link rel="stylesheet" href="{{{ asset('css/bootstrap.min.css') }}}">
<link rel="stylesheet" href="{{{ asset('css/bootstrap-theme.min.css') }}}">
<link rel="stylesheet" href="{{{ asset('css/style.css') }}}">
<link rel="stylesheet" href="{{{ asset('css/datepicker.css') }}}">

<!-- Javascripts -->
<script src="{{{ asset('js/jquery.min.js') }}}"></script>
<script src="{{{ asset('js/bootstrap.min.js') }}}"></script>
<script src="{{{ asset('js/bootstrap-datepicker.js') }}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#datepicker1').datepicker();
	});
</script>

</head>

<body>
	<!-- Menu -->
		@include('menu')
	<!-- End menu -->
	<div class="container wrap">
		<!-- Notifications -->
			@include('notifications')
		<!-- End notifications -->
		
		<!-- Content -->
			@yield('content')
		<!-- End content -->
	</div>
</body>
</html>