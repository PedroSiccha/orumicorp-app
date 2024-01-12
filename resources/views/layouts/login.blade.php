<!DOCTYPE html>
<html lang="en">
<head>
	<title>Orumicorp - Ingresar</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{asset('img/logo/basic_logo.png')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login_app/css/main.css')}}">
</head>
<body style="background-color: #666666;">	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                        @yield('content')
				<div class="login100-more" style="background-image: url('img/logo/logo_vertical_ab.png');"></div>
			</div>
		</div>
	</div>
	<script src="{{asset('login_app/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('login_app/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{asset('login_app/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('login_app/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('login_app/vendor/select2/select2.min.js')}}"></script>
	<script src="{{asset('login_app/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('login_app/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{asset('login_app/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{asset('login_app/js/main.js')}}"></script>
</body>
</html>