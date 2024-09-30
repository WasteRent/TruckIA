@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_accident_reports' => true])

	
	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir siniestro'))
    @include('fleet.vehicles.accidents.create')
@endcomponent

<br><br>

@component('components.search-card')
{!! 
  Form::model(request()->all(), [
    'route' => ['fleet.vehicles.accident-reports.index', $vehicle], 
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


@if($accident_reports->count() > 0)
    @component('components.card', ['is_table' => true])
        @slot('title', __('Siniestros del vehículo'))
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
              @foreach($accident_reports as $accident_report)
              <tr>
                <td>
                  <p>#{{$accident_report->id}}</p>
                  <p class="text-xs">{{ $accident_report->user?->name }}</p>
                </td>
                <td>
                  <div class="accident_report_content">{!! $accident_report->summary !!}</div>
                    <button class="accident_report_edit"><i class="fas fa-edit fa-lg"></i></button>
                  <form class="accident_report_form hidden" method="POST" action="{{ route('fleet.vehicles.accident-reports.update', [$vehicle, $accident_report->id]) }}">
                    @csrf
                    @method('PUT')
                    <x-trix name="accident_report_{{$accident_report->id}}">
                      @if($accident_report->summary) {{ $accident_report->summary }} @endif
                    </x-trix>
                    <div class="flex justify-between">
                      <div>
                        <label class="form-label form-required">{{ __('Fecha') }}</label>
                        {!! Form::date('accident_report_date_'.$accident_report->id, $accident_report->created_at?->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
                      </div>
                      <button class="btn-outline-gray mt-1">{{ __('Guardar') }}</button>
                    </div>
                  </form>
                </td>
                <td>{{ $accident_report->created_at?->format('d/m/Y') }}</td>
                <td>
                  @if($accident_report->closed_at)
                    <x-form-button method="PUT" :action="route('fleet.vehicles.accident-reports.update', [$vehicle, $accident_report->id])" class="btn-outline-gray">
                        <input type="hidden" name="reopen" value="1">
                        {{ __('Reabrir') }}
                    </x-form-button>
                  @else
                    <x-form-button method="PUT" :action="route('fleet.vehicles.accident-reports.update', [$accident_report->vehicle, $accident_report->id])" class="text-xs flex items-center text-red-700">
                        <input type="hidden" name="closed_at" value="1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Cerrar') }}
                    </x-form-button>
                  @endif

                  <form class="mt-3" method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.accident-reports.destroy', [$vehicle, $accident_report]) }}">
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
  $(".accident_report_edit").click(function(e) {
    $(this).siblings('.accident_report_form').toggle()
    $(this).siblings('.accident_report_content').toggle()
  })
</script>
@endpush