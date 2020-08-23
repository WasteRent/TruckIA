@extends('layouts.admin')

@section('title', 'Planes de mantenimiento')

@section('content')

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Marca</th>
		      <th>Modelo</th>
		      <th>Planes</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($manufacturers as $manufacturer)
		  		@foreach($manufacturer->models->sortBy('name') as $model)
			  	<tr>
			  	  <td class="{{ $model->plans->count() == 0 ? 'bg-red-100':'bg-green-100' }}">
			  	  	<span class="{{ $model->plans->count() == 0 ? 'text-red-800':'text-green-800' }}">{{ $manufacturer->name }}</span>
			  	  </td>
			  	  <td class="{{ $model->plans->count() == 0 ? 'bg-red-100':'bg-green-100' }}">
			  	  	<span class="{{ $model->plans->count() == 0 ? 'text-red-800':'text-green-800' }}">{{ $model->name }}</span>
			  	  </td>
			  	  <td class="{{ $model->plans->count() == 0 ? 'bg-red-100':'bg-green-100' }}">
			  	  	<span class="{{ $model->plans->count() == 0 ? 'text-red-800':'text-green-800' }}">{{ $model->plans->count() }}</span>
			  	  </td>
			  	</tr>
		  		@endforeach
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
