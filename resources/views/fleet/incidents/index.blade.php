@extends('layouts.fleet')

@section('title', 'Incidencias')

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
	                  @if($incidence->user_id == Auth::user()->id)
	                    <button class="incidence_edit"><i class="fas fa-edit fa-lg"></i></button>
	                  @endif
	                  <form class="incidence_form hidden" method="POST" action="{{ route('fleet.vehicles.incidents.update', [$incidence->vehicle, $incidence->id]) }}">
	                    @csrf
	                    @method('PUT')
	                    <x-trix name="incidence_{{$incidence->id}}">
	                      @if($incidence->incidence) {{ $incidence->incidence }} @endif
	                    </x-trix>
	                    <div class="flex justify-end">
	                      <button class="btn-outline-gray mt-1">{{ __('Guardar') }}</button>
	                    </div>
	                  </form>
	                </td>
	                <td>
	                  @if($incidence->closed_at)
	                  <span title="{{$incidence->closed_at}}" class="badge bg-green-200 text-green-800">{{ __('Cerrada') }}</span>
	                  @else
	                  <span class="badge bg-yellow-200 text-yellow-800">{{ __('Abierta') }}</span>
	                  @endif
	                </td>
	                <td>{{ $incidence->created_at->format('d/m/Y H:i') }}</td>
	                <td>
	                  @if($incidence->closed_at)
	                    <x-form-button method="PUT" :action="route('fleet.vehicles.incidents.update', [$incidence->vehicle, $incidence->id])" class="btn-outline-gray">
	                        <input type="hidden" name="reopen" value="1">
	                        {{ __('Reabrir') }}
	                    </x-form-button>
	                  @else
	                    <x-form-button method="PUT" :action="route('fleet.vehicles.incidents.update', [$incidence->vehicle, $incidence->id])" class="btn-outline-red">
	                        <input type="hidden" name="closed_at" value="1">
	                        {{ __('Cerrar') }}
	                    </x-form-button>
	                  @endif
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