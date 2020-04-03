@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table >
		  <thead >
		    <tr >
		      <td>Nombre</td>
		      <td>Usuario</td>
		      <td>Email</td>
		      <td>Rol</td>
		      <td>Fecha de Alta</td>
		      <td></td>
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
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $users->appends(request()->query())->links() }}
@endsection
