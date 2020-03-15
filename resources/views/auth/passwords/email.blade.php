@extends('layouts.auth')

@section('content')
<div class=" max-w-md mx-auto">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-16" method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="max-w-xs mx-auto">

            <img class="mx-auto h-12 w-auto" src="https://truckts.com/img/logos/truckts_logo.png" alt="truckts-logo" />
            <h2 class="mt-6 mb-3 text-center text-xl leading-9 font-bold text-gray-800">{{ __('Recuperar contraseña') }}</h2>
            @if (session('status'))
            <div class="text-green-truckts text-xs italic" role="alert">
                <strong> {{ session('status') }}</strong>
            </div>
            @endif
            <div class="">
                <input placeholder="Email" id="email" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5  @error('email') border-red-500 @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            @error('email')
            <p class="text-red-500 text-xs italic mt-1" role="alert">
                <strong>{{ $message }}</strong>
            </p>
            @enderror
            <div class="mt-6">
                <button class="group w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-green-truckts hover:bg-green-trucktslighter focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-truckts transition duration-150 ease-in-out" type="submit">
                    {{ __('Recuperar contraseña') }}
                </button>
            </div>
        </div>
    </form>
</div>
<div>
    <p class="text-center text-gray-500 text-xs">
        &copy;2020 TruckTs. All rights reserved.
    </p>
</div>

@endsection