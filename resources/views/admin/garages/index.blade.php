@extends('layouts.admin')

@section('content')
<div class="shadow-lg rounded bg-white">
	<div class="float-right my-2 mr-3">
		<a href="{{ route('admin.garages.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
			<ion-icon class="mr-2" name="add"></ion-icon>
			Nuevo
		</a>
	</div>
	<table class="table-auto w-full">
	  <thead class="uppercase text-xs font-bold tracking-wide">
	    <tr class="bg-gray-100 border-t border-b">
	      <td class="px-6 py-2">Nombre</td>
	      <td class="px-6 py-2">Email</td>
	      <td class="px-6 py-2">Tel.</td>
	      <td class="px-6 py-2">Dirección</td>
	      <td class="px-6 py-2"></td>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($garages as $garage)
	  	<tr class="border-t border-b text-gray-700">
	  	  <td class="px-6 py-2">{{$garage->name}}</td>
	  	  <td class="px-6 py-2">{{$garage->email}}</td>
	  	  <td class="px-6 py-2">{{$garage->phone}}</td>
	  	  <td class="px-6 py-2">{{$garage->full_address}}</td>
	  	  <td class="px-6 py-2 flex">
	  	  	<a href="{{ route('admin.garages.edit', $garage) }}" class="mr-2">
	  	  		<ion-icon class="text-xl" name="ios-create"></ion-icon>
	  	  	</a>
	  	  	<a href="{{ route('admin.garages.show', $garage) }}">
	  	  		<ion-icon class="text-xl" name="ios-eye"></ion-icon>
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>
@endsection
