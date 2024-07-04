@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('title', __('Ordenes de Reparación'))

@section('content')
  @component('components.card', ['is_table' => true])
    @slot('title', __('Checklists'))
    @slot('corner')
      <div class="flex">
        <assign-order-repair-checklist 
            endpoint="{{ route('fleet.repair-orders.checklists.store', $repair_order) }}"
            :checklists="{{ json_encode($checklists) }}"
            >
        </assign-order-repair-checklist>
      </div>
    @endslot
    <table>
      <thead>
        <tr>
          <th class="w-full">{{ __('Checklist') }}</th>
          <th class="w-full"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($repair_order->repairOrderChecklists as $repairOrderChecklist)
          <tr>
            <td>
                {{$repairOrderChecklist->checklist->name}}
            </td>
            <td>
                <div class="flex">
                    <a href="{{ route('fleet.repair-order-checklists.edit', $repairOrderChecklist) }}" class="mr-3">
                        <i class="icon fas fa-edit"></i>
                    </a>
                    <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.repair-order-checklists.destroy', $repairOrderChecklist) }}">
                        @csrf
                        @method('DELETE')
                        <button><i class="icon fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </td>
          </tr>
        @endforeach
        @if (!$repair_order->repairOrderChecklists->count())
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
