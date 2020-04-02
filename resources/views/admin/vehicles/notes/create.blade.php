{!! Form::open([
  'route' => ['admin.vehicles.notes.store', $vehicle],
  'method' => 'POST',
  'class' => 'w-full'
]) !!}  

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Descripción
    </label>
    {!! Form::textarea('note', null, ['class' => 'form-input', 'rows' => 3]) !!}
  </div>
</div>

<div class="flex justify-end">
  <button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
</div>

{!! Form::close() !!}