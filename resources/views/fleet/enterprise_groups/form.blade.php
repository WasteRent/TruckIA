<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6">
    <label class="form-label form-required">
      {{ __('Nombre') }}
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6">
    <label class="form-label">
      {{ __('Contacto') }}
    </label>
    {!! Form::text('contact', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6">
    <label class="form-label">
      {{ __('Email') }}
    </label>
    {!! Form::email('email', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6">
    <label class="form-label">
      {{ __('Teléfono') }}
    </label>
    {!! Form::text('phone', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full px-3">
    <label class="form-label">
      {{ __('Dirección') }}
    </label>
    {!! Form::text('address', null, ['class' => 'form-input']) !!}
  </div>
</div>
