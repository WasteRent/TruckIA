<div class="form-line flex flex-wrap items-center -mx-3 mb-2">
  <input type="hidden" name="line_type[]" value="work-time">
  <input type="hidden" name="line_quantity[]" value="">
  <input type="hidden" name="line_reference[]" value="">
  <input type="hidden" name="line_manufacturer[]" value="">
  <input type="hidden" name="operation_code[]" value="DES">


  <div class="w-full md:w-1/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Horas') }}
    </label>
    {!! Form::number('line_time[]', 1, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
  <div class="w-full md:w-8/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Descripción') }}
    </label>
    {!! Form::textarea('line_description[]', null, ['class' => 'form-input', 'rows' => 3]) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Importe') }}
    </label>
    {!! Form::number('line_amount[]', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
  <i class="mt-6 fas fa-times remove-fast-order-line text-red-700 cursor-pointer"></i>
</div>
