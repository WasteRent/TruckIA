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
			<input type="hidden" name="speciality_id" value="{{ $spec->id }}">
			<div class="flex py-3">
				<div class="w-1/2">
					{{ $spec->name }} <stars :rating="{{ (int)$garage_specialities->where('id',$spec->id)->first()->pivot->stars }}"></stars>
				</div>
				<div class="w-1/2">
					{!! Form::number('stars', 
						$garage_specialities->pluck('id')->contains($spec->id) 
							? $garage_specialities->where('id',$spec->id)->first()->pivot->stars 
							: null, 
					['class' => 'form-input', 'step' => '0.5']) !!}
				</div>
			</div>
		@endforeach
		</div>
	@endcomponent


@endsection