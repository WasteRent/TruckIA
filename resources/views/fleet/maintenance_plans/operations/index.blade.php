@extends('layouts.fleet')

@section('title', $plan->name . ' ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name . ' > Operaciones')

@section('content')

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones incluídas')

		<table>
		  <thead>
		    <tr>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
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
		  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}">
		  		  			@if($operation->attachment->content_type == 'application/pdf')
		  		  				<i class="fas fa-file-pdf fa-2x text-red-700"></i>
		  		  			@else
		  		  				<img src="{{ $operation->attachment->getLink() }}">
		  		  			@endif
		  		  		</a>
		  		  	@endif
		  		  </td>
		  		</tr>
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
