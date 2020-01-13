@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2">Usuario</td>
		      <td class="px-6 py-2">Email</td>
		      <td class="px-6 py-2">Rol</td>
		      <td class="px-6 py-2">Fecha de Alta</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($users as $user)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $user->name }}</td>
		  	  <td class="px-6 py-2">{{ $user->username }}</td>
		  	  <td class="px-6 py-2">{{ $user->email }}</td>
		  	  <td class="px-6 py-2">{{ $user->role }}</td>
		  	  <td class="px-6 py-2">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td class="px-6 py-2">
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $users->appends(request()->query())->links() }}
@endsection
