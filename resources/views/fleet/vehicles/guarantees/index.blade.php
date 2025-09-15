@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_guarantees' => true])

	
	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir garantía'))
    @include('fleet.vehicles.guarantees.create')
@endcomponent

<br><br>

@component('components.search-card')
{!! 
  Form::model(request()->all(), [
    'route' => ['fleet.vehicles.guarantees.index', $vehicle], 
    'method' => 'GET',
    'class' => ['md:flex items-center']
  ])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Descripción')}}</label>
      {!! Form::text('guarantee', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
@endcomponent


@if($guarantees->count() > 0)
    @component('components.card', ['is_table' => true])
        @slot('title', __('Garantías del vehículo'))
        <table >
          <thead >
            <tr >
              <th>{{ __('ID') }}</th>
              <th>{{ __('Garantía') }}</th>
              <th>{{ __('Estado') }}</th>
              <th>{{ __('Fecha') }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
              @foreach($guarantees as $guarantee)
              <tr>
                <td>
                  <p>#{{$guarantee->id}}</p>
                  <p class="text-xs">{{ $guarantee->user->name }}</p>
                </td>
                <td class="w-full">
                  <div class="guarantee_content">{!! $guarantee->guarantee !!}</div>
                    <button class="guarantee_edit"><i class="fas fa-edit fa-lg"></i></button>
                  <form class="guarantee_form hidden" method="POST" action="{{ route('fleet.vehicles.guarantees.update', [$vehicle, $guarantee->id]) }}">
                    @csrf
                    @method('PUT')
                    <x-trix name="guarantee_{{$guarantee->id}}">
                      @if($guarantee->guarantee) {{ $guarantee->guarantee }} @endif
                    </x-trix>
                    <div class="flex justify-between">
                      <div>
                        <label class="form-label">{{ __('Reasignar') }}</label>
                        {!! Form::select('mechanic_user_id_'.$guarantee->id, auth()->user()->fleet->users()->where('job', 'mechanic')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
                      </div>
                      <div>
                        <label class="form-label form-required">{{ __('Fecha') }}</label>
                        {!! Form::date('guarantee_date_'.$guarantee->id, $guarantee->created_at?->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
                      </div>
                      <button class="btn-outline-gray mt-1">{{ __('Guardar') }}</button>
                    </div>
                  </form>
                </td>
                <td>
                  @if($guarantee->closed_at)
                  <span title="{{$guarantee->closed_at}}" class="badge bg-green-200 text-green-800">{{ __('Cerrada') }}</span>

                  @if($guarantee->repair_orders->count())
                    @foreach($guarantee->repair_orders as $repair_order)
                      <a class="underline" href="{{ route('fleet.repair-orders.show', $repair_order) }}">O.R #{{ $repair_order->id }}</a>
                    @endforeach
                  @endif

                  @else
                  <span class="badge bg-yellow-200 text-yellow-800">{{ __('Abierta') }}</span>
                  @endif
                </td>
                <td>{{ $guarantee->created_at?->format('d/m/Y') }}</td>
                <td>
                  @if($guarantee->closed_at)
                    <x-form-button method="PUT" :action="route('fleet.vehicles.guarantees.update', [$vehicle, $guarantee->id])" class="btn-outline-gray">
                        <input type="hidden" name="reopen" value="1">
                        {{ __('Reabrir') }}
                    </x-form-button>
                  @else
                    <x-form-button method="PUT" :action="route('fleet.vehicles.guarantees.update', [$guarantee->vehicle, $guarantee->id])" class="text-xs flex items-center text-red-700">
                        <input type="hidden" name="closed_at" value="1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Cerrar') }}
                    </x-form-button>
                    <a class="text-xs flex items-center text-blue-700 mt-3 w-24" href="{{ route('fleet.fast-orders.create', ['vehicle_id' => $guarantee->vehicle->id, 'guarantee_id' => $guarantee->id]) }}">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                      <span class="mr-2">Crear O.R.</span>
                    </a>
                  @endif
                  @if(auth()->user()->id == $guarantee->user_id)
                  <form class="mt-3" method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.guarantees.destroy', [$vehicle, $guarantee]) }}">
                    @csrf
                    @method('DELETE')
                    <button><i class="icon fas fa-trash-alt"></i></button>
                  </form>
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
  $(".guarantee_edit").click(function(e) {
    $(this).siblings('.guarantee_form').toggle()
    $(this).siblings('.guarantee_content').toggle()
  })
</script>
@endpush