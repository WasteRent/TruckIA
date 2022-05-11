<div class="rounded-md bg-yellow-50 p-4 shadow -mt-10">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
      </svg>
    </div>
    <div class="ml-3 flex-1 md:flex md:justify-between">
      <p class="text-sm text-yellow-700">Los datos de gasto están en fase de pruebas y no deben ser tomados como referencia.</p>
    </div>
  </div>
</div>

<br>

<div class="mb-5 border-b border-gray-200 sm:pb-0">
  <div class="hidden sm:block">
    <nav class="-mb-px flex space-x-8">
      <a href="{{ route('fleet.kpis.expense') }}" class="{{ request()->is('*/expense') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Gasto preventivo</a>
      <a href="{{ route('fleet.kpi.vehicle-expense') }}" class="{{ request()->is('*kpis/vehicle-expense') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Gasto por vehículo</a>
      <a href="{{ route('fleet.kpi.incidents') }}" class="{{ request()->is('*kpis/incidents') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm" aria-current="page">Incidencias por vehículo</a>
    </nav>
  </div>
</div>