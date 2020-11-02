<div class="flex flex-wrap -mx-3 mb-6">
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
    <div class="w-full md:w-3/6 px-3 mb-6 md:mb-0">
      <label class="form-label">
        CONTACTO 1
      </label>
      {!! Form::text('contact1', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="form-label">
        EMAIL 1
      </label>
      {!! Form::text('email1', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="form-label">
        TELÉFONO 1
      </label>
      {!! Form::text('phone1', null, ['class' => 'form-input']) !!}
    </div>
    
  </div>
  
  