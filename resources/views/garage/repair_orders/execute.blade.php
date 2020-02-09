@extends('layouts.garage')

@section('title', 'EXEC')

@section('content')
	<div class="flex">
		<div class="w-3/12 mr-6">
			<ul class="text-sm">
				@foreach($repair_order->operations as $operation)
					<li class="py-2">{{ $operation->name }}</li>
				@endforeach
			</ul>
		</div>
		<div class="w-full">
			<div class="w-full">
			  <div class="shadow-lg w-full bg-gray-300">
			    <div class="bg-blue-800 text-xs leading-none py-1 text-center text-white rounded-full" style="width: 45%">45%</div>
			  </div>
			</div>

			<br><br>

			@component('components.card')
				@slot('title', 'Operación')
				<div>
					{{ $operation->code }}
				</div>
				<div>
					{{ $operation->family->name }}
				</div>
				<div>
					{{ $operation->subfamily->name }}
				</div>
				<div>
					{{ $operation->name }}
				</div>
				<div>
					{{ $operation->description }}
				</div>
				<div>
					{{ $operation->time_in_hours }}
				</div>
			@endcomponent

			@component('components.card')
				@slot('title', 'Execute')
				
				{!! Form::open([
					'route' => ['garage.execute.operation', $repair_order, $operation],
					'files' => true,
					'method' => 'POST',
					'class' => 'w-full dropzone'
				]) !!}	

				<div class="flex flex-wrap -mx-3 mb-6">
					<div class="w-full md:w-3/12 px-3 mb-6 md:mb-3">
						<label class="form-label">
							Tiempo invertido (h)
						</label>
						{!! Form::number('real_time_in_hours', $operation->time_in_hours, ['class' => 'form-input', 'step' => '0.1']) !!}
					</div>
					<div class="w-full md:w-9/12 px-3 mb-6 md:mb-3">
						<label class="form-label">
							Observaciones
						</label>
						{!! Form::textarea('observations', null, ['class' => 'form-input', 'step' => '0.01']) !!}
					</div>

					<div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
						<label class="form-label">
							Archivo
						</label>
						{!! Form::file('file', ['class' => 'form-input']) !!}
					</div>

				</div>
					
				<div class="flex justify-end">
					<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
				</div>
				{!! Form::close() !!}
			@endcomponent
		</div>
	</div>
@endsection
