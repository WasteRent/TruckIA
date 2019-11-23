@extends('layouts.auth')

@section('content')
<br><br><br>

<div class="w-full max-w-xs mx-auto">
  {!! Form::open([
    'route' => ['auth.authenticate'],
    'method' => 'POST',
    'class' => 'bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4'
  ]) !!} 
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2">
        Usuario
      </label>
      {!! Form::text('username', null, ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) !!}
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2">
        Contraseña
      </label>
      {!! Form::password('password', ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) !!}
    </div>
    <div class="flex items-center justify-center">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
        Entrar
      </button>
    </div>
  {!! Form::close() !!}
  <p class="text-center text-gray-500 text-xs">
    &copy;2019 TruckTs. All rights reserved.
  </p>
</div>

@endsection
