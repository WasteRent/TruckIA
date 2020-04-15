{!! Form::model($user, [
  'route' => ['fleet.customers.users.update', $customer, $user],
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
    <button class="btn-indigo">Actualizar</button>
  </div>

{!! Form::close() !!}