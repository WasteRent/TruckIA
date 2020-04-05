{!! Form::open([
  'route' => ['fleet.vehicles.files.store', $vehicle],
  'files' => true,
  'method' => 'POST',
  'class' => 'w-full'
]) !!}  

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Descripción
    </label>
    {!! Form::text('description', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Fichero
    </label>
    {!! Form::file('file', ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex justify-end">
  <button class="btn-indigo">Guardar</button>
</div>

{!! Form::close() !!}