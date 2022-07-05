@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
	@component('components.search-card')
		@include('admin.users.search', ['route' => 'admin.users.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.users.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th>Usuario</th>
		      <th>Email</th>
		      <th>Rol</th>
		      <th>Fecha de Alta</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($users as $user)
		  	<tr >
		  	  <td>{{ $user->name }}</td>
		  	  <td>{{ $user->username }}</td>
		  	  <td>{{ $user->email }}</td>
		  	  <td>{{ $user->role }}</td>
		  	  <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
				<div class="flex">
					<a href="{{ route('admin.users.edit', $user) }}">
						<i class="icon fas fa-edit fa-lg"></i>
					</a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.users.destroy', $user) }}">
						@csrf
						@method('DELETE')
						<button><i class="ml-2 icon fas fa-trash-alt fa-lg"></i></button>
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
