@extends('layouts.admin')

@section('title', $operation->plan->name . ' ' . optional($operation->plan->manufacturer)->name .' '. optional($operation->plan->model)->name . ' > Operaciones > ' . $operation->name)

@section('content')

	<div class="mb-4">
		<a href="{{ route('admin.maintenance-plans-operation.spare-parts.index', $operation) }}"><i class="fas fa-arrow-alt-circle-left fa-lg text-indigo-600"></i></a>
	</div>
	
	@component('components.card')
		@slot('title', 'Nuevo Recambio')

		{!! Form::open([
			'route' => ['admin.maintenance-plans-operation.spare-parts.store', $operation],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.maintenance_plans.operations.spare_parts.form')

		
		{!! Form::close() !!}
	@endcomponent

@endsection