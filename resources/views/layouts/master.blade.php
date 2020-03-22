<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">

	@if(!request()->is('login*') && !request()->is('password*'))
		@include('kustomer::kustomer')
	@endif
	
	<div class="container mx-auto">
		@yield('app')
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>