<div class="flex flex-wrap -mx-3 mb-2">
	<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  <label class="form-label" >
	    {{ __('Tipo') }}
	  </label>
	  {!! Form::select('line_type[]', ['work' => __('M.O.'), 'part' => __('Recambio')], 'work', ['class' => 'form-select']) !!}
	</div>
  <div class="w-full md:w-8/12 px-3 mb-6 md:mb-0">
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
</div>