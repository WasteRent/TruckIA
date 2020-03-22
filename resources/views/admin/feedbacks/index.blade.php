@extends('layouts.admin')

@section('title', 'Feedback')

@section('content')
	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Mensaje</th>
		      <th>Tipo</th>
		      <th>Revisado</th>
		      <th>Usuario</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($feedbacks as $feedback)
		  	<tr>
		  	  <td>{{$feedback->message}}</td>
		  	  <td>{{$feedback->type}}</td>
		  	  <td>{{$feedback->reviewed ? 'Si':'No'}}</td>
		  	  <td>{{$feedback->getUser()->role}} - {{$feedback->getUser()->username}}</td>
		  	  <td>{{$feedback->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  	@if(!$feedback->reviewed)
		  	  	<form method="POST" action="{{ route('admin.feedbacks.update', $feedback) }}">
		  	  		@csrf
		  	  		@method('PUT')
		  	  		<input type="hidden" name="reviewed" value="1">
		  	  		<button><i class="icon fas fa-check"></i></button>
		  	  	</form>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $feedbacks->appends(request()->query())->links() }}

@endsection
