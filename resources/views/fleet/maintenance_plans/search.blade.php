{!!
	Form::model(count(request()->all()) > 0 ? request()->all() : session('filters'), [
		'route' => $route,
		'method' => 'GET',
		'class' => ['flex items-end']
	])
!!}
    <div class="px-2">
      <label class="form-label">ID</label>
      {!! Form::text('id', null, ['class' => 'form-input']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">Nombre</label>
      {!! Form::text('name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">
        Marca
      </label>
        {!! Form::select('manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('manufacturer_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="px-2">
      <label class="form-label">
        Modelo
      </label>
        {!! Form::select('model_id', $models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('model_id', 'version_id', '/api/models/{id}/versions')"]) !!}
    </div>
    <div class="px-2">
      <label class="form-label whitespace-nowrap">
        Den. comercial
      </label>
        {!! Form::select('version_id', $versions->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">Euro</label>
      {!! Form::select('euro', [
        '' => '',
        'EuroVI' => 'EuroVI',
        'EuroV' => 'EuroV',
        'EuroIV' => 'EuroIV',
        'EuroIII' => 'EuroIII',
        'EuroII' => 'EuroII'
      ], null, ['class' => 'form-select']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">
        Tipo
      </label>
        {!! Form::select('type', ['periodic' => 'Periódico', 'one-time' => 'Sólo una vez'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">
        Agrupar por caracteres
      </label>
        {!! Form::select('group_chars', [
          '' => 'Sin agrupar',
          '10' => '10 caracteres',
          '15' => '15 caracteres',
          '20' => '20 caracteres',
          '25' => '25 caracteres',
          '30' => '30 caracteres'
        ], request('group_chars', '20'), ['class' => 'form-select']) !!}
    </div>
    <div class="px-2">
      <label class="form-label">
        Ordenar por ID
      </label>
        {!! Form::select('order_by_id', [
          'desc' => 'Descendente',
          'asc' => 'Ascendente'
        ], request('order_by_id', 'desc'), ['class' => 'form-select']) !!}
    </div>
    <div class="px-2 flex items-center gap-3">
      <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-search"></i>
      </button>
      <a href="{{ route('admin.maintenance-plans.stats') }}">
        <i class="far fa-chart-bar fa-lg text-gray-600"></i>
      </a>
    </div>
{!! Form::close() !!}
