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
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection