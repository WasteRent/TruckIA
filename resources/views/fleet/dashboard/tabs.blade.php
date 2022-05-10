<div class="-mt-6 mb-3">
  <div class="hidden sm:block">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        <!-- Current: "border-blue-500 text-blue-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->


        <a href="{{ route('fleet.kpis.index') }}" class="@isset($fleet) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="@isset($fleet) text-blue-500 @else text-gray-400 group-hover:text-gray-500 @endif -ml-0.5 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
          </svg>
          <span>Flota</span>
        </a>

        <a href="{{ route('fleet.kpis.expense') }}" class="@isset($expense) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
          <!-- Heroicon name: solid/users -->
          <svg xmlns="http://www.w3.org/2000/svg" class="@isset($expense) text-blue-500 @else text-gray-400 group-hover:text-gray-500 @endif -ml-0.5 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <span>Gasto</span>
        </a>

        <a href="{{ route('fleet.kpis.availability') }}" class="@isset($availability) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="@isset($availability) text-blue-500 @else text-gray-400 group-hover:text-gray-500 @endif -ml-0.5 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
          </svg>
          <span>Disponibilidad</span>
        </a>

      </nav>
    </div>
  </div>
</div>
