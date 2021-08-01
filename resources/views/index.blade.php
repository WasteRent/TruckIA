<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
	<div class="bg-white">
	  <div class="relative overflow-hidden">
	    <header class="relative">
	      <div class="bg-gray-900 pt-6">
	        <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6" aria-label="Global">
	          <div class="flex items-center flex-1">
	            <div class="flex items-center justify-between w-full md:w-auto">
	              <a href="#">
	                <span class="sr-only">Workflow</span>
	                <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-teal-200-cyan-400.svg" alt="">
	              </a>
	              <div class="-mr-2 flex items-center md:hidden">
	                <button type="button" class="bg-gray-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-800 focus:outline-none focus:ring-2 focus-ring-inset focus:ring-white" aria-expanded="false">
	                  <span class="sr-only">Open main menu</span>
	                  <!-- Heroicon name: outline/menu -->
	                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
	                  </svg>
	                </button>
	              </div>
	            </div>
	            <div class="hidden space-x-8 md:flex md:ml-10">
	              <a href="/" class="text-base font-medium text-white hover:text-gray-300">Inicio</a>

	              <a href="/#features" class="text-base font-medium text-white hover:text-gray-300">Features</a>

	              <a href="/#aboutus" class="text-base font-medium text-white hover:text-gray-300">Nosotros</a>

	              <a href="/#contact" class="text-base font-medium text-white hover:text-gray-300">Contacto</a>

	            </div>
	          </div>
	          <div class="hidden md:flex md:items-center md:space-x-6">
	            <a href="/login" class="text-base font-medium text-white hover:text-gray-300">
	              Log in
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
	      <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top md:hidden">
	        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
	          <div class="px-5 pt-4 flex items-center justify-between">
	            <div>
	              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-teal-500-cyan-600.svg" alt="">
	            </div>
	            <div class="-mr-2">
	              <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-600">
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

	              <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Features</a>

	              <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Marketplace</a>

	              <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Company</a>
	            </div>
	            <div class="mt-6 px-5">
	              <a href="#" class="block text-center w-full py-3 px-4 rounded-md shadow bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-medium hover:from-teal-600 hover:to-cyan-700">Start free trial</a>
	            </div>
	            <div class="mt-6 px-5">
	              <p class="text-center text-base font-medium text-gray-500">Existing customer? <a href="#" class="text-gray-900 hover:underline">Login</a></p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </header>
	    <main>
	      <div class="pt-10 bg-gray-900 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
	        <div class="mx-auto max-w-7xl lg:px-8">
	          <div class="lg:grid lg:grid-cols-2 lg:gap-8">
	            <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:px-0 lg:text-left lg:flex lg:items-center">
	              <div class="lg:py-24">
	                <a target="_blank" href="https://htauto.gal/" class="inline-flex items-center text-white bg-black rounded-full p-1 pr-2 sm:text-base lg:text-sm xl:text-base hover:text-gray-200">
	                  <span class="px-3 py-0.5 text-white text-xs font-semibold leading-5 uppercase tracking-wide bg-gradient-to-r from-teal-500 to-cyan-600 rounded-full">HTA Partner</span>
	                  <span class="ml-4 text-sm">Alta Tecnología para el fomento de la innovación</span>
	                  <!-- Heroicon name: solid/chevron-right -->
	                  <svg class="ml-2 w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
	                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
	                  </svg>
	                </a>
	                <h1 class="mt-4 text-4xl tracking-tight font-extrabold text-white sm:mt-5 sm:text-6xl lg:mt-6 xl:text-6xl">
	                  <span class="block">La mejora manera de</span>
	                  <span class="pb-3 block bg-clip-text text-transparent bg-gradient-to-r from-teal-200 to-cyan-400 sm:pb-5">cuidar tu flota</span>
	                </h1>
	                <p class="text-base text-gray-300 sm:text-xl lg:text-lg xl:text-xl">
	                  Control completo e integral del mantenimiento preventivo y predictivo de su flota, para reducir el gasto de intervenciones correctivas y hacerlas más sostenibles y eficientes.
	                </p>
	                <div class="mt-10 sm:mt-12">
	                  <form action="#" class="sm:max-w-xl sm:mx-auto lg:mx-0">
	                    <div class="sm:flex">
	                      <div class="min-w-0 flex-1">
	                        <label for="email" class="sr-only">Email address</label>
	                        <input id="email" type="email" placeholder="Introduce tu email" class="block w-full px-4 py-3 rounded-md border-0 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-400 focus:ring-offset-gray-900">
	                      </div>
	                      <div class="mt-3 sm:mt-0 sm:ml-3">
	                        <button type="submit" class="block w-full py-3 px-4 rounded-md shadow bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-medium hover:from-teal-600 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-400 focus:ring-offset-gray-900">Solicitar demo</button>
	                      </div>
	                    </div>
	                    <p class="mt-3 text-sm text-gray-300 sm:mt-4">Nos pondremos en contacto y te enseñaremos cómo funciona nuestro software de gestión.</p>
	                  </form>
	                </div>
	              </div>
	            </div>
	            <div class="mt-12 -mb-16 sm:-mb-48 lg:m-0 lg:relative">
	              <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
	                <!-- Illustration taken from Lucid Illustrations: https://lucid.pixsellz.io/ -->
	                <img class="w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="https://tailwindui.com/img/component-images/cloud-illustration-teal-cyan.svg" alt="">
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>

	      <!-- Feature section with screenshot -->
	      <div class="relative bg-gray-50 pt-16 sm:pt-24 lg:pt-32">
	        <div class="mx-auto max-w-md px-4 text-center sm:px-6 sm:max-w-3xl lg:px-8 lg:max-w-7xl">
	          <div>
	            <h2 class="text-base font-semibold tracking-wider text-cyan-600 uppercase">Serverless</h2>
	            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
	              No server? No problem.
	            </p>
	            <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
	              Phasellus lorem quam molestie id quisque diam aenean nulla in. Accumsan in quis quis nunc, ullamcorper malesuada. Eleifend condimentum id viverra nulla.
	            </p>
	          </div>
	          <div class="mt-12 -mb-10 sm:-mb-24 lg:-mb-80">
	            <img class="rounded-lg shadow-xl ring-1 ring-black ring-opacity-5" src="https://tailwindui.com/img/component-images/green-project-app-screenshot.jpg" alt="">
	          </div>
	        </div>
	      </div>

	      <!-- Feature section with grid -->
	      <div class="relative bg-white py-16 sm:py-24 lg:py-32">
	        <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
	          <h2 class="text-base font-semibold tracking-wider text-cyan-600 uppercase">Deploy faster</h2>
	          <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
	            Everything you need to deploy your app
	          </p>
	          <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
	            Phasellus lorem quam molestie id quisque diam aenean nulla in. Accumsan in quis quis nunc, ullamcorper malesuada. Eleifend condimentum id viverra nulla.
	          </p>
	          <div class="mt-12">
	            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/cloud-upload -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Push to Deploy</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Descripción detallada y visual de las operaciones
	                    </p>
	                  </div>
	                </div>
	              </div>

	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/lock-closed -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">SSL Certificates</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Qui aut temporibus nesciunt vitae dicta repellat sit dolores pariatur. Temporibus qui illum aut.
	                    </p>
	                  </div>
	                </div>
	              </div>

	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/refresh -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Simple Queues</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Rerum quas incidunt deleniti quaerat suscipit mollitia. Amet repellendus ut odit dolores qui.
	                    </p>
	                  </div>
	                </div>
	              </div>

	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/shield-check -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Advanced Security</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Ullam laboriosam est voluptatem maxime ut mollitia commodi. Et dignissimos suscipit perspiciatis.
	                    </p>
	                  </div>
	                </div>
	              </div>

	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/cog -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Powerful API</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Ab a facere voluptatem in quia corrupti veritatis aliquam. Veritatis labore quaerat ipsum quaerat id.
	                    </p>
	                  </div>
	                </div>
	              </div>

	              <div class="pt-6">
	                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
	                  <div class="-mt-6">
	                    <div>
	                      <span class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-md shadow-lg">
	                        <!-- Heroicon name: outline/server -->
	                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
	                        </svg>
	                      </span>
	                    </div>
	                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Database Backups</h3>
	                    <p class="mt-5 text-base text-gray-500">
	                      Quia qui et est officia cupiditate qui consectetur. Ratione similique et impedit ea ipsum et.
	                    </p>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>

	      <!-- Testimonial section -->
	      <div class="pb-16 bg-gradient-to-r from-teal-500 to-cyan-600 lg:pb-0 lg:z-10 lg:relative">
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
	            <h2 class="text-base font-semibold tracking-wider text-cyan-600 uppercase">Learn</h2>
	            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
	              Helpful Resources
	            </p>
	            <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
	              Phasellus lorem quam molestie id quisque diam aenean nulla in. Accumsan in quis quis nunc, ullamcorper malesuada. Eleifend condimentum id viverra nulla.
	            </p>
	          </div>
	          <div class="mt-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">
	          		hola
	          </div>
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
                    <h3 class="text-lg font-medium text-gray-900">Envíanos un mensaje</h3>
                    <form action="#" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                      <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-900">Nombre</label>
                        <div class="mt-1">
                          <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-900">Apellidos</label>
                        <div class="mt-1">
                          <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
                        </div>
                      </div>
                      <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <div class="mt-1">
                          <input id="email" name="email" type="email" autocomplete="email" class="py-3 px-4 block w-full shadow-sm text-gray-900 focus:ring-cyan-500 focus:border-cyan-500 border-gray-300 rounded-md">
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
	          </p>
	        </div>
	      </div>
	    </footer>
	  </div>
	</div>

</body>

</html>