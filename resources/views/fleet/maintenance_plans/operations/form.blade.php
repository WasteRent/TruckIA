<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input', 'readonly' => auth()->user()->job == 'contract_manager']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Familia
      </label>
        {!! Form::select('family_id', $families->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '', 'onchange' => "ajaxSelect('family_id', 'subfamily_id', '/api/family/{id}/subfamilies')", 'disabled' => auth()->user()->job == 'contract_manager']) !!}
        @if(auth()->user()->job == 'contract_manager')
          {!! Form::hidden('family_id', old('family_id', optional($operation ?? null)->family_id)) !!}
        @endif
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Subfamilia
      </label>
        {!! Form::select('subfamily_id', $subfamilies->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '', 'disabled' => auth()->user()->job == 'contract_manager']) !!}
        @if(auth()->user()->job == 'contract_manager')
          {!! Form::hidden('subfamily_id', old('subfamily_id', optional($operation ?? null)->subfamily_id)) !!}
        @endif
  </div>
  
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Tiempo (hrs)
    </label>
    {!! Form::number('time_in_hours', null, ['class' => 'form-input', 'step' => '0.1', 'readonly' => auth()->user()->job == 'contract_manager']) !!}
  </div>

  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    @if(isset($operation) && $operation->attachment)
      <img src="{{ $operation->attachment->getLink() }}">
      <a href="{{ route('fleet.maintenance-plans.operations.removeImage', [$plan, $operation]) }}" class="text-red-700 btn-outline-red">
        <i class="fas fa-trash-alt"></i>
        <span class="ml-2">Borrar</span>
      </a>      
    @else
      <label class="form-label">
        Adjunto
      </label>
      {!! Form::file('attachment', ['class' => 'form-input']) !!}
    @endif
  </div> 
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-full px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Descripción
    </label>
    {!! Form::textarea('description', null, ['class' => 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500', 'readonly' => auth()->user()->job == 'contract_manager']) !!}
  </div>
</div>