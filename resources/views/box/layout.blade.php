<!DOCTYPE html>
<html>
<head>
	<title>truck-i / Box</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
	
	@bukStyles(true)

	@production
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-LT7XV1NNH0"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-LT7XV1NNH0');
		</script>
		<!-- Hotjar Tracking Code for https://truck-i.com/ -->
		<script>
		    (function(h,o,t,j,a,r){
		        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		        h._hjSettings={hjid:2877337,hjsv:6};
		        a=o.getElementsByTagName('head')[0];
		        r=o.createElement('script');r.async=1;
		        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		        a.appendChild(r);
		    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
	@endproduction

</head>

<body>
	<div class="mx-auto container max-w-lg">
		@include('shared.alerts')
	</div>
	<section class="bg-gradient-to-b from-transparent to-green-100" style="    height: 100vh;">

		<div class="px-4 py-6 flex justify-between">
			<h1 class="text-2xl font-semibold mb-10 text-gray-700">Empieza a <span class="text-teal-500">cuidar de tu flota.</span></h1>
			<a href="/login"><img class="w-16" src="{{ asset('img/truck-i-l.png') }}"></a>
		</div>

	    <div class="sm:grid grid-cols-2 px-4 sm:px-0"> 
	      <div>@yield('content')</div>
	      <img src="{{ asset('img/login.png') }}"> 
	    </div>
	</section>
</body>

@bukScripts(true)

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script async type="text/javascript" src="{{ mix('js/trix-attachment.js') }}"></script>
@stack('js')

</html>