<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Categoría
      </label>
        {!! Form::select('category', ['chassis' => 'Chasis', 'equipment' => 'Equipo', 'sweeper' => 'Barredora', 'elevator' => 'Elevador'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>
</div>
