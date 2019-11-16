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
					<div class="flex-1 text-center py-4 bg-white border-b-2 border-indigo-600">
						<span class="font-medium">Alertas</span>
						<span class="px-2 text-xs bg-gray-400 rounded-full flex inline-flex">3</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class="">Historial</span>
					</div>
					<div class="flex-1 text-center py-4 bg-gray-100 border-r border-gray-400">
						<span class=""><a href="garage.html">Taller asociado</a></span>
					</div>
				</div>
				
				<div class="shadow-lg rounded bg-white mb-4">
					<div class="float-right mr-3">
						<button class="my-2 border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
							<ion-icon class="mr-2" name="send"></ion-icon>
							Pedir cita
						</button>
					</div>

					<h1 class="p-8 text-red-600 uppercase font-bold text-sm flex items-center">
						Mantenimiento obligatorio
					</h1>

					<table class="w-full">
						<tr class="border-b bg-gray-200 uppercase text-xs font-medium">
							<td class="px-8 py-3"></td>
							<td class="px-8 py-3">Descripción</td>
							<td class="px-8 py-3">Fecha</td>
							<td class="px-8 py-3">Cita</td>
						</tr>
						<tr class="border-b">
							<td class="pl-8 py-3"><input type="checkbox"></td>
							<td class="w-2/3 px-8 py-3">
								<div>El Vehículo 1111 AAA requiere un cambio de aceite en dos semanas</div>
							</td>
							<td class="px-8 py-3">09/09/2019</td>
							<td class="px-8 py-3">25/09/2019</td>
						</tr>
						<tr class="border-b">
							<td class="pl-8 py-3"><input type="checkbox"></td>
							<td class="w-2/3 px-8 py-3">
								<div>El Vehículo 1111 AAA requiere un cambio de filtro de aire en dos semanas</div>
							</td>
							<td class="px-8 py-3">06/09/2019</td>
							<td class="px-8 py-3">25/09/2019</td>
						</tr>
						<tr class="border-b">
							<td class="pl-8 py-3"><input type="checkbox"></td>
							<td class="w-2/3 px-8 py-3">
								<div>El Vehículo 1111 AAA requiere un cambio de filtros de aceite en dos semanas</div>
							</td>
							<td class="px-8 py-3">05/09/2019</td>
							<td class="px-8 py-3">25/09/2019</td>
						</tr>
					</table>
				</div>

				<div class="shadow-lg rounded bg-white p-8 mb-4">
					<h1 class="text-yellow-600 uppercase font-bold text-sm mb-4 flex items-center">
						<input class="mr-3" type="checkbox">
						Mantenimiento predictivo recomendado
					</h1>
					<ul class="leading-loose text-gray-700">
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Revisar aceite (chasis, DAF)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Revisar líquido de freno (chasis, DAF)
						</li>
					</ul>
					<br>
					<h2 class="font-medium text-gray-800">Cada semana</h2>
					<ul class="leading-loose text-gray-700">
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar los tornillos de unión entre la caja y el chasis (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar conexiones de latiguillos, bloques y cilindros hidráulicos buscando posibles fugas (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar pala, trineo y guías maestras por existencia de fisuras o grietas (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Lubricar los pestillos del "tailgate" (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar cojinetes de parte trasera (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Limpiar las guías o raíles de las partes móviles (caja, FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Engrasar cojinetes o partes móviles (caja, FAUN)
						</li>
					</ul>
					<br>
					<h2 class="font-medium text-gray-800">Cada 8 semanas</h2>
					<ul class="leading-loose text-gray-700">
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Lubricar el eje de las bombas hidráulicas (caja; FAUN)
						</li>
					</ul>
					<br>
					<h2 class="font-medium text-gray-800">Cada 6 meses</h2>
					<ul class="leading-loose text-gray-700">
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar presiones hidráulicas (caja; FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar funcionamiento de línea de seguridad (caja; FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Comprobar funcionamiento del sistema eléctrico (caja; FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Cambiar filtros de aceite (cambiar de nuevo después de una semana) (caja; FAUN)
						</li>
						<li class="flex items-center">
							<ion-icon class="mr-1" name="arrow-dropright"></ion-icon>
							Inspeccionar y lubricar todo el mecanismo de compactación (caja; FAUN)
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>


</body>
</html>