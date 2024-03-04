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
          {!! Form::select('job', ['mechanic' => 'Mecánico', 'fleet_manager' => 'Gestor de flota', 'driver' => 'Conductor'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Horario de acceso') }}
          </label>
          {!! Form::text('allowed_schedule', null, ['class' => 'form-input']) !!}
        </div>
      </div>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            {{ __('Activo') }}
          </label>
          {!!  Form::checkbox('is_active', 1, true)  !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            {{ __('Sólo permisos de lectura') }}
          </label>
          {!!  Form::checkbox('is_readonly', 1)  !!}
        </div>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">Guardar</button>
      </div>

    {!! Form::close() !!}


  @endcomponent

@endsection

