<div class="mb-5 border-b border-gray-200 sm:pb-0">
  <div class="hidden sm:block">
    <nav class="-mb-px flex space-x-8">
      <a href="{{ route('fleet.kpis.expense') }}" class="{{ request()->is('*/expense') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Gasto preventivo</a>
      <a href="{{ route('fleet.kpi.vehicle-expense') }}" class="{{ request()->is('*kpis/vehicle-expense') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Gasto por vehículo</a>
      <a href="{{ route('fleet.kpi.incidents') }}" class="{{ request()->is('*kpis/incidents') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm" aria-current="page">Incidencias por vehículo</a>
    </nav>
  </div>
</div>