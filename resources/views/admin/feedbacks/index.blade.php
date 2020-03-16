@extends('layouts.admin')

@section('title', 'Feedback')

@section('content')
	@component('components.card', ['is_table' => true])
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Mensaje</td>
		      <td class="px-6 py-2">Tipo</td>
		      <td class="px-6 py-2">Revisado</td>
		      <td class="px-6 py-2">Usuario</td>
		      <td class="px-6 py-2">Fecha</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($feedbacks as $feedback)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$feedback->message}}</td>
		  	  <td class="px-6 py-2">{{$feedback->type}}</td>
		  	  <td class="px-6 py-2">{{$feedback->reviewed ? 'Si':'No'}}</td>
		  	  <td class="px-6 py-2">{{$feedback->user->role}} - {{$feedback->user->username}}</td>
		  	  <td class="px-6 py-2">{{$feedback->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
