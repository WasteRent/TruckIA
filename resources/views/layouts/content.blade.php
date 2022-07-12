<div class="h-screen flex overflow-hidden" style="background-color: #f7f7ff;">
  <!-- Off-canvas menu for mobile -->
  <div class="md:hidden">
    <div class="fixed inset-0 flex z-40 hidden" id="sidebar-content">
      <!--
        Off-canvas menu overlay, show/hide based on off-canvas menu state.

        Entering: "transition-opacity ease-linear duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "transition-opacity ease-linear duration-300"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0">
        <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
      </div>
      <!--
        Off-canvas menu, show/hide based on off-canvas menu state.

        Entering: "transition ease-in-out duration-300 transform"
          From: "-translate-x-full"
          To: "translate-x-0"
        Leaving: "transition ease-in-out duration-300 transform"
          From: "translate-x-0"
          To: "-translate-x-full"
      -->
      <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-100 h-full" style="background-image: url({{asset('img/bg-theme.png')}});background-size: 100% 100%; background-attachment: fixed; background-position: center; background-repeat: no-repeat; box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%)!important;border-right: 1px solid rgb(228 228 228 / 0%);">
        <div class="absolute top-0 right-0 -mr-14 p-1">
          <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" aria-label="Close sidebar" id="sidebar-close-button">
            <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex-shrink-0 flex items-center px-4">
          <a href="/fleet"><img loading="lazy" class="h-10 w-auto" src="{{ Auth::user()->getLogo() }}"/></a>
        </div>
        <div class="mt-5 flex-1 h-0 overflow-y-auto">
          <nav class="px-2">
            @foreach($nav_items as $item)
            <span>
              <a href="{{ $item['link'] }}" class="group flex items-center my-1 px-3 py-2 text-sm leading-5 font-medium focus:outline-none transition ease-in-out duration-150 tracking-wide {{ $item['active'] ? 'text-white bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-20 focus:text-white text-white' }}">
                {!! $item['icon'] !!} 
                {{ $item['name'] }} 

                @isset($item['badge'])
                <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-opacity-20 bg-white">
                  {{ $item['badge'] }}
                </span>
                @endisset
              </a>

              @isset($item['end_section'])
                <div class="mb-6"></div>
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
  <div style="background-image: url({{asset('img/bg-theme.png')}});background-size: 100% 100%; background-attachment: fixed; background-position: center; background-repeat: no-repeat; box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%)!important;border-right: 1px solid rgb(228 228 228 / 0%);" class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
      <div class="flex items-center flex-shrink-0 px-4 py-2" style="border-bottom: 1px solid rgb(255 255 255 / 15%);">
        <a href="/fleet/kpis"><img loading="lazy" class="h-12 w-auto" src="{{ Auth::user()->getLogo() }}" /></a>
      </div>
      <div class="h-0 flex-1 flex flex-col overflow-y-auto">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <nav class="flex-1 px-2">
          @foreach($nav_items as $item)
          <span>
            <a href="{{ $item['link'] }}" class="group flex items-center my-1 px-3 py-2 text-sm leading-5 font-medium focus:outline-none transition ease-in-out duration-150 tracking-wide {{ $item['active'] ? 'text-white bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-20 focus:text-white text-white' }}">
              {!! $item['icon'] !!} 
              {{ $item['name'] }} 

              @isset($item['badge'])
              <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-opacity-20 bg-white">
                {{ $item['badge'] }}
              </span>
              @endisset
            </a>

            @isset($item['end_section'])
              <div class="mb-6"></div>
            @endisset
          </span>
          @endforeach
        </nav>

        <div class="flex items-center space-x-2 px-4">
          <a href="/set-lang/es"><img class="w-6 h-6" src="{{ asset('img/locale/es.png') }}"></a>
          <a href="/set-lang/it"><img class="w-6 h-6" src="{{ asset('img/locale/it.png') }}"></a> 
        </div>

      </div>
    </div>
  </div>
  <div class="flex flex-col w-0 flex-1 overflow-hidden">
    <div class="relative z-10 flex-shrink-0 flex h-16 bg-white" style="webkit-box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 0px 6px 0 rgb(206 206 238 / 54%); box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 0px 6px 0 rgb(206 206 238 / 54%);">
      <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden" aria-label="Open sidebar" id="sidebar-open-button">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </button>
      <div class="flex-1 px-4 flex justify-between">

        <div class="flex w-full">
          <div class="w-full flex items-center md:ml-0">
            <h1 class="sm:text-2xl font-semibold text-gray-900">@yield('title')</h1>
          </div>

          @if(in_array(Auth::id(), [920,929,637,872,679,964,928,955,966,970]))
          <div class="mt-3 mr-6">
              <form action="{{ route('fleet.switch') }}" class="mb-3">
                @csrf
                <div class="flex w-full">
                  {!! Form::select('fleet_id', App\Models\Fleet::all()->pluck('name', 'id'), auth()->user()->fleet->id, ['class' => 'form-select', 'placeholder' => '']) !!}
                  <button class="btn-outline-gray ml-1">Cambiar</button>          
                </div>
              </form>
          </div>
          @endif

          <div class="mt-1 w-28 flex">
            <div class="relative py-4 w-12">
              <a href="{{ route('fleet.feed.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
              </a>
            </div>
            <div class="relative py-4 w-12">
            @if(auth()->user()->hasRole('fleet'))
              <x-latest-alerts/>
            @endif
            </div>
            <div class="relative py-4 w-12 hidden">
              <x-latest-messages/>
            </div>
          </div>
        </div>
        <div class="w-48 ml-4 flex items-center md:ml-6 border-l">
          <!-- Profile dropdown -->
          <div class="ml-3 relative">
            <div class="flex items-center">
              <button id="profile-dropdown-button" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring" id="user-menu" aria-label="User menu" aria-haspopup="true">
                <img loading="lazy" class="h-10 w-10 rounded-full" src="{{ Auth::user()->avatar ? Auth::user()->avatar->getLink() : 'https://foundationfar.org/wp-content/uploads/2020/03/Profile_avatar_placeholder_large.png' }}" />
              </button>
              <span class="hidden sm:block text-xs leading-5 font-medium text-gray-700 group-hover:text-gray-900 ml-2">{{ Auth::user()->name }}</span>
            </div>
            <!--
              Profile dropdown panel, show/hide based on dropdown state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg hidden" id="profile-dropdown-content">
              <div class="py-1 rounded-md bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                <a href="{{ route('auth.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Perfil
                </a>
                <form class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" action="/logout" method="POST">
                  <button>Salir</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
      <div class="max-w-7xl mx-auto px-2 sm:px-6">
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