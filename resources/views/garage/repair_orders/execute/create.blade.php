{!! Form::open([
	'route' => ['garage.execute.operation', $repair_order, $current_operation],
	'files' => true,
	'method' => 'POST',
	'class' => 'w-full'
]) !!}
	
	<div class="flex">
		<div class="w-1/2">
			<div class="w-full lg:px-3 lg:mb-0 mb-3">
				<label class="form-label">
					Observaciones
				</label>
				{!! Form::textarea('garage_observations', null, ['class' => 'form-input h-32', 'step' => '0.01']) !!}
			</div>
		</div>
		<div class="w-1/2">
			<div class="w-full mb-3">
				<label class="form-label">
					Tiempo invertido (h)
				</label>
				{!! Form::number('real_time_in_hours', $current_operation->estimated_time_in_hours, ['class' => 'form-input', 'step' => 'any']) !!}
			</div>
			<div class="w-full my-3">
				<label class="form-label">
					Archivo
				</label>
				{!! Form::file('file', ['class' => 'form-input']) !!}
			</div>
		</div>
	</div>

		
	<div class="flex justify-end">
		<button class="btn-indigo">Finalizar</button>
	</div>

{!! Form::close() !!}