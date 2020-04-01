{!! Form::open([
  'route' => ['admin.vehicles.equipments.store', $vehicle],
  'method' => 'POST',
  'class' => 'w-full'
]) !!}  


  @include('admin.vehicles.equipments.form')

  <div class="flex justify-end">
    <button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
  </div>

{!! Form::close() !!}