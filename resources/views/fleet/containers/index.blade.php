@extends('layouts.fleet')

@section('title', __('Contenedores'))

@section('content')
	@component('components.search-card')
		@include('fleet.containers.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.containers.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>{{ __('ID') }}</th>
		      <th>{{ __('Marca') }}</th>
		      <th>{{ __('Modelo') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Estado') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Ubicación') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($containers as $container)
		  	<tr>
				<td>{{ $container->reference }}</td>
				<td>{{ $container->maker }}</td>
				<td>{{ $container->model }}</td>
				<td class="hidden sm:table-cell">{{ __(optional($container->state)->name) }}</td>
				<td class="hidden sm:table-cell">{{ __($container->location) }}</td>
				<td>
					<div class="flex">
						<a href="{{ route('fleet.containers.edit', $container) }}"  class="mr-3">
							<i class="icon fas fa-edit"></i>
						</a>
						@if(auth()->user()->job == 'fleet_manager')
						<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.containers.destroy', $container) }}">
							@csrf
							@method('DELETE')
							<button><i class="icon fas fa-trash-alt"></i></button>
						</form>
						@endif
					</div>
				</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $containers->appends(request()->query())->links() }}
@endsection
