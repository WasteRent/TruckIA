@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar subfamilia de ' . $family->name)

		{!! Form::model($subfamily, [
			'route' => ['admin.families.subfamilies.update', $family, $subfamily],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.families.subfamilies.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection