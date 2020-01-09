<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
      Código
    </label>
    {!! Form::text('code', null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Tipo Vehículo
      </label>
      <div class="relative">
        {!! Form::select('vehicle_type', ['General' => 'General','Barredora' => 'Barredora','Caja' => 'Caja','Chasis' => 'Chasis','Otro' => 'Otro'], null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Familia
      </label>
      <div class="relative">
        {!! Form::select('family_id', $families->pluck('name', 'id'), null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        Subfamilia
      </label>
      <div class="relative">
        {!! Form::select('subfamily_id', $families->pluck('name', 'id'), null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
      Tiempo (hrs)
    </label>
    {!! Form::number('time_in_hours', null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500', 'step' => '0.1']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-full px-3 mb-6 md:mb-0">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
      Descripción
    </label>
    {!! Form::textarea('description', null, ['class' => 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
  </div>
</div>