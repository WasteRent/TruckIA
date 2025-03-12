@extends('layouts.fleet')

@section('title')
<div class="flex justify-between items-center">
  <div class="mr-20" >{{ __('Lavados') }}</div>
</div>
@endsection


@section('content')

  @component('components.card', ['is_table' => true])
  		@slot('corner')
      <a class="mr-4 text-green-600" href="{{ route('fleet.export.washings') }}"><i class="fas fa-lg fa-file-excel"></i></a>
  			<a href="{{ route('fleet.washing.create') }}" class="btn-outline-gray flex items-center">
  				<i class="icon fas fa-plus-circle mr-2"></i>
  				{{ __('Nuevo') }}
  			</a>
  		@endslot

      <table >
        <thead >
          <tr >
            <th>{{ __('ID') }}</th>
            <th>{{ __('Matrícula')  }}</th>
            <th>{{ __('Tiempo total') }}</th>
            <th>{{ __('Inicio') }}</th>
            <th>{{ __('Final') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($washings as $washing)
            <tr>
              <td>
                <p>#{{$washing->id}}</p>
                <p class="text-xs">Creado por {{ $washing->user->name }}</p>
              </td>
              <td>
                <p> {{ $washing->vehicle->plate }}</p>
              </td>
              <td>
                <p>
                  {{ \Carbon\Carbon::parse($washing->start_date)->diffInHours(\Carbon\Carbon::parse($washing->end_date)) . ' horas' }}
                  {{ (\Carbon\Carbon::parse($washing->start_date)->diffInMinutes(\Carbon\Carbon::parse($washing->end_date)) % 60) . ' minutos' }}
                </p>
              </td>
              <td>{{ \Carbon\Carbon::parse($washing->start_date)->format('d/m/Y H:i') }}</td>
              <td>{{ \Carbon\Carbon::parse($washing->end_date)->format('d/m/Y H:i') }}</td>
              <td>
                @if(in_array(auth()->user()->job, ['fleet_manager']))
                  <x-form-button method="DELETE" :action="route('fleet.washing.destroy', $washing)" class="text-xs flex items-center text-red-700">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 shrink-0  " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ __('Eliminar') }}
                  </x-form-button>
                @endif
              </td>
            </tr>
            @endforeach
        </tbody>
      </table>

      @if($washings->count())
        {{ $washings->appends(request()->query())->links() }}
      @endif

  @endcomponent
@endsection
