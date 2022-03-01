@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_incidents' => true])

	
	@component('components.card', ['compressed' => true])
    @slot('title', 'Añadir Incidencia')
    @include('fleet.vehicles.incidents.create')
@endcomponent

<br><br>

@if($vehicle->incidents->count() > 0)
    @component('components.card', ['is_table' => true])
        @slot('title', 'Incidencias del vehículo')
        <table >
          <thead >
            <tr >
              <th></th>
              <th>Incidencia</th>
              <th>Fecha</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
              @foreach($vehicle->incidents as $incidence)
              <tr>
                <td>{{ $incidence->user->name }}</td>
                <td>{!! $incidence->incidence !!}</td>
                <td>{{ $incidence->created_at->format('d/m/Y') }}</td>
                <td>
                    <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.incidents.destroy', [$vehicle, $incidence]) }}">
                        @csrf
                        @method('DELETE')
                        <button><i class="icon fas fa-trash-alt"></i></button>
                    </form>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
    @endcomponent
@endif
@endsection