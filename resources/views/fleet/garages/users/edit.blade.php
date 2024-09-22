{!! Form::model($user, [
  'route' => ['fleet.garage.users.update', $garage, $user],
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

  @if(auth()->user()->fleet->id == 30)
  <div class="my-6">
    <strong>Clientes permitidos</strong>
    <div class="grid grid-cols-4">
    @foreach(\App\Models\Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->get() as $customer)
        <div>
        <input class="ml-2" type="checkbox" name="allowed_customer_id[]" value="{{ $customer->id }}" @if($user->allowedCustomers->contains($customer)) checked @endif> {{ $customer->name }}
        </div>
    @endforeach
    </div>
  </div>
  @endif

  <div class="flex justify-end">
    <button class="btn-indigo">Actualizar</button>
  </div>

{!! Form::close() !!}