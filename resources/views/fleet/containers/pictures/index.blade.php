@extends('layouts.fleet')

@section('title', $container->plate . ' ' . $container->chassis)

@section('content')
	
	@include('fleet.containers.edit_tabs', ['active_pictures' => true])


	@component('components.card', ['compressed' => true])
		@slot('title', __('Añadir foto'))
		@include('fleet.containers.pictures.create')
	@endcomponent

	<br><br>

	@if($container->pictures->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', __('Fotos del vehículo'))
			<table >
			  <thead >
			    <tr >
			      <th>{{ __('Descripción') }}</th>
			      <th>{{ __('Fecha') }}</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($container->pictures->sortByDesc('pivot.cover') as $file)
			  	<tr>
			  	  <td>
			  	  	<a target="_blank" href="{{$file->getLink()}}">
			  	  		<img loading="lazy" class="w-1/2" src="{{$file->getLink()}}">
			  	  	</a>
			  	  </td>
			  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	@if(!$file->pivot->cover)
			  	  	<form method="POST" action="{{ route('fleet.containers.pictures.update', [$container, $file]) }}">
			  	  		@csrf
			  	  		@method('PUT')
			  	  		<input type="hidden" name="cover" value="1">
			  	  		<button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline">{{ __('Portada') }}</button>
			  	  	</form>
			  	  	@endif

			  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.containers.pictures.destroy', [$container, $file]) }}">
			  	  		@csrf
			  	  		@method('DELETE')
			  	  		<button><i class="icon fas fa-trash-alt"></i></button>
			  	  	</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif
@endsection
