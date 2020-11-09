@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@if(!$repair_order->isFinished())
			@slot('corner')
				<div class="flex">
					<form onsubmit="return confirmAction()" class="mr-4" method="POST" action="{{ route('fleet.repair-orders.finish', $repair_order) }}">
						@csrf
						@method('PUT')
						<button class="btn-outline-gray">
							Finalizar
						</button>
					</form>
					<form onsubmit="return confirmDelete()" method="POST" action="{{ route('fleet.repair-orders.destroy', $repair_order) }}">
						@csrf
						@method('DELETE')
						<button class="btn-outline-red">
							Eliminar
						</button>
					</form>
				</div>
			@endslot
		@endif

		<div class="sm:flex">
			<div class="sm:w-1/2">
				@component('components.table')
					@slot('items', [
						'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
						'Vehículo' => $repair_order->vehicle->chassis .' '. $repair_order->vehicle->equipment,
						'Creada por' => $repair_order->creator->name,
						'Asignada a' => $repair_order->assigned ? $repair_order->assigned->name : '',
						'Autorizada por' => $repair_order->authorizer ? $repair_order->authorizer->name : '',
						'Estado' => $repair_order->state->name,
						'Taller vió por pri. vez' => optional($repair_order->seen_at)->diffForHumans(),
						'Taller vió por ult. vez' => optional($repair_order->last_seen_at)->diffForHumans(),
						'Observaciones' => $repair_order->remarks,
					])
				@endcomponent
			</div>
			<div class="sm:w-1/2 mt-4 sm:mt-0">

				{!! Form::model($repair_order, [
					'route' => ['fleet.repair-orders.state.update', $repair_order],
					'method' => 'PUT',
					'class' => 'w-full'
				]) !!}	
					<div class="flex items-center">
						<div class="mr-4">
							{!! Form::select('state_id', $states->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
						</div>
						<div><button class="btn-outline-gray">Cambiar estado</button></div>
					</div>
				{!! Form::close() !!}

				<fieldset>
					<legend>Estados</legend>
					@foreach($repair_order->history as $history)
						<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) {{$history->state->color}} @endif">
							<div class="w-1/2">
								<span class="">{{$history->state->name}}</span>
							</div>
							<div class="w-1/2">
								{{ $history->user->name }} &middot;
								{{$history->created_at->format('d/m/y H:i:s')}}
							</div>
						</div>
					@endforeach
				</fieldset>
			</div>
		</div>
	@endcomponent

	@component('components.card')
		@slot('title', 'Datos generales')

		{!! Form::model($repair_order, [
			'route' => ['fleet.repair-orders.update', $repair_order],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			<div class="flex flex-wrap -mx-3">
			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Fecha de apertura
			    </label>
			    {!! Form::text('created_at', null, ['class' => 'form-input datepicker']) !!}
			  </div>

			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			      <label class="form-label">
			        Asignada a
			      </label>
			        {!! Form::select('assigned_user_id', $repair_order->garage->users->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
			  </div>

			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Kms
			    </label>
			    {!! Form::number('kms', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Horas Chasis
			    </label>
			    {!! Form::number('work_hours_chassis', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Horas Equipo
			    </label>
			    {!! Form::number('work_hours_equipment', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			  <div class="w-full mt-6 px-3 md:mb-0">
			  	<label class="form-label" >
			  	  Nota interna de OR
			  	</label>
			  	{!! Form::textarea('internal_notes', null, ['class' => 'form-input', 'rows' => 2]) !!}
			  </div>
			</div>
			<div class="flex justify-end">
				<button class="btn-indigo">Actualizar</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

	@if($repair_order->type == 'pre-itv')
		@include('fleet.repair_orders.itv')
	@endif
	
	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones Realizadas')
		@include('shared.repair_orders.operations', ['repair_order' => $repair_order])
	@endcomponent
@endsection
