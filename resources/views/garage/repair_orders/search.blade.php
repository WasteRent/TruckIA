{!! 
	Form::model(request()->all(), [
		'route' => 'garage.repair-orders.index', 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="px-3">
      	<label class="form-label">ID</label>
    	{!! Form::number('id', null, ['placeholder' => 'Ej: 123', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      	<label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="px-3">
      <label class="form-label">
        Estado
      </label>
      <div class="relative">
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div>
    	<button class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
