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
        {!! Form::select('garage_id',App\Models\Garage::allowForUser()->orderBy('name')->pluck('name', 'id')->prepend('', ''), null, ['class' => 'garage-select']) !!}
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
    @if(in_array(auth()->user()->job, ['fleet_manager']))
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Mecánico') }}
      </label>
      @php
        $users = auth()->user()->fleet->garages->pluck('users')->flatten();
      @endphp
      {!! Form::select('assigned_user_id', auth()->user()->fleet->users()->where('job', 'mechanic')->get()->merge($users)->sortBy('name')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    @endif
    <div class="text-right">
    	<button class="btn-search">
        <i class="fas fa-search"></i>
      </button>
    </div>
{!! Form::close() !!}

@push('head')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<style>
.ts-control {
    min-height: 2.5rem;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background-color: #fff;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
    box-shadow: none;
    font-family: inherit;
    width: 150px;
    height: 38px;
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script type="text/javascript">
  new TomSelect('.garage-select', {
    allowEmptyOption: true,
    maxOptions: 500,
    create: false,
    maxItems: 1,
    hideSelected: true 
  });
</script>
@endpush
