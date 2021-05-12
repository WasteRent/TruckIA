@extends('layouts.fleet')

@section('title', 'Ordenes de Reparación')

@section('content')
    @component('components.card', ['is_table' => true])
    
  {!! Form::open([
    'route' => ['fleet.garages.store'],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}	
		@include('fleet.test_repair_orders.search')
	{!! Form::close() !!}

		@slot('corner')
			<a href="{{ route('fleet.test-repair-orders.corrective') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
    {{-- saldrán todas las OR --}}
        <table>
            <thead>
              <tr>
                <th class="hidden sm:table-cell">ID</th>
                <th>MATRÍCULA</th>
                <th>CHASIS</th>
                <th>EQUIPO</th>
                <th>PREVENTIVO/CORRECTIVO</th>
                <th>TALLER/TÉCNICO</th>
                <th>CLIENTE</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>0548HTL</td>
                <td>Iveco Stralis A260 GNC (Caja Allison)</td>
                <td>Faun Variopress 5</td>
                <td>CORRECTIVO</td>
                <td>TÉCNICO</td>
                <td>Ismael</td>
                <td><a href="{{ route('fleet.test-repair-orders.datos-incompletos', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>2</td>
                <td>0546ALT</td>
                <td>Iveco Stralis A260 GNC (Caja Allison)</td>
                <td>Hiab X-HiPro 408</td>
                <td>CORRECTIVO</td>
                <td>TALLER</td>
                <td>Ismael</td>
                <td><a href="{{ route('fleet.test-repair-orders.en-taller-correctivo', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>3</td>
                <td>0234BRQ</td>
                <td>Iveco Stralis A260 GNC (Caja Allison)</td>
                <td></td>
                <td>PREVENTIVO</td>
                <td>TALLER</td>
                <td>Ismael</td>
                <td><a href="{{ route('fleet.test-repair-orders.en-taller-preventivo', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>4</td>
                <td>1546GLM</td>
                <td></td>
                <td>Hiab X-HiPro 408</td>
                <td>PREVENTIVO</td>
                <td>TÉCNICO</td>
                <td>Ismael</td>
                <td><a href="{{ route('fleet.test-repair-orders.cita-preventivo-tecnico', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>5</td>
                <td>01446SAW</td>
                <td>L35</td>
                <td>BVB015 (Lavacassonetti)</td>
                <td>PREVENTIVO</td>
                <td>TALLER</td>
                <td>Tomás</td>
                <td><a href="{{ route('fleet.test-repair-orders.pendiente-cita-taller', 1) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
              </tr>
            </tbody>
          </table>
    @endcomponent
@endsection