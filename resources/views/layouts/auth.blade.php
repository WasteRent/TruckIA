<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body class="bg-gray-200  text-gray-800">

	<div id="app" class="container mx-auto">
		@yield('content')
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>

</html>