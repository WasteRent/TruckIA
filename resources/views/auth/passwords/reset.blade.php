@extends('layouts.auth')

@section('content')
<div class=" max-w-md mx-auto">

    {{ $errors }}

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-16" method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="max-w-xs mx-auto">

            <img class="mx-auto h-12 w-auto" src="https://truckts.com/img/logos/truckts_logo.png" alt="truckts-logo" />
            <h2 class="mt-6 mb-3 text-center text-xl leading-9 font-bold text-gray-800 ">
                {{ __('Cambiar contraseña') }}</h2>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email
                "> Email</label>
                <input placeholder="Email" id="email" type="email" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 mt-3" for="password"> Escriba una contraseña</label>
                <input placeholder="Nueva contraseña" id="password" type="password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 mt-3" for="password-confirm"> Repita la contraseña</label>
                <input placeholder="Repita la contraseña" id="password-confirm" type="password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 @error('password') border-red-500 @enderror" name="password_confirmation" />
            </div>

            @error('email')
            <p class="text-red-500 text-xs italic mt-1" role="alert">
                <strong>{{ $message }}</strong>
            </p>
            @enderror
            @error('password')
            <p class="text-red-500 text-xs italic mt-1" role="alert">
                <strong>{{ $message }}</strong>
            </p>
            @enderror
            <div class="mt-6">
                <button type="submit" class="group w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-green-truckts hover:bg-green-trucktslighter focus:outline-none focus:border-green-700 focus:ring-green active:bg-green-truckts transition duration-150 ease-in-out">
                    {{ __('Cambiar contraseña') }}
                </button>
            </div>

        </div>

    </form>
    <div>
        <p class="text-center text-gray-500 text-xs">
            &copy;2020 TruckTs. All rights reserved.
        </p>
    </div>
</div>


@endsection