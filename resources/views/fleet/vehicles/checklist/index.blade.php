@extends('layouts.fleet')

@section('content')
  @component('components.card', ['is_table' => true])
    @slot('title', __('Checklists'))
    @slot('corner')
      <div class="flex">
        <assign-checklist 
            endpoint="{{ route('fleet.vehicle.checklists.store', $vehicle) }}"
            :checklists="{{ json_encode($checklists) }}"
            >
        </assign-checklist>
      </div>
    @endslot
    <table>
      <thead>
        <tr>
            <th class="">{{ __('Checklist') }}</th>
            <th class="">Fecha de creación</th>
            <th class=""></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($vehicle->vehicleChecklists as $vehicleChecklist)
          <tr>
            <td>
                {{$vehicleChecklist->checklist->name}}
            </td>
            <td>{{ $vehicleChecklist->created_at->format('d/m/Y') }}</td>
            <td>
                <div class="flex">

                    <a href="{{ route('fleet.vehicle-checklists.edit', $vehicleChecklist) }}" class="mr-3">
                        <i class="icon fas fa-edit"></i>
                    </a>
                    <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicle-checklists.destroy', $vehicleChecklist) }}">
                        @csrf
                        @method('DELETE')
                        <button><i class="icon fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </td>
          </tr>
        @endforeach
        @if (!$vehicle->vehicleChecklists->count())
        <tr>
            <td>
              Sin checklist asignadas
            </td>
        </tr>
        @endif

      </tbody>
    </table>
  @endcomponent
@endsection
