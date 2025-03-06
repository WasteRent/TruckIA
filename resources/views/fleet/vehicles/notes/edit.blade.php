@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')
    <div class="flex justify-between mb-4">
        <strong>{{ __('Editar nota') }}</strong>
    </div>
    <form action="{{ route('fleet.vehicles.notes.update', [$vehicle, $note]) }}" method="post">
        @csrf
        @method('put')
        <x-trix name="note">
            {!! $note->note !!}
        </x-trix>
        <div class="flex justify-end">
            <button type="submit" class="btn-indigo mt-4">{{ __('Actualizar') }}</button>
        </div>
    </form>
@endsection
