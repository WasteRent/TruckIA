{!! 
	Form::model(request()->all(), [
		'route' => 'fleet.repair-orders.index', 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <input type="hidden" name="type" value="{{ request()->query('type') }}"> 

    <div class="lg:px-3 lg:mb-0 mb-3">
      	<label class="form-label">ID</label>
    	{!! Form::number('id', null, ['placeholder' => 'Ej: 123', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      	<label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        Estado
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
    	<button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-search"></i>
      </button>
    </div>
{!! Form::close() !!}
