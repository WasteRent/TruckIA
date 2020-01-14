{!! 
	Form::model(request()->all(), [
		'route' => ['admin.operations.spare-parts.search', $operation], 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      	<label class="form-label">Referencia</label>
    	{!! Form::text('reference', null, ['placeholder' => 'Ej: 123', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      	<label class="form-label">Descripción</label>
    	{!! Form::text('description', null, ['placeholder' => 'Ej: Cambiar filtro de aire', 'class' => 'form-input']) !!}
    </div>
    <div>
        <button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
