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
<style>
.form-signin {max-width:330px;padding:15px;margin:0 auto;border-style:solid;border-color:#ff0000 #0000ff;}
.form-signin .form-signin-heading,.form-signin .checkbox {margin-bottom:10px;}
.form-signin .checkbox {font-weight:normal;}
.form-signin .form-control {position:relative;font-size:16px;height:auto;padding:10px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.form-signin .form-control:focus {z-index:2;}
.form-signin input[type="text"] {margin-bottom:-1px;border-bottom-left-radius:0;border-bottom-right-radius:0;}
.form-signin input[type="password"] {margin-bottom:10px;border-top-left-radius:0;border-top-right-radius:0;}
.form-signin .inputs {margin-bottom:0px;border-bottom-left-radius:0;border-bottom-right-radius:0;border-top-left-radius:0;border-top-right-radius:0;}
.form-signin .inputc {margin-bottom:10px!important;border-top-left-radius:0;border-top-right-radius:0;border-bottom-left-radius:4px!important;border-bottom-right-radius:4px!important;}
.form-signin .btn-up {border-bottom-left-radius:0px!important;border-bottom-right-radius:0px!important;}
.form-signin .btn-down {border-top-left-radius:0px!important;border-top-right-radius:0px!important;}
.wrap {min-height:100%;height:auto;margin-top:30px;padding: 0 0 30px;}
.wrap-footer {line-height:40px;margin:30px;color:#999;text-align:center;background-color:#f9f9f9;border-top:1px solid #e5e5e5;}
</style>
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