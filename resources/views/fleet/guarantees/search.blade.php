{!!
	Form::model(request()->all(), [
		'route' => $route,
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    @if(in_array(auth()->user()->job, ['fleet_manager']))
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Usuario')}}</label>
        {!! Form::select('user_id', auth()->user()->fleet->users()->orderBy('name')->get()->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    @endif
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Garantía')}}</label>
      {!! Form::text('guarantee', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
