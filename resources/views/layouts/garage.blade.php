<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body class="bg-gray-200 text-gray-800">
	<div class="container mx-auto">
		<div class="pt-4 pb-10 flex items-center justify-between">
			<div class="flex items-center">
				<img class="w-32 mr-8" src="https://truckts.com/img/logos/truckts_logo.png">
				<a href="{{ route('garage.repair-orders.index') }}" class="text-sm">Ordenes de reparación</a>
			</div>
			<div class="flex items-center">
				<span class="text-sm mr-2">{{ Auth::user()->name }}</span>
				<a class="" href="{{ route('auth.logout') }}">
					<i class="fas fa-power-off"></i>
				</a>
			</div>
		</div>


		<div class="w-full">
			
			@if (session('success_message'))
				<div class="my-3">
					@component('components.alert-success')
						{{ session('success_message') }}
					@endcomponent
				</div>
			@elseif(session('error_message'))
				<div class="my-3">
					@component('components.alert-error')
						{{ session('error_message') }}
					@endcomponent
				</div>
			@endif

			@if ($errors->any())
				<div class="my-3">
					@component('components.alert-error')
						<ul>
						    @foreach ($errors->all() as $error)
						        <li>&middot; {{ $error }}</li>
						    @endforeach
						</ul>
					@endcomponent
				</div>
			@endif

			@yield('progress')
			
			<div class="text-2xl font-light mb-3">
				@yield('title')
			</div>

			<main>@yield('content')</main>
			<br><br>
		</div>
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>