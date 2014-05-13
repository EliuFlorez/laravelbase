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
<link rel="stylesheet" href="{{{ asset('css/styles.css') }}}">

<!-- Javascripts -->
<script src="{{{ asset('js/jquery.min.js') }}}"></script>
<script src="{{{ asset('js/bootstrap.min.js') }}}"></script>

<script type="text/javascript">
	
	var requests = 0;
	var urlBase = "{{URL::action('HomeController@showIndex')}}";
	var usersId = <?php echo (Auth::check()) ? Auth::user()->id : 0; ?>;
	
	$(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
	
	$(document).ready(function(){
		
		$("#email").blur(function(){
			$("#email").css('border-color', '');
			var value = $("#email").val();
			if(email.length >= 10){
				$.ajax({
					url: urlBase+'/account/check',
					type: 'POST',
					dataType: 'JSON',
					data: {value:value,type:'m'},
					success: function(data){
						if(data.value === true){
							$("#email").css('border-color', 'green');
						} else {
							$("#email").css('border-color', 'red');
						}
					},
					error: function(xhr, textStatus, error){
						$("#email").css('border-color', 'yellow');
					}
				});
			}
			return false;
		});
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