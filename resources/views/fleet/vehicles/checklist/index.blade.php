@extends('layouts.fleet')

@section('content')
  @component('components.card', ['is_table' => true])
    @slot('title', __('Checklists'))
    <table>
      <thead>
        <tr>
          <th class="w-full">{{ __('Checklist') }}</th>
          <th class="w-full"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($vehicle->vehicleChecklists as $vehicleChecklist)
          <tr>
            <td>
                {{$vehicleChecklist->checklist->name}}
            </td>
            <td>
                <div class="flex">
                    <a href="{{route('fleet.vehicle-checklists.pdf', $vehicleChecklist)}}" class="mr-3">
                        <i class="fas fa-file-pdf fa-lg"></i>
                    </a>
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
