<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Fecha y Hora') }}
    </label>
    {!! Form::text('datetime', null, ['class' => 'form-input datetimepicker']) !!}
  </div>
  <div class="w-full md:w-5/6 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Asunto') }}
    </label>
    {!! Form::text('title', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">{{ __('Descripción') }}</label>
    <x-trix name="description"></x-trix>
  </div>
</div>

