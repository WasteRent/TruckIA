<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Precio M.O
    </label>
    {!! Form::number('hourly_price', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Horario de apertura
    </label>
    {!! Form::text('opening_hours', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Web
    </label>
    {!! Form::text('web', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Dirección
    </label>
    {!! Form::text('address', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Localidad
    </label>
    {!! Form::text('state', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Provincia
    </label>
    {!! Form::text('province', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Código Postal
    </label>
    {!! Form::text('zip', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Latitud
    </label>
    {!! Form::text('latitude', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Longitud
    </label>
    {!! Form::text('longitude', null, ['class' => 'form-input']) !!}
  </div>
</div>

<hr class="my-10">

<div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 1
      </label>
      <div class="relative">
        {!! Form::select('official_service1_manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 2
      </label>
      <div class="relative">
        {!! Form::select('official_service2_manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 3
      </label>
      <div class="relative">
        {!! Form::select('official_service3_manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 4
      </label>
      <div class="relative">
        {!! Form::select('official_service4_manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 5
      </label>
      <div class="relative">
        {!! Form::select('official_service5_manufacturer_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
  </div>
  
</div>

<hr class="my-10">

<div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Persona de contacto
      </label>
      {!! Form::text('garage_name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Taller Email
      </label>
      {!! Form::email('garage_email', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Taller Teléfono
      </label>
      {!! Form::text('garage_phone', null, ['class' => 'form-input']) !!}
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Persona de contacto
      </label>
      {!! Form::text('management_name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Gerencia Email
      </label>
      {!! Form::email('management_email', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Gerencia Teléfono
      </label>
      {!! Form::text('management_phone', null, ['class' => 'form-input']) !!}
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Persona de contacto
      </label>
      {!! Form::text('administration_name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Administración Email
      </label>
      {!! Form::email('administration_email', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Administración Teléfono
      </label>
      {!! Form::text('administration_phone', null, ['class' => 'form-input']) !!}
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Persona de contacto
      </label>
      {!! Form::text('spare_parts_name', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Recambios Email
      </label>
      {!! Form::email('spare_parts_email', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Recambios Teléfono
      </label>
      {!! Form::text('spare_parts_phone', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</div>

