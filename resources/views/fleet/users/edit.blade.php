@extends('layouts.fleet')

@section('content')
  
  @component('components.card')
    @slot('title', __('Editar usuario'))

      
    {!! Form::model($user, [
      'route' => ['fleet.users.update', $user],
      'method' => 'PUT',
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
          {!! Form::password('password',array('placeholder'=>'Contraseña','class' => 'insi form-input')) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Repita la contraseña') }}
          </label>
          {!! Form::password('password_confirmation',array('placeholder'=>'Repita la contraseña','class' => 'insi form-input')) !!}

        </div>


        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Email') }}
          </label>
          {!! Form::text('email', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 my-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Trabajo') }}
          </label>
          {!! Form::select('job', ['garage_boss' => 'Jefe de taller','capataz' => 'Capataz', 'mechanic' => 'Mecánico', 'fleet_manager' => 'Gestor de flota', 'driver' => 'Conductor', 'garage' => 'Taller', 'vehicle_washing' => 'Lavado', 'contract_manager' => 'Asistente de Mantenimiento'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
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
          {!!  Form::checkbox('is_active', 1)  !!}
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
        @foreach(\App\Models\Customer::where('fleet_id', $user->fleet->id)->orderBy('name')->get() as $customer)
          <li class="flex items-center">
            <input class="customer-checkbox mr-2" type="checkbox" name="allowed_customer_id[]" value="{{ $customer->id }}" @if($user->allowedCustomers->contains($customer)) checked @endif> {{ $customer->name }}
          </li>
        @endforeach
        </ul>
      </div>

      @if(in_array(auth()->user()->fleet->id, [1, 6]))
        <label class="form-label">Flotas permitidas</label>
        <input type="checkbox" name="user_fleets[1]" @if($user->allowedFleets->contains(1) || $user->entity_relation_id == 1) checked @endif> Wasterent
        <input class="ml-4" type="checkbox" name="user_fleets[6]" @if($user->allowedFleets->contains(6) || $user->entity_relation_id == 6) checked @endif> Sivu
      @endif

      <div class="flex justify-end">
        <button class="btn-indigo">{{ __('Guardar') }}</button>
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
