<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>
<body class="bg-gray-200  text-gray-800">

	<div class="container mx-auto">
		<div class="pt-4 pb-10 flex items-center">
			<div class="mr-6">
				<img class="w-32" src="https://truckts.com/img/logos/truckts_logo.png">
			</div>
			<h1 class="py-6 text-2xl mt-2">Gestión de Mantenimientos</h1>
		</div>

		<div class="flex">
			<div class="w-1/6 mr-8">
				<div class="leading-loose">
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="logo-model-s"></ion-icon>
						Vehículo Existente
					</div>
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="add-circle"></ion-icon>
						Vehículo Nuevo
					</div>
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="clipboard"></ion-icon>
						Planes de Mantenimiento
					</div>
				</div>
			</div>

			<div class="w-5/6">
				<div class="flex">
					<div class="flex-1 text-center py-4 bg-white border-b-2 border-indigo-600">
						<span class="font-medium">Plan de Mantenimiento</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class=""><a href="alerts.html">Alertas</a></span>
						<span class="px-2 text-xs bg-gray-400 rounded-full flex inline-flex">3</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class="">Historial</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class=""><a href="garage.html">Taller asociado</a></span>
					</div>
				</div>
				
				<div class="shadow-lg rounded bg-white p-8 mb-4">
					<div class="mb-4 text-indigo-600">
						<span class="font-bold text-2xl">DAF CF 85.460</span>
						<span class="px-2">+</span>
						<span class="font-bold text-2xl">FAUN Variopress</span>
					</div>
					<div class="flex">
						<div class="w-1/2">
							<ul class="leading-loose text-sm">
								<li>
									<img class="h-6 mb-2" src="img/plate.jpg">
								</li>
								<li>
									Matriculado el 17 Sep. 2011
								</li>
								<li class="flex items-center">
									<span>271922 kms</span>
									<span class="mr-2">&nbsp;(2 Oct. 2019)</span>
									<ion-icon name="ios-create"></ion-icon>
								</li>
								<li>
									3000 km/mes
								</li>
								<li>
									<span>Propiedad de </span><span class="font-medium underline">Wasterent</span>
								</li>
							</ul>
							<img src="https://www.modelmotor.es/large/Camion-de-basura-Mercedes-Faun-Variopress-Siku-2938-escala-150-i20408.jpg">
						</div>
						<div class="w-1/2">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47282.447413471076!2d-8.763538118216742!3d42.21117528718119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1688eb921553af5!2sTalleres%20Garc%C3%ADa%20Barreiro%2C%20S.L.!5e0!3m2!1ses!2ses!4v1568141538557!5m2!1ses!2ses" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
						</div>
					</div>
				</div>

				<div class="shadow-lg rounded bg-white p-8 mb-4">
					<h1 class="text-indigo-600 uppercase font-bold text-sm mb-4">Plan de mantenimiento chasis</h1>
					
					@foreach($plans as $plan)
						<h2 class="font-medium text-gray-800 mt-6">{{ $plan->frequency }}</h2>
						<div class="leading-loose text-gray-700">
							@foreach($plan->operations as $operation)
							<div class="flex">
								<div class="w-1/2">
									<ion-icon class="mr-1" name="checkmark-circle"></ion-icon>
									{{ $operation->name }}
								</div>
								<div class="w-1/2">
									{{ $operation->acceptance }}
								</div>
							</div>
							@endforeach
						</div>
					@endforeach


				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>