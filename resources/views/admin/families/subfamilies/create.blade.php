@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva subfamilia de ' . $family->name)

		{!! Form::open([
			'route' => ['admin.families.subfamilies.store', $family],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.families.subfamilies.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection