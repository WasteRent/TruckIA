@extends('layouts.fleet')

@section('title', 'Talleres')

@section('content')

    @include('fleet.garages.tabs', ['active_customers' => true])

    @component('components.card')

    {!! Form::model($customers, [
        'route' => ['fleet.garage.customers.edit', [$garage, $customers]],
        'method' => 'PUT',
        'class' => 'w-full'
    ]) !!}	

    @include('fleet.garages.customers.form')

    <div class="flex justify-end">
        <button class="btn-indigo">Guardar</button>
    </div>
    {!! Form::close() !!}
    
    @endcomponent
    
@endsection
