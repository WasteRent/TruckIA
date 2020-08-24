<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Grupo Empresarial
      </label>
        {!! Form::select('enterprise_group_id', $enterprises->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email notificaciones
    </label>
    {!! Form::email('notifications_email', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Dirección
    </label>
    {!! Form::text('address', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Localidad
    </label>
    {!! Form::text('state', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Provincia
    </label>
    {!! Form::text('province', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Código Postal
    </label>
    {!! Form::text('zip', null, ['class' => 'form-input']) !!}
  </div>
</div>



<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Contacto 1
    </label>
    {!! Form::text('contact1', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email 1
    </label>
    {!! Form::email('email1', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Teléfono 1
    </label>
    {!! Form::text('phone1', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Contacto 2
    </label>
    {!! Form::text('contact2', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email 2
    </label>
    {!! Form::email('email2', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Teléfono 2
    </label>
    {!! Form::text('phone2', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Contacto 3
    </label>
    {!! Form::text('contact3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email 3
    </label>
    {!! Form::email('email3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Teléfono 3
    </label>
    {!! Form::text('phone3', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Contacto 4
    </label>
    {!! Form::text('contact4', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Email 4
    </label>
    {!! Form::email('email4', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Teléfono 4
    </label>
    {!! Form::text('phone4', null, ['class' => 'form-input']) !!}
  </div>
</div>

