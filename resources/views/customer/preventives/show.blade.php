@extends('layouts.customer')

@section('title', $preventive->name)

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $preventive->vehicle])

	@component('components.card')
		@slot('title', 'Operaciones')

		@slot('corner')
			<a href="{{ route('customer.tyre-failure.create', $preventive->vehicle) }}" class="font-medium hover:underline text-red-700">
				¿Neumáticos en mal estado?
			</a>
		@endslot
		
		<ul>
		@foreach($preventive->operations as $operation)
			<li class="flex items-center py-3">
				@if($operation->isCompleted())
					<i class="fas fa-check-circle fa-lg text-green-600"></i>
				@else
					<form method="POST" action="{{ route('customer.preventives.operations.update', [$preventive, $operation]) }}">
						@csrf
						@method('PUT')
						<input type="hidden" name="completed" value="1">
						<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
					</form>
				@endif
				<div class="ml-4">
					<p>{{ $operation->operation_name }}</p>
					<p class="text-sm">{{ $operation->operation_description }}</p>
				</div>
			</li>
		@endforeach
		</ul>

	@endcomponent

@endsection
