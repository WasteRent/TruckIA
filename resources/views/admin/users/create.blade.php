@extends('layouts.admin')

@section('content')
  
  @component('components.card')
    @slot('title', 'Nuevo Usuario')

      
    {!! Form::open([
      'route' => ['admin.users.store'],
      'method' => 'POST',
      'class' => 'w-full'
    ]) !!}  

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            Nombre
          </label>
          {!! Form::text('name', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            Usuario
          </label>
          {!! Form::text('username', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            Contraseña
          </label>
          {!! Form::text('password', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            Email
          </label>
          {!! Form::email('email', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            Rol
          </label>
          {!! Form::select('role', ['admin' => 'Admin', 'fleet' => 'Flota', 'garage' => 'Taller', 'customer' => 'Cliente'], null, ['class' => 'form-select']) !!} 
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            Activo
          </label>
          {!!  Form::checkbox('is_active', 1, true)  !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            Sólo permisos de lectura
          </label>
          {!!  Form::checkbox('is_readonly', 1)  !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            Relación
          </label>
          {!! Form::select('entity_relation_id',$relation->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
        </div>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">Guardar</button>
      </div>

    {!! Form::close() !!}


  @endcomponent

@endsection

