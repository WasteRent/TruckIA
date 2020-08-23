{!! 
	Form::model(count(request()->all()) > 0 ? request()->all() : session('filters'), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      	<label class="form-label">Nombre</label>
    	{!! Form::text('name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Marca
      </label>
        {!! Form::select('manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('manufacturer_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Modelo
      </label>
        {!! Form::select('model_id', $models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Tipo
      </label>
        {!! Form::select('type', ['periodic' => 'Periódico', 'one-time' => 'Sólo una vez'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    <div>
        <button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>

        <a href="{{ route('admin.maintenance-plans.stats') }}">
          <i class="far fa-chart-bar fa-lg ml-3 text-gray-600"></i>
        </a>

    </div>
{!! Form::close() !!}
