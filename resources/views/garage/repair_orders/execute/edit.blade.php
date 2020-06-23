{!! Form::model($current_operation, [
	'route' => ['garage.execute.operation', $repair_order, $current_operation],
	'files' => true,
	'method' => 'POST',
	'class' => 'w-full'
]) !!}	
	<div class="flex flex-wrap -mx-3 mb-6">
		<div class="w-full md:w-6/12 lg:px-3 lg:mb-0 mb-3">
			<label class="form-label">
				Tiempo invertido (h)
			</label>
			{!! Form::number('real_time_in_hours', $current_operation->estimated_time_in_hours, ['class' => 'form-input', 'step' => '0.1']) !!}
		</div>
		<div class="w-full md:w-6/12 lg:px-3 lg:mb-0 mb-3">
			<label class="form-label">
				Archivo
			</label>
			{!! Form::file('file', ['class' => 'form-input']) !!}
		</div>
	</div>
	<div class="flex flex-wrap -mx-3 mb-6">
		<div class="w-full lg:px-3 lg:mb-0 mb-3">
			<label class="form-label">
				Observaciones
			</label>
			{!! Form::textarea('garage_observations', null, ['class' => 'form-input h-16', 'step' => '0.01']) !!}
		</div>
	</div>
		
	<div class="flex justify-end">
		<button class="btn-indigo">Actualizar</button>
	</div>
{!! Form::close() !!}