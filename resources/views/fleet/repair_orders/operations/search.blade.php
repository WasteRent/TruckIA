{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="w-1/6 mr-4">
      <label class="form-label">Familia</label>
      {!! Form::select('family_id', $families->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '', 'id' => 'family_id_input']) !!}
    </div>
    <div class="w-1/3">
      <label class="form-label">Nombre</label>
    	{!! Form::text('name', null, ['placeholder' => 'Ej: Cambiar filtro de aire', 'id' => 'operation_input', 'class' => 'form-input']) !!}
    </div>
    <div>
        <button class="btn-search ml-2">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
