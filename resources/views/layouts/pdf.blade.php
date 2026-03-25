<!doctype html>
<html>
<head>
  <title></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="{{ url(mix('css/app.css')) }}">

  <style type="text/css">

	thead {
  	    display: table-row-group;
  	}
	tr {
  	    page-break-inside: avoid;
  	}
  	table {
  	    word-wrap: break-word;
  	}
  	table td {
  	    word-break: break-all;
  	}


  </style>
</head>




<body class="p-8">
	<div>@yield('content')</div>

	@stack('js')
</body>
</html>