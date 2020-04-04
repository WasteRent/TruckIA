<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</head>
<body class="text-gray-800" style="background-color: #edf2f7">

	@if(!request()->is('login*') && !request()->is('password*'))
		@include('kustomer::kustomer')
	@endif
	
	<div class="container mx-auto">
		@yield('app')
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
	<script type="text/javascript">
		flatpickr('.datepicker', {
			locale: 'es',
		    altInput: true,
		    altFormat: "d/m/Y",
		    dateFormat: "Y-m-d",
		});
	</script>
</body>
</html>