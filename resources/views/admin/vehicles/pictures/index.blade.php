@extends('layouts.admin')

@section('title', 'Fotos del vehículo')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Datos vehículo',
				'url' => route('admin.vehicles.edit', $vehicle),
				'active' => false
			],
			[
				'name' => 'Fotos',
				'url' => route('admin.vehicles.pictures.index', $vehicle),
				'active' => true
			],
			[
				'name' => 'Archivos',
				'url' => route('admin.vehicles.files.index', $vehicle),
				'active' => false
			],
			[
				'name' => 'Talleres asignados',
				'url' => route('admin.vehicles.garages.index', $vehicle),
				'active' => false
			],
			[
				'name' => 'Clientes asignados',
				'url' => route('admin.vehicles.customers.index', $vehicle),
				'active' => false
			]
		]
	])
	@endcomponent

	@component('components.card')
		@slot('title', 'Añadir foto')
		@include('admin.vehicles.pictures.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Fotos del vehículo')
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2">Fecha</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->pictures as $file)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2"><img class="w-1/2" src="{{$file->getLink()}}"></td>
		  	  <td class="px-6 py-2">{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.pictures.destroy', [$vehicle, $file]) }}">
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
@endsection
