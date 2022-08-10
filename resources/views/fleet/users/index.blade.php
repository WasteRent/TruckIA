@extends('layouts.fleet')

@section('title', __('Usuarios'))

@section('content')
	@component('components.search-card')
		@include('admin.users.search', ['route' => 'fleet.users.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.users.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table >
		  <thead >
		    <tr >
		      <th>{{ __('Nombre') }}</th>
		      <th>{{ __('Usuario') }}</th>
		      <th>{{ __('Email') }}</th>
		      <th>{{ __('Activo') }}</th>
		      <th>{{ __('Sólo lectura') }}</th>
		      <th>{{ __('Alta') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($users->where('job', '!=', 'fleet_manager') as $user)
		  	<tr >
		  	  <td>{{ $user->name }}</td>
		  	  <td>{{ $user->username }}</td>
		  	  <td>{{ $user->email }}</td>
		  	  <td>{{ $user->is_active ? 'Si':'No' }}</td>
		  	  <td>{{ $user->is_readonly ? 'Si':'No' }}</td>
		  	  <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
				<div class="flex">
					<a href="{{ route('fleet.users.edit', $user) }}">
						<i class="icon fas fa-edit"></i>
					</a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.users.destroy', $user) }}">
						@csrf
						@method('DELETE')
						<button><i class="ml-2 icon fas fa-trash-alt"></i></button>
					</form>
				</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $users->appends(request()->query())->links() }}
@endsection
