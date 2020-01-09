{!! 
	Form::model(request()->all(), [
		'route' => 'admin.operations.index', 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      	<label class="form-label">Código</label>
    	{!! Form::text('code', null, ['placeholder' => 'Ej: 123', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      	<label class="form-label">Nombre</label>
    	{!! Form::text('name', null, ['placeholder' => 'Ej: Cambiar filtro de aire', 'class' => 'form-input']) !!}
    </div>
    <div>
    	<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
    </div>
{!! Form::close() !!}
