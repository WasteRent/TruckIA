@extends('layouts.garage')

@section('title', 'Orden de Reparación #' . $repair_order->id)

@section('content')
	<div class="flex">
		<div class="w-3/12 mr-6 mt-6">
		@foreach($repair_order->operations->groupBy('family_id') as $operations)
			<h1 class="font-medium uppercase text-xs tracking-wide text-gray-600">{{ $operations->first()->family->name }}</h1>
			<ul class="text-sm mb-8">
				@foreach($operations as $operation)
					<li class="pl-4 {{ $current_operation->id == $operation->id ? 'font-bold text-blue-800' : 'text-gray-700' }}">
						<a href="{{ route('garage.show.operation', [$repair_order, $operation]) }}">
							@if($operation->pivot->completed)
								<i class="fas fa-check fa-xs mr-1"></i>
								<span class="line-through text-gray-600">{{ $operation->name }}</span>
							@else
								<span class="mr-1">&middot;</span>
								{{ $operation->name }}
							@endif
						</a>
					</li>
				@endforeach
			</ul>
		@endforeach
		</div>
		<div class="w-full">
			<div class="w-full">
			  <div class="shadow-lg w-full bg-gray-300 rounded-full">
			    <div class="bg-blue-800 text-xs leading-none py-1 text-center text-white rounded-full" style="width: {{ $repair_order->completePercent }}%">{{ $repair_order->completePercent }} %</div>
			  </div>
			</div>

			<br>

			@component('components.card')
				@slot('title', $current_operation->code . ' : ' . $current_operation->name)

				@component('components.table')
					@slot('items', [
						'Vehículo' => $repair_order->vehicle->getChassisAttribute() . ' / ' . $repair_order->vehicle->getBoxAttribute(),
						'Área' => $current_operation->family->name,
						'Descripción' => $current_operation->description,
						'Tiempo estimado (h)' => $current_operation->time_in_hours
					])
				@endcomponent
			@endcomponent

			@component('components.card')				
				{!! Form::open([
					'route' => ['garage.execute.operation', $repair_order, $current_operation],
					'files' => true,
					'method' => 'POST',
					'class' => 'w-full dropzone'
				]) !!}	

				<div class="flex flex-wrap -mx-3 mb-6">
					<div class="w-full md:w-3/12 px-3">
						<label class="form-label">
							Tiempo invertido (h)
						</label>
						{!! Form::number('real_time_in_hours', $current_operation->time_in_hours, ['class' => 'form-input', 'step' => '0.1']) !!}
					</div>
				</div>
				<div class="flex flex-wrap -mx-3 mb-6">
					<div class="w-full md:w-9/12 px-3">
						<label class="form-label">
							Observaciones
						</label>
						{!! Form::textarea('observations', null, ['class' => 'form-input h-24', 'step' => '0.01']) !!}
					</div>
				</div>
				<div class="flex flex-wrap -mx-3 mb-6">
					<div class="w-full md:w-3/12 px-3">
						<label class="form-label">
							Archivo
						</label>
						{!! Form::file('file', ['class' => 'form-input']) !!}
					</div>
				</div>
					
				@if(!$repair_order->operations()->whereId($current_operation->id)->first()->pivot->completed)
				<div class="flex justify-end">
					<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Completar</button>
				</div>
				@endif

				{!! Form::close() !!}
			@endcomponent
		</div>
	</div>
@endsection
