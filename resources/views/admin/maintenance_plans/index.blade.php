@extends('layouts.admin')

@section('title', 'Planes de mantenimiento')

@section('content')
<div class="shadow-lg rounded bg-white">
	<div class="float-right my-2 mr-3">
		<a href="{{ route('admin.maintenance-plans.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
			<i class="icon fas fa-plus-circle mr-2"></i>
			Nuevo
		</a>
	</div>
	<table class="table-auto w-full">
	  <thead class="uppercase text-xs font-bold tracking-wide">
	    <tr class="bg-gray-100 border-t border-b">
	      <td class="px-6 py-2">Nombre</td>
	      <td class="px-6 py-2">Descripción</td>
	      <td class="px-6 py-2">Frecuencia</td>
	      <td class="px-6 py-2"></td>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($plans as $plan)
	  	<tr class="border-t border-b text-gray-700">
	  	  <td class="px-6 py-2">{{ $plan->name }}</td>
	  	  <td class="px-6 py-2">{{ $plan->description }}</td>
	  	  <td class="px-6 py-2">{{ $plan->frequency }}</td>
	  	  <td class="px-6 py-2">
	  	  	<a href="{{ route('admin.maintenance-plans.edit', $plan) }}">
	  	  		<i class="icon fas fa-edit"></i>
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>
@endsection
