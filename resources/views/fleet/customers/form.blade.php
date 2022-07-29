<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Grupo Empresarial') }}
      </label>
        {!! Form::select('enterprise_group_id', $enterprises->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-3/6 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('Nombre') }}
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('CIF') }}
    </label>
    {!! Form::text('cif', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Email notificaciones') }}
    </label>
    {!! Form::email('notifications_email', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Dirección') }}
    </label>
    {!! Form::text('address', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Localidad') }}
    </label>
    {!! Form::text('state', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Provincia') }}
    </label>
    {!! Form::text('province', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Código Postal') }}
    </label>
    {!! Form::text('zip', null, ['class' => 'form-input']) !!}
  </div>
</div>



<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Contacto') }} 1
    </label>
    {!! Form::text('contact1', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Email') }} 1
    </label>
    {!! Form::email('email1', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Teléfono') }} 1
    </label>
    {!! Form::text('phone1', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Contacto') }} 2
    </label>
    {!! Form::text('contact2', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Email') }} 2
    </label>
    {!! Form::email('email2', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Teléfono') }} 2
    </label>
    {!! Form::text('phone2', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Contacto') }} 3
    </label>
    {!! Form::text('contact3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Email') }} 3
    </label>
    {!! Form::email('email3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Teléfono') }} 3
    </label>
    {!! Form::text('phone3', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Contacto') }} 4
    </label>
    {!! Form::text('contact4', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Email') }} 4
    </label>
    {!! Form::email('email4', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6">
    <label class="form-label">
      {{ __('Teléfono') }} 4
    </label>
    {!! Form::text('phone4', null, ['class' => 'form-input']) !!}
  </div>

  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Notas') }}
    </label>
    <x-trix name="notes">
      @if($customer) {{ $customer->notes }} @endif
    </x-trix>
  </div>

  

</div>

