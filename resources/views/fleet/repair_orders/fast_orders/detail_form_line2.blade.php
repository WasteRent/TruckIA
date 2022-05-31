<div class="form-line flex flex-wrap -mx-3 mb-2">
	<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  {!! Form::select('line_type[]', ['work' => __('M.O.'), 'part' => __('Recambio')], 'work', ['class' => 'form-select']) !!}
	</div>
  <div class="w-full md:w-1/12 px-3 mb-6 md:mb-0">
    {!! Form::number('line_part_quantity[]', 1, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    {!! Form::text('line_part_reference[]', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
    {!! Form::text('line_description[]', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/12 px-3 mb-6 md:mb-0">
    {!! Form::number('line_amount[]', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
</div>