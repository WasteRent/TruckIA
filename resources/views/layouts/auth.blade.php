<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
	@yield('content')
</body>
</html>