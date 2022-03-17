@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

	@include('fleet.customers.tabs', ['active_users' => true])
	
	@component('components.card')
		@slot('title', __('Añadir usuario'))
		@include('fleet.customers.users.create')
	@endcomponent

	<br><br>

	@foreach($users as $user)
		@component('components.card')
			@slot('title', 'Usuario ' . ($loop->index + 1))
			@slot('corner')
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.customers.users.destroy', [$customer, $user]) }}">
					@csrf
					@method('DELETE')
					<button class="btn-outline-red">{{ __('Eliminar') }}</button>
				</form>
			@endslot

			@include('fleet.customers.users.edit')

		@endcomponent
	@endforeach

@endsection