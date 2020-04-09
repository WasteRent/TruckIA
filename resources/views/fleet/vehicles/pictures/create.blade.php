{!! Form::open([
  'route' => ['fleet.vehicles.pictures.store', $vehicle],
  'files' => true,
  'method' => 'POST',
  'class' => 'w-full'
]) !!}  

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Fichero
    </label>
<!--     <div class="file-container">
      <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg> -->
      {!! Form::file('file', ['class' => 'form-input']) !!}
<!--     </div>
 -->  </div>
</div>

<div class="flex justify-end">
  <button class="btn-indigo">Guardar</button>
</div>

{!! Form::close() !!}