@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_incidents' => true])

	
	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir incidencia'))
    @include('fleet.vehicles.incidents.create')
@endcomponent

<br><br>

@if($vehicle->incidents->count() > 0)
    @component('components.card', ['is_table' => true])
        @slot('title', __('Incidencias del vehículo'))
        <table >
          <thead >
            <tr >
              <th>{{ __('ID') }}</th>
              <th>{{ __('Incidencia') }}</th>
              <th>{{ __('Estado') }}</th>
              <th>{{ __('Fecha') }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
              @foreach($vehicle->incidents()->latest()->get() as $incidence)
              <tr>
                <td>
                  <p>#{{$incidence->id}}</p>
                  <p class="text-xs">{{ $incidence->user->name }}</p>
                </td>
                <td class="w-full">
                  <div class="incidence_content">{!! $incidence->incidence !!}</div>
                  @if($incidence->user_id == Auth::user()->id)
                    <button class="incidence_edit"><i class="fas fa-edit fa-lg"></i></button>
                  @endif
                  <form class="incidence_form hidden" method="POST" action="{{ route('fleet.vehicles.incidents.update', [$vehicle, $incidence->id]) }}">
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
                <td>{{ $incidence->created_at->format('d/m/Y') }}</td>
                <td>
                  @if($incidence->closed_at)
                    <x-form-button method="PUT" :action="route('fleet.vehicles.incidents.update', [$vehicle, $incidence->id])" class="btn-outline-gray">
                        <input type="hidden" name="reopen" value="1">
                        {{ __('Reabrir') }}
                    </x-form-button>
                  @else
                    <x-form-button method="PUT" :action="route('fleet.vehicles.incidents.update', [$vehicle, $incidence->id])" class="btn-outline-red">
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