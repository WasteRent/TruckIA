<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
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
</head>

<body>
	<div class="bg-white">
	  <div class="relative overflow-hidden">
	    <header class="relative">
	      <div class="bg-gradient-to-r from-primary-900 via-primary-800 to-purple-900 pt-6">
	        <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6" aria-label="Global">
	          <div class="flex items-center flex-1">
	            <div class="flex items-center justify-between w-full md:w-auto">
	              <a href="#" class="transform hover:scale-105 transition-transform duration-200">
	                <span class="sr-only">Truck-i</span>
	                <img class="h-12 w-auto sm:h-16 drop-shadow-2xl" src="{{ asset('img/truck-i-s.png') }}" alt="Truck-i">
	              </a>
	              <div class="-mr-2 flex items-center md:hidden">
	                <button id="open-mobile-menu" type="button" class="bg-white/10 backdrop-blur-lg rounded-xl p-2 inline-flex items-center justify-center text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white transition-all" aria-expanded="false">
	                  <span class="sr-only">Abrir menú</span>
	                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
	                  </svg>
	                </button>
	              </div>
	            </div>
	            <div class="hidden space-x-2 md:flex md:ml-10">
	              <a href="/" class="px-4 py-2 text-base font-semibold text-white hover:bg-white/10 rounded-lg transition-all duration-200">Inicio</a>

	              <a href="/#features" class="px-4 py-2 text-base font-semibold text-white hover:bg-white/10 rounded-lg transition-all duration-200">Features</a>

	              <a href="/#aboutus" class="px-4 py-2 text-base font-semibold text-white hover:bg-white/10 rounded-lg transition-all duration-200">Nosotros</a>

	              <a href="/#contact" class="px-4 py-2 text-base font-semibold text-white hover:bg-white/10 rounded-lg transition-all duration-200">Contacto</a>

	            </div>
	          </div>
	          <div class="hidden md:flex md:items-center md:space-x-4">
	            <a href="/login" class="px-6 py-2.5 text-base font-semibold text-white bg-white/10 backdrop-blur-lg hover:bg-white/20 rounded-xl transition-all duration-200 transform hover:scale-105">
	              Iniciar sesión
	            </a>
	          </div>
	        </nav>
	      </div>

	      <!--
	        Mobile menu, show/hide based on menu open state.

	        Entering: "duration-150 ease-out"
	          From: "opacity-0 scale-95"
	          To: "opacity-100 scale-100"
	        Leaving: "duration-100 ease-in"
	          From: "opacity-100 scale-100"
	          To: "opacity-0 scale-95"
	      -->
	      <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top hidden" id="mobile-menu">
	        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
	          <div class="px-5 pt-4 flex items-center justify-between">
	            <div>
	              <img class="h-10 w-auto" src="{{ asset('img/truck-i-s.png') }}" alt="">
	            </div>
	            <div class="-mr-2">
	              <button id="close-mobile-menu" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-600">
	                <span class="sr-only">Close menu</span>
	                <!-- Heroicon name: outline/x -->
	                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
	                </svg>
	              </button>
	            </div>
	          </div>
	          <div class="pt-5 pb-6">
	            <div class="px-2 space-y-1">
	              <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Inicio</a>

	              <a href="/#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Features</a>

	              <a href="/#aboutus" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Nosotros</a>

	              <a href="/#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Contacto</a>
	            </div>
	            <div class="mt-6 px-5">
	              <p class="text-center text-base font-medium text-gray-500">¿Ya eres cliente? <a href="/login" class="text-gray-900 hover:underline">Login</a></p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </header>
	    <main>
	      <div class="relative pt-10 bg-gradient-to-br from-primary-900 via-primary-800 to-purple-900 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
	        <!-- Decorative elements -->
	        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-white/5 to-transparent rounded-full blur-3xl"></div>
	        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full blur-3xl"></div>
	        
	        <div class="relative mx-auto max-w-7xl lg:px-8">
	          <div class="lg:grid lg:grid-cols-2 lg:gap-12">
	            <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:px-0 lg:text-left lg:flex lg:items-center animate-fade-in">
	              <div class="lg:py-24">
	                <a target="_blank" href="https://htauto.gal/" class="inline-flex items-center glass-dark rounded-full p-1.5 pr-3 sm:text-base lg:text-sm xl:text-base hover:scale-105 transition-all duration-300 shadow-xl">
	                  <span class="px-4 py-1.5 text-white text-xs font-bold leading-5 uppercase tracking-wide bg-gradient-to-r from-primary-500 to-purple-600 rounded-full shadow-lg">HTA Partner</span>
	                  <span class="ml-4 text-sm text-white font-medium">Alta Tecnología para el fomento de la innovación</span>
	                  <svg class="ml-2 w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
	                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
	                  </svg>
	                </a>
	                <h1 class="mt-6 text-5xl tracking-tight font-black text-white sm:mt-8 sm:text-6xl lg:mt-10 xl:text-7xl leading-tight">
	                  <span class="block animate-slide-up">La mejor manera de</span>
	                  <span class="block mt-2 bg-clip-text text-transparent bg-gradient-to-r from-primary-200 via-purple-200 to-pink-200 animate-slide-up" style="animation-delay: 0.2s;">cuidar tu flota</span>
	                </h1>
	                <p class="mt-6 text-lg text-gray-200 sm:text-xl lg:text-xl leading-relaxed animate-slide-up" style="animation-delay: 0.3s;">
	                  Control completo e integral del mantenimiento preventivo y predictivo de su flota, para reducir el gasto de intervenciones correctivas y hacerlas más sostenibles y eficientes.
	                </p>
	                <div class="mt-10 sm:mt-12 animate-slide-up" style="animation-delay: 0.4s;">
	                  <form action="/#contact" class="sm:max-w-xl sm:mx-auto lg:mx-0">
	                    <div class="sm:flex gap-3">
	                      <div class="min-w-0 flex-1">
	                        <label for="email" class="sr-only">Dirección de email</label>
	                        <input name="email" type="email" placeholder="Introduce tu email" class="block w-full px-5 py-4 rounded-xl border-0 text-base text-gray-900 placeholder-gray-500 shadow-xl focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all backdrop-blur-lg">
	                      </div>
	                      <div class="mt-3 sm:mt-0">
	                        <button type="submit" class="block w-full py-4 px-8 rounded-xl shadow-2xl bg-gradient-to-r from-primary-500 to-purple-600 text-white font-bold hover:from-primary-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-primary-300 transform hover:scale-105 transition-all duration-200">Solicitar demo</button>
	                      </div>
	                    </div>
	                    <p class="mt-4 text-sm text-gray-300 sm:mt-5">Nos pondremos en contacto y te enseñaremos cómo funciona nuestro software de gestión.</p>
	                  </form>
	                </div>
	              </div>
	            </div>
	            <div class="mt-12 -mb-16 sm:-mb-48 lg:m-0 lg:relative animate-fade-in" style="animation-delay: 0.5s;">
	              <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
	                <img class="w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-auto lg:max-w-none drop-shadow-2xl" src="https://tailwindui.com/img/component-images/cloud-illustration-teal-cyan.svg" alt="">
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>

	      <!-- Feature section with screenshot -->
	      <div class="relative bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 pt-20 sm:pt-28 lg:pt-36">
	        <div class="mx-auto max-w-md px-4 text-center sm:px-6 sm:max-w-3xl lg:px-8 lg:max-w-7xl">
	          <div class="animate-fade-in">
	            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-primary-500 to-purple-600 text-white shadow-lg">
	              Connect
	            </span>
	            <h2 class="mt-4 text-4xl font-black text-gray-900 sm:text-5xl bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent">
	              El control de tu flota al alcance de un click!
	            </h2>
	            <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-600 leading-relaxed">
	              Utilizando las lecturas del ordenador a bordo podemos predecir el mejor momento para realizar el mantenimiento de cada vehículo.
	            </p>
	          </div>
	          <div class="mt-16 -mb-10 sm:-mb-24 lg:-mb-80 animate-slide-up">
	            <img class="rounded-2xl shadow-2xl ring-1 ring-gray-900/10 transform hover:scale-105 transition-transform duration-500" src="/img/maintenance.png" alt="">
	          </div>
	        </div>
	      </div>

	      <!-- Feature section with grid -->
	      <div id="features" class="relative bg-white py-16 sm:py-24 lg:py-32 sm:mt-64 ">
	        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
	          
	        	<div class="bg-white">
	        	  <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8">
	        	    <div>
	        	      <h2 class="text-base font-semibold text-cyan-600 uppercase tracking-wide">Todo lo que necesitas</h2>
	        	      <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Todos los flujos de trabajo unificados</p>
	        	      <p class="mt-4 text-lg text-gray-500">Siempre tendrás acceso a todas las funcionalidades y podrás elegir cuales usar.</p>
	        	    </div>
	        	    <div class="mt-12 lg:mt-0 lg:col-span-2">
	        	      <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:grid-rows-4 sm:grid-flow-col sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Operaciones para cada vehículo</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Contamos con las operaciones que se deben llevar a cabo para el mantenimiento de cada vehículo.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Control interactivo de ITV's</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Podrás saber el momento exacto de realizar las ITV's y hacer seguimiento del proceso.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Reporte de averías</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Registra las averías y manten un histórico de la vida del vehículo.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Comunicación y control con talleres externos</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Conecta con talleres y usuarios de tus vehículos.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Control de sustitución neumáticos</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Cambia los neumáticos en el momento y sitio adecuado.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Check-list de verificaciones</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Te ayudamos a revisar cada milimetro de tu vehículo.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Reportes y KPI´s</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Sigue cuanto gastas en mano de obra, recambios, averías y mucho más.
	        	          </dd>
	        	        </div>

	        	        <div class="relative">
	        	          <dt>
	        	            <!-- Heroicon name: outline/check -->
	        	            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	        	              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
	        	            </svg>
	        	            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Aplicación web</p>
	        	          </dt>
	        	          <dd class="mt-2 ml-9 text-base text-gray-500">
	        	            Sigue tu flota desde cualquier parte del mundo desde cualquier dispositivo.
	        	          </dd>
	        	        </div>
	        	      </dl>
	        	    </div>
	        	  </div>
	        	</div>

	        </div>
	      </div>


	      <!-- Testimonial section -->
	      <div id="aboutus" class="pb-16 bg-gradient-to-br from-primary-600 via-purple-600 to-pink-600 lg:pb-0 lg:z-10 lg:relative">
	        <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-3 lg:gap-8">
	          <div class="relative lg:-my-8">
	            <div aria-hidden="true" class="absolute inset-x-0 top-0 h-1/2 bg-white lg:hidden"></div>
	            <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:p-0 lg:h-full">
	              <div class="aspect-w-10 aspect-h-6 rounded-xl shadow-xl overflow-hidden sm:aspect-w-16 sm:aspect-h-7 lg:aspect-none lg:h-full">
	                <img class="object-cover lg:h-full lg:w-full" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="">
	              </div>
	            </div>
	          </div>
	          <div class="mt-12 lg:m-0 lg:col-span-2 lg:pl-8">
	            <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:px-0 lg:py-20 lg:max-w-none">
	              <blockquote>
	                <div>
	                  <svg class="h-12 w-12 text-white opacity-25" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
	                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
	                  </svg>
	                  <p class="mt-6 text-lg font-medium text-white">
	                    Truck MMS nace en el año 2019 con la intención de dar solución en el Sector de los Servicios Urbanos a un problema que todos nuestros clientes nos ponían de manifiesto: el <strong>enorme gasto</strong> que tenían en reparaciones de su flota de vehículos y equipos.
	                    <br><br>
	                    Después de un periodo de toma de datos y análisis llegamos a la conclusión que el problema radicaba en la falta de mantenimiento preventivo, el cual era inexistente o muy precario.
	                    <br> <br>
	                    Así nació TRUCK-i, nuestro software de gestión de mantenimiento que da solución a este problema. Una plataforma que cuenta con los planes de mantenimiento de los equipos mas utilizados en este sector.
	                    Paulatinamente hemos ido añadiendo mas funcionalidades que hacen de TRUCK-i una herramienta imprescindible par gestionar un buen mantenimiento de flota.
	                  </p>
	                </div>
	                <footer class="mt-6">
	                  <p class="text-base font-medium text-white">Antonio Piñeiro</p>
	                  <p class="text-base font-medium text-cyan-100">Gerente TruckMMS</p>
	                </footer>
	              </blockquote>
	            </div>
	          </div>
	        </div>
	      </div>

	      <!-- Blog section -->
	      <div class="relative bg-gray-50 py-16 sm:py-24 lg:py-32">
	        <div class="relative">
	          <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
	            <h2 class="text-base font-semibold tracking-wider text-cyan-600 uppercase">high-tech</h2>
	            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
	              Tecnología
	            </p>
	            <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
	              De la mano de HTA buscamos innovar y trabajar con las mayores empresas de automoción de toda España. 
	            </p>
	          </div>
	          <div class="flex justify-center">
	          	<a href="https://htauto.gal" target="_blank"><img class="h-24 mt-16" src="https://htauto.gal/sites/default/files/logo_0.png"></a>
	          </div>
	        </div>
	      </div>

	      <!-- Blog section -->
	      <div class="bg-gray-50 pt-4 pb-16">
	        <div class="relative">
	          <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
	            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
	              ¿Quieres agendar una demo?
	            </p>
	            <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
	              Estaremos encantados de atenderte y mostrarte truck-i en directo.
	            </p>
	          </div>
	          <div class="meetings-iframe-container" data-src="https://meetings-eu1.hubspot.com/luissanny?embed=true"></div><script type="text/javascript" src="https://static.hsappstatic.net/MeetingsEmbed/ex/MeetingsEmbedCode.js"></script>
	        </div>
	      </div>



	      <!-- Contact Section -->
	      <div class="bg-gray-100" id="contact">
            <div class="">
              <div class="relative bg-white">
                <h2 class="sr-only">Contact us</h2>

                <div class="grid grid-cols-1 lg:grid-cols-3">
                  <!-- Contact information -->
                  <div class="relative overflow-hidden py-10 px-6 bg-cyan-700 sm:px-10 xl:p-12">
                    <div class="absolute inset-0 pointer-events-none sm:hidden" aria-hidden="true">
                      <svg class="absolute inset-0 w-full h-full" width="343" height="388" viewBox="0 0 343 388" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-99 461.107L608.107-246l707.103 707.107-707.103 707.103L-99 461.107z" fill="url(#linear1)" fill-opacity=".1" />
                        <defs>
                          <linearGradient id="linear1" x1="254.553" y1="107.554" x2="961.66" y2="814.66" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fff"></stop>
                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                          </linearGradient>
                        </defs>
                      </svg>
                    </div>
                    <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none sm:block lg:hidden" aria-hidden="true">
                      <svg class="absolute inset-0 w-full h-full" width="359" height="339" viewBox="0 0 359 339" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-161 382.107L546.107-325l707.103 707.107-707.103 707.103L-161 382.107z" fill="url(#linear2)" fill-opacity=".1" />
                        <defs>
                          <linearGradient id="linear2" x1="192.553" y1="28.553" x2="899.66" y2="735.66" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fff"></stop>
                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                          </linearGradient>
                        </defs>
                      </svg>
                    </div>
                    <div class="hidden absolute top-0 right-0 bottom-0 w-1/2 pointer-events-none lg:block" aria-hidden="true">
                      <svg class="absolute inset-0 w-full h-full" width="160" height="678" viewBox="0 0 160 678" fill="none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                        <path d="M-161 679.107L546.107-28l707.103 707.107-707.103 707.103L-161 679.107z" fill="url(#linear3)" fill-opacity=".1" />
                        <defs>
                          <linearGradient id="linear3" x1="192.553" y1="325.553" x2="899.66" y2="1032.66" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fff"></stop>
                            <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                          </linearGradient>
                        </defs>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">Información de contacto</h3>
                    <p class="mt-6 text-base text-cyan-50 max-w-3xl">Estamos encantados de que nos contactes y nos cuentes tu proyecto.</p>
                    <dl class="mt-8 space-y-6">
                      <dt><span class="sr-only">Phone number</span></dt>
                      <dd class="flex text-base text-cyan-50">
                        <!-- Heroicon name: outline/phone -->
                        <svg class="flex-shrink-0 w-6 h-6 text-cyan-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="ml-3">+34 667 412 762</span>
                      </dd>
                      <dt><span class="sr-only">Email</span></dt>
                      <dd class="flex text-base text-cyan-50">
                        <!-- Heroicon name: outline/mail -->
                        <svg class="flex-shrink-0 w-6 h-6 text-cyan-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-3">apineiro@truckts.com</span>
                      </dd>
                    </dl>
                  </div>

                  <!-- Contact form -->
                  <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">

                  	@if (session('success_message'))
                  		<div class="rounded-md bg-green-50 p-4">
                  		  <div class="flex">
                  		    <div class="flex-shrink-0">
                  		      <!-- Heroicon name: solid/check-circle -->
                  		      <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  		        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  		      </svg>
                  		    </div>
                  		    <div class="ml-3">
                  		      <p class="text-sm font-medium text-green-800">
                  		        {{ session('success_message') }}
                  		      </p>
                  		    </div>
                  		    <div class="ml-auto pl-3">
                  		      <div class="-mx-1.5 -my-1.5">
                  		        <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                  		          <span class="sr-only">Dismiss</span>
                  		          <!-- Heroicon name: solid/x -->
                  		          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  		            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                  		          </svg>
                  		        </button>
                  		      </div>
                  		    </div>
                  		  </div>
                  		</div>
                  	@endif

                    <h3 class="text-lg font-medium text-gray-900">Envíanos un mensaje</h3>
                    <form action="/contact" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    	@honeypot
                    	@csrf
                      <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-900">Nombre</label>
                        <div class="mt-1">
                          <input type="text" name="firstname" id="first-name" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-900">Apellidos</label>
                        <div class="mt-1">
                          <input type="text" name="lastname" id="last-name" autocomplete="family-name" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <div class="mt-1">
                          <input id="email" name="email" type="email" value="{{ request()->query('email') ?? '' }}" autocomplete="email" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div>
                        <div class="flex justify-between">
                          <label for="phone" class="block text-sm font-medium text-gray-900">Teléfono</label>
                        </div>
                        <div class="mt-1">
                          <input type="text" name="phone" id="phone" autocomplete="tel" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md" aria-describedby="phone-optional">
                        </div>
                      </div>
                      <div class="sm:col-span-2">
                        <label for="subject" class="block text-sm font-medium text-gray-900">Asunto</label>
                        <div class="mt-1">
                          <input type="text" name="subject" id="subject" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div class="sm:col-span-2">
                        <div class="flex justify-between">
                          <label for="message" class="block text-sm font-medium text-gray-900">Mensaje</label>
                        </div>
                        <div class="mt-1">
                          <textarea id="message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border border-gray-300 rounded-md" aria-describedby="message-max"></textarea>
                        </div>
                      </div>
                      <div class="sm:col-span-2 sm:flex sm:justify-end">
                        <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 sm:w-auto">
                          Enviar
                        </button>
                      </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>

	    </main>
	    <footer class="bg-gray-50" aria-labelledby="footer-heading">
	      <h2 id="footer-heading" class="sr-only">Footer</h2>
	      <div class="max-w-md mx-auto px-4 sm:max-w-7xl sm:px-6 lg:px-8">
	        <div class="border-t border-gray-200 py-8">
	          <p class="text-base text-gray-400 xl:text-center">
	            &copy; {{ date('Y') }} Truck-i. Todos los derechos reservados.

	            <a class="text-black ml-3" href="/politica-de-cookies">Política de cookies</a>
	            <a class="text-black ml-3" href="/politica-de-privacidad">Política de privacidad</a>
	          </p>
	        </div>

	      </div>
	    </footer>
	  </div>
	</div>

</body>

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>


<script type="text/javascript">
	$('#open-mobile-menu').click(function() {
		$('#mobile-menu').toggle()
	})
	$('#close-mobile-menu').click(function() {
		$('#mobile-menu').toggle()
	})
</script>

</html>