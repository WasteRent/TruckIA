@extends('layouts.admin')

@section('title', 'Operaciones')

@section('content')

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.universal-operations.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
			
		<table>
		  <thead>
		    <tr>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
		  		<tr>
		  		  <td>
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  	
		  		  </td>
		  		  <td>{{ $operation->name }}</td>
		  		  <td>
		  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
		  		  </td>
		  		  <td>{{ $operation->time_in_hours }}</td>
		  		  <td>
		  		  	@if($operation->attachment)
		  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}"><img src="{{ $operation->attachment->getLink() }}"></a>
		  		  	@endif
		  		  </td>
		  		  <td>
		  		  	<div class="flex">
		  		  		<a href="{{ route('admin.universal-operations.edit', $operation) }}" class="mr-3">
		  		  			<i class="icon fas fa-edit"></i>
		  		  		</a>
		  		  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.universal-operations.destroy', $operation) }}">
		  		  			@csrf
		  		  			@method('DELETE')
		  		  			<button><i class="icon fas fa-trash-alt"></i></button>
		  		  		</form>
		  		  	</div>
		  		  </td>
		  		</tr>
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $operations->appends(request()->query())->links() }}
@endsection