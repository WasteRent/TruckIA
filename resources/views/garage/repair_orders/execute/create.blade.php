{!! Form::model($current_operation, [
	'route' => ['garage.execute.operation', $repair_order, $current_operation],
	'files' => true,
	'method' => 'POST',
	'class' => 'w-full'
]) !!}
	
	<div class="flex justify-between">
		<div class="">
			<label class="form-label">
				Observaciones
			</label>
			<x-trix class="mb-8" name="garage_observations_{{$current_operation->id}}">
				{{ $current_operation->garage_observations }}
			</x-trix>
		</div>
		<div class="">
			<label class="form-label">
				Tiempo invertido (h)
			</label>
			{!! Form::number('hours_spent', null, ['class' => 'form-input', 'step' => 'any']) !!}
		</div>
	</div>

	<div class="flex justify-end">
		<button class="btn-indigo">Finalizar</button>
	</div>

{!! Form::close() !!}