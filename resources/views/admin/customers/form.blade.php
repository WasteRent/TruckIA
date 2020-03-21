<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Grupo Empresarial
      </label>
      <div class="relative">
        {!! Form::select('enterprise_group_id', $enterprises->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
  </div>
  <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
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

