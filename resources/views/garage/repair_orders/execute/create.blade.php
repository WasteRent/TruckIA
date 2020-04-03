{!! Form::open([
	'route' => ['garage.execute.operation', $repair_order, $current_operation],
	'files' => true,
	'method' => 'POST',
	'class' => 'w-full'
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
		
	<div class="flex justify-end">
		<button class="btn-indigo">Finalizar</button>
	</div>

{!! Form::close() !!}