{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      <label class="form-label">Nombre</label>
    	{!! Form::text('name', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Cliente
      </label>
        {!! Form::select('enterprise_group_id', $enterprises->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div>
        <button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
