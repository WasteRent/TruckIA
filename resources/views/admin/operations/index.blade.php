@extends('layouts.admin')

@section('content')
<div class="shadow-lg rounded bg-white">
	<div class="float-right my-2 mr-3">
		<a href="{{ route('admin.operations.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
			<ion-icon class="mr-2" name="add"></ion-icon>
			Nuevo
		</a>
	</div>
	<table class="table-auto w-full">
	  <thead class="uppercase text-xs font-bold tracking-wide">
	    <tr class="bg-gray-100 border-t border-b">
	      <td class="px-6 py-2">Taller</td>
	      <td class="px-6 py-2">Vehículo</td>
	      <td class="px-6 py-2">Solicitado</td>
	      <td class="px-6 py-2">Estado</td>
	      <td class="px-6 py-2"></td>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($operations as $operation)
	  	<tr class="border-t border-b text-gray-700">
	  	  <td class="px-6 py-2">{{ $operation->garage->name }}</td>
	  	  <td class="px-6 py-2">{{ $operation->vehicle->plate }}</td>
	  	  <td class="px-6 py-2">{{ $operation->created_at->format('d/m/Y H:i:s') }}</td>
	  	  <td class="px-6 py-2">
	  	  	<span class="{{ $operation->completed ? 'bg-green-200 text-green-800':'bg-red-200 text-red-800' }} rounded-full px-3 py-1 text-xs">
	  	  		{{ $operation->completed ? 'Completada':'Pendiente' }}
	  	  	</span>
	  	  </td>
	  	  <td class="px-6 py-2">
	  	  	<a href="{{ route('admin.operations.show', $operation) }}">
	  	  		<ion-icon class="text-xl" name="ios-eye"></ion-icon>
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>
@endsection
