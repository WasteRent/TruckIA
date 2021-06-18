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
            @foreach( $repair_orders as $repair_order )
            
              @php 
                $equipments = "";
                foreach($repair_order->vehicle->equipments as $equipment){
                  $equipments .= "{$equipment->type} {$equipment->maker->name} {$equipment->model->name} \n ";
                }
              @endphp

              <tr>
                <td>{{ $repair_order->id }}</td>
                <td>{{ $repair_order->vehicle->plate }}</td>
                <td>{{ $repair_order->vehicle->chassis }}</td>
                <td>{{ $equipments }}</td>
                <td>{{ $repair_order->type }}</td>
                <td>{{ $repair_order->enterprise_type }}</td>
                <td>{{ $repair_order->client }}</td>
                @switch($repair_order->state_id)
                  @case ("1")
                    <td><a href="{{ route('fleet.test-repair-orders.datos-incompletos', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                  @case ("2")
                    <td><a href="{{ route('fleet.test-repair-orders.en-taller-correctivo', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                  @case ("3")
                    <td><a href="{{ route('fleet.test-repair-orders.en-taller-preventivo', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                  @case ("4")
                    <td><a href="{{ route('fleet.test-repair-orders.cita-preventivo-tecnico', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                  @case ("5")
                    <td><a href="{{ route('fleet.test-repair-orders.pendiente-cita-taller', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                  @case ("6")
                    <td><a href="{{ route('fleet.test-repair-orders.factura-pendiente', $repair_order->id) }}" class="mr-3"><i class="fa fa-eye"></i></a><a href=""><i class="fa fa-edit"></i></a></td>
                    @break
                @endswitch
              </tr>
              @endforeach
            </tbody>
          </table>
    @endcomponent
@endsection