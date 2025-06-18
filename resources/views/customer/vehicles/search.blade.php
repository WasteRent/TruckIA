{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      <label class="form-label">
        ID
      </label>
        {!! Form::text('id', null, ['placeholder' => 'Ej: 1', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      	<label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Marca
      </label>
        {!! Form::select('chassis_maker_id', $manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Modelo
      </label>
        {!! Form::select('chassis_model_id', $models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div>
        <button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
