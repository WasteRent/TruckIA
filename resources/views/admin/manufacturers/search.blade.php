{!! 
	Form::model(request()->all(), [
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        Categoría
      </label>
      {!! Form::select('category', ['chassis' => 'Chasis', 'equipment' => 'Equipo', 'sweeper' => 'Barredora'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    <div class="text-right">
        <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
