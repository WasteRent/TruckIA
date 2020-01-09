{!! 
	Form::model(request()->all(), [
		'route' => 'admin.vehicles.index', 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      	<label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div>
    	<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
    </div>
{!! Form::close() !!}
