@if(auth()->user()->trial_ends_at)
<div class="relative bg-indigo-500">
  <div class="mx-auto max-w-7xl py-2 px-3 sm:px-6 lg:px-8">
    <div class="pr-16 sm:px-16 sm:text-center">
      <p class="font-medium text-white">
        <span class="">Quedan {{ Carbon\Carbon::parse(auth()->user()->trial_ends_at)->diffInDays() }} días de prueba</span>
        <span class="block sm:ml-2 sm:inline-block">
          <a href="https://truckts.com/contacto" class="font-bold text-white underline">
            Contactar para obtener una oferta
            <span aria-hidden="true"> &rarr;</span>
          </a>
        </span>
      </p>
    </div>
  </div>
</div>
@endif

<div class="h-screen flex overflow-hidden bg-gray-50">
  <!-- Off-canvas menu for mobile -->
  <div class="tablet:hidden">
    <div class="fixed inset-0 flex z-40 hidden" id="sidebar-content">
      <!-- Overlay -->
      <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>

      <!-- Sidebar móvil -->
      <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gradient-to-b from-green-50 to-green-100 h-full shadow-2xl">
        <div class="absolute top-0 right-0 -mr-14 p-1">
          <button class="flex items-center justify-center h-12 w-12 rounded-full bg-gray-800 hover:bg-gray-700 focus:outline-none transition-all duration-200" aria-label="Close sidebar" id="sidebar-close-button">
            <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex-shrink-0 flex items-center h-20 px-6">
          <a href="/fleet" class="flex items-center space-x-2">
            @if(Auth::user()->getLogo())
              <img loading="lazy" class="h-12 w-auto drop-shadow-lg" src="{{ Auth::user()->getLogo()  }}"/>
            @elseif(Auth::user()->hasRole('fleet'))
              <span class="text-2xl font-bold text-green-800">{{ Auth::user()->fleet?->name }}</span>
            @endif
          </a>
        </div>
        <div class="mt-5 flex-1 h-0 overflow-y-auto scrollbar-thin scrollbar-thumb-green-300 scrollbar-track-transparent">
          <nav class="px-3 space-y-1">
            @foreach($nav_items as $item)
            <span>
              <a href="{{ $item['link'] }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $item['active'] ? 'bg-green-600 text-white shadow-lg' : 'text-green-800 hover:bg-green-200 hover:text-green-900' }}">
                {!! $item['icon'] !!}
                <span class="ml-3">{{ $item['name'] }}</span>

                @isset($item['badge'])
                <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-600 text-white shadow-sm">
                  {{ $item['badge'] }}
                </span>
                @endisset
              </a>

              @isset($item['end_section'])
                <div class="my-4 border-t border-green-300"></div>
              @endisset
            </span>
            @endforeach
          </nav>
        </div>
      </div>
      <div class="flex-shrink-0 w-14">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
      </div>
    </div>
  </div>

  <!-- Static sidebar for desktop -->
  <div class="hidden tablet:flex tablet:flex-shrink-0">
    <div class="flex flex-col w-72 bg-gradient-to-b from-green-50 to-green-100 shadow-2xl">

      <div class="flex items-center flex-shrink-0 h-20 px-6 border-b border-green-300">
        <a href="/fleet/kpis" class="flex items-center space-x-3 group">
          @if(Auth::user()->getLogo())
            <img loading="lazy" class="h-12 w-auto drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-200" src="{{ Auth::user()->getLogo() }}" />
          @elseif(Auth::user()->hasRole('fleet'))
            <span class="font-bold text-green-800 text-2xl group-hover:text-green-900 transition-colors">{{ Auth::user()->fleet?->name }}</span>
          @endif
        </a>
      </div>

      <div class="h-0 flex-1 flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-green-300 scrollbar-track-transparent py-4">
        <!-- Sidebar component -->
        <nav class="flex-1 px-4 space-y-1">
          @foreach($nav_items as $item)
          <span>
            <a href="{{ $item['link'] }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $item['active'] ? 'bg-green-600 text-white shadow-lg' : 'text-green-800 hover:bg-green-200 hover:text-green-900' }}">
              <span class="flex items-center justify-center w-6">{!! $item['icon'] !!}</span>
              <span class="ml-3 flex-1">{{ $item['name'] }}</span>

              @isset($item['badge'])
              <span class="ml-auto inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-600 text-white shadow-sm">
                {{ $item['badge'] }}
              </span>
              @endisset
            </a>

            @isset($item['end_section'])
              <div class="my-4 border-t border-green-300"></div>
            @endisset
          </span>
          @endforeach
        </nav>

        <div class="flex items-center justify-center space-x-3 px-6 py-4 border-t border-green-300">
          <a href="/set-lang/es" class="transform hover:scale-110 transition-transform duration-200 hover:shadow-lg rounded-full">
            <img class="w-8 h-8 rounded-full shadow-md" src="{{ asset('img/locale/es.png') }}">
          </a>
          <a href="/set-lang/it" class="transform hover:scale-110 transition-transform duration-200 hover:shadow-lg rounded-full">
            <img class="w-8 h-8 rounded-full shadow-md" src="{{ asset('img/locale/it.png') }}">
          </a>
        </div>

      </div>
    </div>
  </div>
  <div class="flex flex-col w-0 flex-1" style="overflow-y: auto;">
    <div class="relative z-10 flex-shrink-0 flex h-20 glass-card border-b border-gray-200/50 shadow-soft">
      <button class="px-4 border-r border-gray-200 text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 focus:text-gray-600 tablet:hidden transition-colors" aria-label="Open sidebar" id="sidebar-open-button">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </button>
      <div class="flex-1 px-6 flex justify-between items-center">

        <div class="flex w-full items-center">
          <div class="w-full flex items-center md:ml-0">
            <h1 class="text-2xl md:text-3xl font-bold text-green-800">@yield('title')</h1>
          </div>

          @if(in_array(Auth::id(), [637,872,920]))
          <div class="mt-3 mr-6">
              <form action="{{ route('fleet.switch') }}" class="mb-3">
                @csrf
                <div class="flex w-full">
                  {!! Form::select('fleet_id', App\Models\Fleet::all()->pluck('name', 'id'), auth()->user()->fleet->id, ['class' => 'form-select']) !!}
                  <button class="btn-outline-gray ml-1">Cambiar</button>
                </div>
              </form>
          </div>
          @elseif(Auth()->user()->allowedFleets()->count())
          <div class="mt-3 mr-6">
              <form action="{{ route('fleet.switch') }}" class="mb-3">
                @csrf
                <div class="flex w-full">
                  {!! Form::select('fleet_id', Auth()->user()->allowedFleets->pluck('name', 'id'), auth()->user()->fleet->id, ['class' => 'form-select']) !!}
                  <button class="btn-outline-gray ml-1">Cambiar</button>
                </div>
              </form>
          </div>
          @endif

          @if(in_array(auth()->user()->job, ['fleet_manager']))
          <div class="flex items-center space-x-2">
            <a href="{{ route('fleet.feed.index') }}" class="p-2.5 rounded-xl hover:bg-green-50 transition-all duration-200 group">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
              </svg>
            </a>
            @if(auth()->user()->hasRole('fleet'))
              <div class="p-2.5 rounded-xl hover:bg-green-50 transition-all duration-200">
                <x-latest-alerts/>
              </div>
            @endif
          </div>
          @endif
        </div>
        <div class="flex items-center ml-6 pl-6 border-l border-gray-200">
          <!-- Profile dropdown -->
          <div class="relative">
            <button id="profile-dropdown-button" class="flex items-center space-x-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200 group" aria-label="User menu" aria-haspopup="true">
              <span class="hidden sm:block text-sm font-semibold text-gray-700 group-hover:text-green-600">{{ Auth::user()->name }}</span>
              <img loading="lazy" class="h-11 w-11 rounded-xl ring-2 ring-green-100 group-hover:ring-green-300 transition-all shadow-md" src="{{ Auth::user()->avatar ? Auth::user()->avatar->getLink() : 'https://foundationfar.org/wp-content/uploads/2020/03/Profile_avatar_placeholder_large.png' }}" />
            </button>

            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-soft-xl bg-white border border-gray-100 hidden animate-fade-in" id="profile-dropdown-content" style="z-index: 9999;">
              <div class="py-2" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                <a href="{{ route('auth.profile.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 transition-all duration-150 group" role="menuitem">
                  <svg class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Perfil
                </a>
                <div class="my-1 border-t border-gray-100"></div>
                @if(auth()->user()->allowedCustomers()->where('customer_id', 431)->count())
                <form class="block" action="/logout-simple" method="POST">
                  @csrf
                  <button class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-150 group">
                    <svg class="h-5 w-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Salir
                  </button>
                </form>
                @else
                <form class="block" action="/logout" method="POST">
                  <button class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-150 group">
                    <svg class="h-5 w-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Salir
                  </button>
                </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <main class="flex-1 relative z-0 py-6 focus:outline-none" tabindex="0">
      <div class="mx-auto px-2 sm:px-6">
        @yield('app')
      </div>
    </main>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $("#profile-dropdown-button").click(function() {
    $("#profile-dropdown-content").toggle()
  })
  $("#sidebar-close-button").click(function() {
    $("#sidebar-content").hide()
  })
  $("#sidebar-open-button").click(function() {
    $("#sidebar-content").show()
  })
</script>
@endpush