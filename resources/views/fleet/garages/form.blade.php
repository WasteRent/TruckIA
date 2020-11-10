<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      CIF
    </label>
    {!! Form::text('cif', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email notificaciones
    </label>
    {!! Form::email('notifications_email', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Gestor
    </label>
    {!!  Form::checkbox('is_manager', 1)  !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Precio M.O
    </label>
    {!! Form::number('hourly_price', null, ['class' => 'form-input', 'step' => 'any']) !!}
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
        {!! Form::select('official_service1_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '','class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 2
      </label>
        {!! Form::select('official_service2_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '','class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 3
      </label>
        {!! Form::select('official_service3_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '','class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 4
      </label>
        {!! Form::select('official_service4_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '','class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Serv. Oficial 5
      </label>
        {!! Form::select('official_service5_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '','class' => 'form-select']) !!}
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

