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
	<div id="app" class="bg-sky-700">
	  <div class="relative bg-sky-700 pb-32 overflow-hidden" style="height: 30rem;">
	    <!-- Menu open: "bg-sky-900", Menu closed: "bg-transparent" -->
	    <nav class="bg-transparent relative z-10 border-b border-teal-500 border-opacity-25 lg:bg-transparent lg:border-none">
	      <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
	        <div class="relative h-16 flex items-center justify-between lg:border-b lg:border-sky-800">
	          <div class="px-2 flex items-center lg:px-0">
	            <a href="/box"><h1 class="text-3xl font-bold text-white">Truck-i BOX</h1></a>
	          </div>
	        </div>
	      </div>
	    </nav>
	    <div aria-hidden="true" class="rotate-45 inset-y-0 absolute inset-x-0 left-1/2 transform -translate-x-1/2 w-full overflow-hidden lg:inset-y-0">
	      <div class="absolute inset-0 flex">
	        <div class="h-full w-1/2" style="background-color: #0a527b"></div>
	        <div class="h-full w-1/2" style="background-color: #065d8c"></div>
	      </div>
	      <div class="relative flex justify-center">
	        <svg class="flex-shrink-0" width="1750" height="308" viewBox="0 0 1750 308" xmlns="http://www.w3.org/2000/svg">
	          <path d="M284.161 308H1465.84L875.001 182.413 284.161 308z" fill="#0369a1" />
	          <path d="M1465.84 308L16.816 0H1750v308h-284.16z" fill="#065d8c" />
	          <path d="M1733.19 0L284.161 308H0V0h1733.19z" fill="#0a527b" />
	          <path d="M875.001 182.413L1733.19 0H16.816l858.185 182.413z" fill="#0a4f76" />
	        </svg>
	      </div>
	    </div>
	  </div>

	  <main class="relative" style="margin-top: -24rem;">
	    <div class="max-w-screen-xl mx-auto pb-6 px-4 sm:px-6 lg:pb-16 lg:px-8">
	      <div class="bg-sky-700 rounded-lg  overflow-hidden">
	          @yield('content')
	      </div>
	    </div>
	  </main>
	</div>



</body>


<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script async type="text/javascript" src="{{ mix('js/trix-attachment.js') }}"></script>
@stack('js')

</html>