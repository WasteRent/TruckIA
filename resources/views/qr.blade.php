<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;0,900;1,900&display=swap" rel="stylesheet">

	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<title></title>

	<style type="text/css">
		* {
			font-family: 'Source Sans Pro', sans-serif;
		}
	</style>
</head>
<body>

	<div class="">
		@foreach($ids as $id)
			<div class="p-6 mb-1.5" style="background: #03876e; width: 48rem;">
				<div class="bg-white flex">
					<div class="flex flex-col items-center">
						<img style="width:18rem;" class="" src="{{ (new \chillerlan\QRCode\QRCode)->render(route('box', ['qrid' => $id])) }}" alt="QR Code" />
						<p class="text-3xl font-extrabold tracking-wider" style="color: #03876e;margin-top: -0.8rem;">{{ $id }}</p>
					</div>
					<div class="text-6xl py-4" style="color:#00b487;">
						
						<p class="italic py-0.5">Mantenimiento</p>
						<p class="italic py-0.5">gestionado con</p>
						<p class="italic py-0.5">truck-i.com</p>

						<div class="flex justify-end">
							<img class="w-20" src="{{ asset('img/truck-i-l.png') }}">
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

</body>
</html>
