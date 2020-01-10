@extends('layouts.admin')

@section('title', 'Nueva Orden de Reparación')

@section('progress')
	<div class="mb-6">@include('shared.progress')</div>
@endsection

@section('content')

	@component('components.card')
		@slot('title', 'Seleccionar vehículo')
		Hello
	@endcomponent

@endsection
