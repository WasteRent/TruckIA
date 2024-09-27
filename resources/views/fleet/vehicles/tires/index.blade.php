@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_tires_reports' => true])

	
	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir reporte de neumáticos'))
    @include('fleet.vehicles.tires.create')
@endcomponent

<br><br>

@component('components.search-card')
{!! 
  Form::model(request()->all(), [
    'route' => ['fleet.vehicles.tires-reports.index', $vehicle], 
    'method' => 'GET',
    'class' => ['md:flex items-center']
  ])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Descripción')}}</label>
      {!! Form::text('summary', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
@endcomponent


@if($tires_reports->count() > 0)
    @component('components.card', ['is_table' => true])
        @slot('title', __('Reportes de neumáticos del vehículo'))
        <table >
          <thead >
            <tr >
              <th>{{ __('ID') }}</th>
              <th>{{ __('Descripción') }}</th>
              <th>{{ __('Fecha') }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
              @foreach($tires_reports as $tires_report)
              <tr>
                <td>
                  <p>#{{$tires_report->id}}</p>
                  <p class="text-xs">{{ $tires_report->user?->name }}</p>
                </td>
                <td>{!! $tires_report->summary !!}</td>
                <td>{{ $tires_report->created_at?->format('d/m/Y') }}</td>
                <td>
                @if($tires_report->closed_at)
                    <x-form-button method="PUT" :action="route('fleet.vehicles.tires-reports.update', [$vehicle, $tires_report->id])" class="btn-outline-gray">
                        <input type="hidden" name="reopen" value="1">
                        {{ __('Reabrir') }}
                    </x-form-button>
                  @else
                    <x-form-button method="PUT" :action="route('fleet.vehicles.tires-reports.update', [$vehicle, $tires_report->id])" class="text-xs flex items-center text-red-700">
                        <input type="hidden" name="closed_at" value="1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Cerrar') }}
                    </x-form-button>
                  @endif
                  <form class="mt-3" method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.tires-reports.destroy', [$vehicle, $tires_report]) }}">
                    @csrf
                    @method('DELETE')
                    <button><i class="icon fas fa-trash-alt"></i></button>
                  </form>
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