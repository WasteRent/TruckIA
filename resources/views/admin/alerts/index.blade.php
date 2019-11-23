@extends('layouts.admin')

@section('content')
<div class="shadow-lg rounded bg-white">
	<div class="py-2"></div>
	<table class="table-auto w-full">
	  <thead class="uppercase text-xs font-bold tracking-wide">
	    <tr class="bg-gray-100 border-t border-b">
	      <td class="px-6 py-2">Matrícula</td>
	      <td class="px-6 py-2">Vehículo</td>
	      <td class="px-6 py-2">Alerta</td>
	      <td class="px-6 py-2">Fecha</td>
	      <td class="px-6 py-2"></td>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($alerts as $alert)
	  	<tr class="border-t border-b text-gray-700">
	  	  <td class="px-6 py-2">{{ $alert->vehicle->plate }}</td>
	  	  <td class="px-6 py-2">{{ $alert->vehicle->chassis }} {{ $alert->vehicle->box }}</td>
	  	  <td class="px-6 py-2">{{ $alert->description }}</td>
	  	  <td class="px-6 py-2">{{ $alert->created_at->format('d/m/Y H:i:s') }}</td>
	  	  <td class="px-6 py-2">
	  	  	<a href="{{ route('admin.operations.create') }}">
	  	  		<ion-icon class="text-xl" name="ios-build"></ion-icon>
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>
@endsection
