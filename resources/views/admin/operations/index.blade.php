@extends('layouts.admin')

@section('title', 'Operaciones')

@section('content')
	
	@component('components.card')
		@include('admin.operations.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.operations.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		@include('shared.operations.list')
	@endcomponent

@endsection
