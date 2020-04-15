@extends('layouts.fleet')

@section('content')
  
  @component('components.card')
    @slot('title', 'Editar Usuario')

      
    {!! Form::model($user, [
      'route' => ['fleet.users.update', $user],
      'method' => 'PUT',
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
            Email
          </label>
          {!! Form::email('email', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label">
            Activo
          </label>
          {!!  Form::checkbox('is_active', 1)  !!}
        </div>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">Guardar</button>
      </div>

    {!! Form::close() !!}


  @endcomponent

@endsection

