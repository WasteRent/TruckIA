<!doctype html>
<html>
<head>
  <title></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="{{ url(mix('css/app.css')) }}">
</head>


<body>
	<div>@yield('content')</div>

	@stack('js')
</body>
</html>