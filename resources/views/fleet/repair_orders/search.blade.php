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
    	{!! Form::text('id', null, ['placeholder' => 'Ej: 123', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      	<label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Taller') }}
      </label>
        {!! Form::select('garage_id', App\Models\Garage::where('fleet_id', Auth::user()->fleet->id)->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Fecha desde') }}
      </label>
      {!! Form::text('date_from', null, ['class' => 'datepicker form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Fecha hasta') }}
      </label>
      {!! Form::text('date_to', null, ['class' => 'datepicker form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Mecánico') }}
      </label>
      @php
        $users = auth()->user()->fleet->garages->pluck('users')->flatten();
      @endphp
      {!! Form::select('assigned_user_id', auth()->user()->fleet->users()->where('job', 'mechanic')->get()->merge($users)->sortBy('name')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    <div class="text-right">
    	<button class="btn-search">
        <i class="fas fa-search"></i>
      </button>
    </div>
{!! Form::close() !!}
