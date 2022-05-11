{!! 
	Form::model(request()->all(), [
		'route' => ['fleet.vehicles.show',$vehicle->id], 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <input type="hidden" name="type" value="{{ request()->query('type') }}"> 

    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
    	<button class="btn-search">
        <i class="fas fa-search"></i>
      </button>
    </div>
{!! Form::close() !!}
