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
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Ver')}}</label>
        {!! Form::select('dismissed', ['0' => 'Sin leer', '1' => 'Leidas'], null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
