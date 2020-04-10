{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <input type="hidden" name="filter" value="{{ request()->query('filter') }}"> 

    <div class="px-3">
      <label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Tipo
      </label>
        {!! Form::select('type_id', $types->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    <div>
        <button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
