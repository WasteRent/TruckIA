@extends('layouts.fleet')

@section('title', __('Incidencias'))

@section('content')
	
	@component('components.search-card')
		@include('fleet.incidents.search', ['route' => 'fleet.incidents.index'])
	@endcomponent

	@if($incidents->count() > 0)
	    @component('components.card', ['is_table' => true])
	        <table >
	          <thead >
	            <tr >
	              <th>{{ __('ID') }}</th>
	              <th>{{ __('Matrícula') }}</th>
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
	                  <p>#{{$incidence->id}}</p>
	                  <p class="text-xs">{{ $incidence->user->name }}</p>
	                </td>
	                <td> <a href="{{ route('fleet.vehicles.incidents.index', $incidence->vehicle) }}">{{ $incidence->vehicle->plate }}</a> </td>
	                <td class="">
	                  <div class="incidence_content">{!! $incidence->incidence !!}</div>
	                    <button class="incidence_edit"><i class="fas fa-edit fa-lg"></i></button>
	                  <form class="incidence_form hidden" method="POST" action="{{ route('fleet.vehicles.incidents.update', [$incidence->vehicle, $incidence->id]) }}">
	                    @csrf
	                    @method('PUT')
	                    <x-trix name="incidence_{{$incidence->id}}">
	                      @if($incidence->incidence) {{ $incidence->incidence }} @endif
	                    </x-trix>
	                    
	                    

	                    <div class="flex justify-between">
	                    	<div>
	                    		<label class="form-label form-required">{{ __('Fecha') }}</label>
	                    		{!! Form::date('incidence_date_'.$incidence->id, $incidence->created_at->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
	                    	</div>
	                      <button class="btn-outline-gray mt-1">{{ __('Guardar') }}</button>
	                    </div>
	                  </form>
	                </td>
	                <td>
	                  <span class="badge bg-yellow-100 text-yellow-700">{{ __('Abierta') }}</span>
	                </td>
	                <td>{{ $incidence->created_at->format('d/m/Y') }}</td>
	                <td>
	                    <x-form-button method="PUT" :action="route('fleet.vehicles.incidents.update', [$incidence->vehicle, $incidence->id])" class="text-xs flex items-center text-red-700">
	                        <input type="hidden" name="closed_at" value="1">
	                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
	                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
	                        </svg>
	                        {{ __('Cerrar') }}
	                    </x-form-button>
	                    <a class="text-xs flex items-center text-blue-700 mt-3 w-24" href="{{ route('fleet.fast-orders.create', ['vehicle_id' => $incidence->vehicle->id, 'incident_id' => $incidence->id]) }}">
	                    	<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
	                    	  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
	                    	</svg>
	                    	<span class="mr-2">Crear O.R.</span>
	                    </a>
	                </td>
	              </tr>
	              @endforeach
	          </tbody>
	        </table>
	    @endcomponent

	@endif
@endsection

@push('js')
<script type="text/javascript">
  $(".incidence_edit").click(function(e) {
    $(this).siblings('.incidence_form').toggle()
    $(this).siblings('.incidence_content').toggle()
  })
</script>
@endpush