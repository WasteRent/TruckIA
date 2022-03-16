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
              <th>ID</th>
              <th>Incidencia</th>
              <th>Usuario</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
              @foreach($vehicle->incidents()->latest()->get() as $incidence)
              <tr>
                <td>#{{$incidence->id}}</td>
                <td>
                  <div class="incidence_content">{!! $incidence->incidence !!}</div>
                  @if($incidence->user_id == Auth::user()->id)
                    <button class="incidence_edit"><i class="fas fa-edit fa-lg"></i></button>
                  @endif
                  <form class="incidence_form hidden" method="POST" action="{{ route('fleet.vehicles.incidents.update', [$vehicle, $incidence->id]) }}">
                    @csrf
                    @method('PUT')
                    <x-trix name="incidence_{{$incidence->id}}">
                      @if($incidence->incidence) {{ $incidence->incidence }} @endif
                    </x-trix>
                    <div class="flex justify-end">
                      <button class="btn-outline-gray mt-1">Guardar</button>
                    </div>
                  </form>
                </td>
                <td>{{ $incidence->user->name }}</td>
                <td>{{ $incidence->created_at->format('d/m/Y') }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
    @endcomponent
@endif
@endsection

@push('js')
<script type="text/javascript">
  $(".incidence_edit").click(function(e) {
    $(this).siblings('.incidence_form').toggle()
    $(this).siblings('.incidence_content').toggle()
  })
</script>
@endpush