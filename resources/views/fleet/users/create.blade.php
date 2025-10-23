@extends('layouts.fleet')

@section('content')
  
  @component('components.card')
    @slot('title', __('Nuevo Usuario'))

      
    {!! Form::open([
      'route' => ['fleet.users.store'],
      'method' => 'POST',
      'class' => 'w-full'
    ]) !!}  

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Nombre') }}
          </label>
          {!! Form::text('name', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Usuario') }}
          </label>
          {!! Form::text('username', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Contraseña') }}
          </label>
          {!! Form::text('password', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Email') }}
          </label>
          {!! Form::text('email', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Trabajo') }}
          </label>
          {!! Form::select('job', ['garage_boss' => 'Jefe de taller', 'capataz' => 'Capataz', 'mechanic' => 'Mecánico', 'fleet_manager' => 'Gestor de flota', 'driver' => 'Conductor', 'garage' => 'Taller', 'vehicle_washing' => 'Lavado', 'contract_manager' => 'Gestor de contratos'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 my-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Horario de acceso') }}
          </label>
          {!! Form::text('allowed_schedule', null, ['class' => 'form-input', 'placeholder' => '09:00-18:00']) !!}
        </div>

        <div class="w-full md:w-1/5 px-3 mt-8 md:mb-0">
          <label class="form-label">
            {{ __('Activo') }}
          </label>
          {!!  Form::checkbox('is_active', 1, true)  !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mt-8 md:mb-0">
          <label class="form-label">
            {{ __('Sólo permisos de lectura') }}
          </label>
          {!!  Form::checkbox('is_readonly', 1)  !!}
        </div>

      </div>

      <div class="my-6">
        <strong>Clientes permitidos</strong>
        <button type="button" class="btn-indigo" onclick="toggleAllCheckboxes()" id="toggleButton">Seleccionar todos</button>
        <ul class="ml-2 mt-2">
        @foreach(\App\Models\Customer::where('fleet_id', Auth::user()->fleet->id)->orderBy('name')->get() as $customer)
          <li class="flex items-center">
            <input class="customer-checkbox mr-2" type="checkbox" name="allowed_customer_id[]" value="{{ $customer->id }}" checked> {{ $customer->name }}
          </li>
        @endforeach
        </ul>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">Guardar</button>
      </div>

    {!! Form::close() !!}


  @endcomponent

@endsection

@push('js')
<script>
let allChecked = true;  // Initial state since checkboxes start checked

function toggleAllCheckboxes() {
    const checkboxes = document.getElementsByClassName('customer-checkbox');
    const button = document.getElementById('toggleButton');
    
    allChecked = !allChecked;  // Toggle the state
    
    Array.from(checkboxes).forEach(checkbox => {
        checkbox.checked = allChecked;
    });
    
    button.textContent = allChecked ? 'Deseleccionar todos' : 'Seleccionar todos';
}
</script>
@endpush

