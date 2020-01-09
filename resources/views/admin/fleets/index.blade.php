@extends('layouts.admin')

@section('content')

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.fleets.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<ion-icon class="mr-2" name="add"></ion-icon>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($fleets as $fleet)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$fleet->name}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.fleets.edit', $fleet) }}" class="mr-2">
		  	  		<ion-icon class="text-xl" name="ios-create"></ion-icon>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
