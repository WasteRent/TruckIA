@extends('layouts.admin')

@section('title', 'Taller ' . $garage->name)

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Editar datos del taller',
				'url' => route('admin.garages.edit', $garage),
				'active' => false
			],
			[
				'name' => 'Especialidades',
				'url' => '',
				'active' => true
			]
		]
	])
	@endcomponent

	@component('components.card')
	<div class="max-w-lg mx-auto">	
		@foreach($specialities as $spec) 
			{!! Form::model([], [
				'route' => ['admin.garage.specialities.update', $garage, $spec],
				'method' => 'PUT',
				'class' => ''
			]) !!}	
			<div class="flex py-3">
				<div class="w-1/2">
					{{ $spec->name }} 
					<stars :rating="{{ $garage_specialities->contains($spec) ? (int)$garage_specialities->where('id',$spec->id)->first()->pivot->stars : 0 }}"></stars>
				</div>
				<div class="w-1/2">
					{!! Form::number('stars', 
						$garage_specialities->contains($spec) 
							? $garage_specialities->where('id',$spec->id)->first()->pivot->stars 
							: null, 
					['class' => 'form-input', 'step' => '0.5']) !!}
				</div>
				<div class="flex items-center px-3">
					<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Actualizar</button>
				</div>
			</div>
			{!! Form::close() !!}
		@endforeach
	</div>
	@endcomponent


@endsection