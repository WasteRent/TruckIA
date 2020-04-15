@extends('layouts.fleet')

@section('title', $garage->name)

@section('content')

	@include('fleet.garages.tabs', ['active_users' => true])
	
	@component('components.card')
		@slot('title', 'Añadir usuario')
		@include('fleet.garages.users.create')
	@endcomponent

	<br><br>

	@foreach($users as $user)
		@component('components.card')
			@slot('title', 'Usuario ' . ($loop->index + 1))
			@slot('corner')
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.garage.users.destroy', [$garage, $user]) }}">
					@csrf
					@method('DELETE')
					<button class="btn-outline-red">Eliminar</button>
				</form>
			@endslot

			@include('fleet.garages.users.edit')

		@endcomponent
	@endforeach

@endsection