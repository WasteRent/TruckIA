{!! Form::open([
  'route' => ['admin.vehicles.equipments.store', $vehicle],
  'method' => 'POST',
  'class' => 'w-full'
]) !!}  


  @include('admin.vehicles.equipments.form')

  <div class="flex justify-end">
    <button class="btn-indigo">Guardar</button>
  </div>

{!! Form::close() !!}