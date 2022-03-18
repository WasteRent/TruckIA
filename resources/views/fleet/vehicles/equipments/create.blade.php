{!! Form::open([
  'route' => ['fleet.vehicles.equipments.store', $vehicle],
  'method' => 'POST',
  'files' => true,
  'class' => 'w-full'
]) !!}  


  @include('fleet.vehicles.equipments.form')

  <div class="flex justify-end">
    <button class="btn-indigo">{{ __('Guardar') }}</button>
  </div>

{!! Form::close() !!}