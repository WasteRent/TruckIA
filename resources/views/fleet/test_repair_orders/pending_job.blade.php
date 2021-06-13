@extends('layouts.fleet')

@section('title', 'Trabajo Pendiente')

@section('content')
    @component('components.card', ['is_table' => true])
		
    <div class="container mt-2">
        {!! Form::open([
        'route' => ['fleet.garages.store'],
        'method' => 'POST',
        'class' => 'w-full'
        ]) !!}	
            @include('fleet.test_repair_orders.search')
        {!! Form::close() !!}

        {{-- Aquí tendremos las OR que estén sin completar y asignadas por el típo de usuario que sea --}}
        <table>
            <thead>
              <tr>
                <th class="hidden sm:table-cell">ID</th>
                <th>MATRÍCULA</th>
                <th>CHASIS</th>
                <th>EQUIPO</th>
                <th>PREV/CORR</th>
                <th>TALLER/TÉCNICO</th>
                <th>CLIENTE</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <tr>
                 <td>2</td>
                 <td>0546ALT</td>
                 <td>Iveco Stralis A260 GNC (Caja Allison)</td>
                 <td>Hiab X-HiPro 408</td>
                 <td>CORRECTIVO</td>
                 <td>TALLER</td>
                 <td>Ismael</td>
                 <td><a href="{{ route('fleet.test-repair-orders.factura-pendiente', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
            </tbody>
        </table>
    </div>
    @endcomponent
@endsection