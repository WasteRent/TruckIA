@extends('layouts.fleet')

@section('title', $container->reference .' '. $container->maker)

@section('content')

	@include('fleet.containers.edit_tabs', ['active_checklists' => true])

	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir checklist'))
    @include('fleet.containers.checklist.create')
	@endcomponent

	<br><br>

	@component('components.search-card')
	{!! 
	  Form::model(request()->all(), [
	    'route' => ['fleet.containers.checklists.index', $container], 
	    'method' => 'GET',
	    'class' => ['md:flex items-center']
	  ])
	!!}
	    <div class="lg:px-3 lg:mb-0 mb-3">
	      <label class="form-label">{{__('Tipo')}}</label>
	      <select name="checklist_id" class="form-input">
	        <option value="">{{ __('Todos') }}</option>
	        <option value="9" {{ request('checklist_id') == '9' ? 'selected' : '' }}>Preventivo</option>
	        <option value="10" {{ request('checklist_id') == '10' ? 'selected' : '' }}>Correctivo</option>
	      </select>
	    </div>
	    <div class="lg:px-3 lg:mb-0 mb-3">
	      <label class="form-label">{{__('Fecha')}}</label>
	      {!! Form::date('date', request('date'), ['class' => 'form-input']) !!}
	    </div>
	    <div class="text-right">
	        <button class="btn-search">
	          <i class="fas fa-search"></i>
	        </button>
	    </div>
	{!! Form::close() !!}
	@endcomponent

	@if($containerChecklists->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', __('Checklists'))
			<table>
			  <thead>
			    <tr>
			        <th class="">{{ __('Tipo') }}</th>
			        <th class="">{{ __('Fecha') }}</th>
			        <th class=""></th>
			    </tr>
			  </thead>
			  <tbody>
			    @foreach ($containerChecklists as $containerChecklist)
			      <tr>
			        <td>
			            {{$containerChecklist->checklist->name}}
			        </td>
			        <td>{{ $containerChecklist->date ? \Carbon\Carbon::parse($containerChecklist->date)->format('d/m/Y') : $containerChecklist->created_at->format('d/m/Y') }}</td>
			        <td>
			            <div class="flex">
			                <a href="{{ route('fleet.container-checklists.edit', $containerChecklist) }}" class="mr-3">
			                    <i class="icon fas fa-edit"></i>
			                </a>
			                <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.container-checklists.destroy', $containerChecklist) }}">
			                    @csrf
			                    @method('DELETE')
			                    <button><i class="icon fas fa-trash-alt"></i></button>
			                </form>
			            </div>
			        </td>
			      </tr>
			    @endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif
@endsection
