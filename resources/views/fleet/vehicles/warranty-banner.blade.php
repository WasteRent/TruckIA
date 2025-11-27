@if($vehicle->hasAnyWarranty())
<div class="rounded-md bg-orange-100 p-4 shadow mb-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-orange-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
    </div>
    <div class="ml-3 flex-1">
      <div class="text-sm text-orange-700">
        @if($vehicle->hasChassisWarranty())
          <p class="mb-2">Chasis en garantía, fin: {{ Carbon\Carbon::parse($vehicle->warranty_date)->format('d/m/Y') }}</p>
        @endif
        @foreach($vehicle->getEquipmentsWithWarranty() as $equipment)
          <p class="mb-2">Equipo {{ $equipment->maker->name ?? 'N/A' }} en garantía, fin: {{ Carbon\Carbon::parse($equipment->warranty_date)->format('d/m/Y') }}</p>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif

@if(!$vehicle->maintenance_included)
<div class="rounded-md bg-blue-100 p-4 shadow mb-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
    </svg>
    </div>
    <div class="ml-3 flex-1 md:flex md:justify-between">
      <p class="text-sm text-blue-700">Mantenimiento no incluído.</p>
    </div>
  </div>
</div>
@endif