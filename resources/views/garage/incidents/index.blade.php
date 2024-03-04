@extends('layouts.garage')

@section('title', __('Incidencias'))

@section('content')
	
	@component('components.search-card')
		@include('garage.incidents.search', ['route' => 'garage.incidents.index'])
	@endcomponent

  @component('components.card', ['is_table' => true])

      <table >
        <thead >
          <tr >
            <th>{{ __('ID') }}</th>
            <th>{{ __('Incidencia')  }}</th>
            <th>{{ __('Estado') }}</th>
            <th>{{ __('Fecha') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($incidents as $incidence)
            <tr>
              <td>
                <p>#{{$incidence->id}} &middot; @if($incidence->vehicle->internal_id) ({{ $incidence->vehicle->internal_id }}) @endif {{ $incidence->vehicle->plate }}</p>
                <p class="text-xs">Creada por {{ $incidence->user->name }}</p>
              </td>
              <td class="">
                <div class="incidence_content">{!! $incidence->incidence !!}</div>
              </td>
              <td>
                <span class="badge bg-yellow-100 text-yellow-700">{{ __('Abierta') }}</span>
              </td>
              <td>{{ $incidence->created_at?->format('d/m/Y') }}</td>
              <td>
                  @if($incidence->repair_order)
                    <a class="text-xs flex items-center text-blue-700 mt-3 w-24" href="{{ route('garage.repair-orders.show', $incidence->repair_order) }}">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      <span class="mr-2">Ver O.R. ({{ $incidence->repair_order->assigned?->name }})</span>
                    </a>
                  @else
                    <a class="text-xs flex items-center text-blue-700 mt-3 w-24" href="{{ route('garage.fast-orders.create', ['vehicle_id' => $incidence->vehicle->id, 'incident_id' => $incidence->id]) }}">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      <span class="mr-2">Crear O.R.</span>
                    </a>
                  @endif


              </td>
            </tr>
            @endforeach
        </tbody>
      </table>
  @endcomponent

@endsection

@push('js')
<script type="text/javascript">
  $(".incidence_edit").click(function(e) {
    $(this).siblings('.incidence_form').toggle()
    $(this).siblings('.incidence_content').toggle()
  })
</script>
@endpush