{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <input type="hidden" name="filter" value="{{ request()->query('filter') }}"> 

    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Tipo')}}</label>
        {!! Form::select('type_id', $types->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    <div class="text-right">
        <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
