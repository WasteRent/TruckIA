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
                <td>{!! $accident_report->summary !!}</td>
                <td>{{ $accident_report->created_at?->format('d/m/Y') }}</td>
                <td>
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
  $(".incidence_edit").click(function(e) {
    $(this).siblings('.incidence_form').toggle()
    $(this).siblings('.incidence_content').toggle()
  })
</script>
@endpush