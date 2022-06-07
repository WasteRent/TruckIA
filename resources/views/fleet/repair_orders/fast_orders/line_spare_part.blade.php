<div class="form-line flex flex-wrap items-center -mx-3 mb-2">
  <input type="hidden" name="line_type[]" value="spare-part">
  <input type="hidden" name="line_time[]" value="">

  <div class="w-full md:w-1/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Cantidad') }}
    </label>
    {!! Form::number('line_quantity[]', 1, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Marca') }}
    </label>
    {!! Form::text('line_manufacturer[]', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Referencia') }}
    </label>
    {!! Form::text('line_reference[]', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Descripción') }}
    </label>
    {!! Form::text('line_description[]', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Importe') }}
    </label>
    {!! Form::number('line_amount[]', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
  <i class="mt-6 fas fa-times remove-fast-order-line text-red-700 cursor-pointer"></i>
</div>
