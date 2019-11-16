<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
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
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class=""><a href="index.html">Plan de Mantenimiento</a></span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class=""><a href="alerts.html">Alertas</a></span>
						<span class="px-2 text-xs bg-gray-400 rounded-full flex inline-flex">3</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class="">Historial</span>
					</div>
					<div class="flex-1 text-center py-4 bg-white border-b-2 border-indigo-600">
						<span class="font-medium"><a href="alerts.html">Taller asociado</a></span>
					</div>
				</div>
				
				<div class="shadow-lg rounded bg-white mb-4">
					<div>
						<table class="w-full">
							<tr class="border-b">
								<td class="w-1/2 px-16 py-3 font-medium">Nombre</td>
								<td class="w-1/2 px-8 py-3">Talleres García Barriero SL</td>
							</tr>
							<tr class="border-b">
								<td class="w-1/2 px-16 py-3 font-medium">Dirección</td>
								<td class="w-1/2 px-8 py-3">C/ Tomás Paredes, 19, 36208 Vigo, Pontevedra</td>
							</tr>
							<tr class="border-b">
								<td class="w-1/2 px-16 py-3 font-medium">Email</td>
								<td class="w-1/2 px-8 py-3">taller@garciabarreiro.es</td>
							</tr>
							<tr class="border-b">
								<td class="w-1/2 px-16 py-3 font-medium">Teléfono</td>
								<td class="w-1/2 px-8 py-3">986 46 94 25</td>
							</tr>
						</table>
					</div>
					<div>
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47282.447413471076!2d-8.763538118216742!3d42.21117528718119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1688eb921553af5!2sTalleres%20Garc%C3%ADa%20Barreiro%2C%20S.L.!5e0!3m2!1ses!2ses!4v1568141538557!5m2!1ses!2ses" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>


</body>
</html>