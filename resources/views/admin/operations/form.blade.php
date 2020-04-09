<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Código
    </label>
    {!! Form::text('code', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Tipo Vehículo
      </label>
        {!! Form::select('vehicle_type', ['General' => 'General','Barredora' => 'Barredora','Caja' => 'Caja','Chasis' => 'Chasis','Otro' => 'Otro'], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Familia
      </label>
        {!! Form::select('family_id', $families->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '', 'onchange' => "ajaxSelect('family_id', 'subfamily_id', '/api/family/{id}/subfamilies')"]) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Subfamilia
      </label>
        {!! Form::select('subfamily_id', $subfamilies->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Tiempo (hrs)
    </label>
    {!! Form::number('time_in_hours', null, ['class' => 'form-input', 'step' => '0.1']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-full px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Descripción
    </label>
    {!! Form::textarea('description', null, ['class' => 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
  </div>
</div>
