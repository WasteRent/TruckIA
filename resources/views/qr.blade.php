<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<title></title>
</head>
<body>

	<div class="grid grid-cols-3 gap-0.5">
		@foreach($ids as $id)
			<div class="rounded-md p-2" style="background: #2d205f;">
				<img class="w-full bg-white rounded-md" src="{{ (new \chillerlan\QRCode\QRCode)->render(route('box', ['qrid' => $id])) }}" alt="QR Code" />
				<div class="text-center text-white py-2">
					<span class="text-sm">Mantenimiento gestionado por <br> <strong>truck-i.com</strong></span>
					<p class="text-xs">ID: {{ $id }}</p>
				</div>
			</div>
		@endforeach
	</div>

</body>
</html>
