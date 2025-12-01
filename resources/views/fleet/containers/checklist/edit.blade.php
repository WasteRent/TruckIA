@extends('layouts.fleet')

@section('title', $container->reference .' '. $container->maker)

@section('content')

	<div class="mb-4">
		<a href="{{ route('fleet.containers.checklists.index', $container) }}" class="text-blue-800 hover:text-blue-600">
			<i class="fas fa-angle-double-left"></i> 
			{{ __('Volver') }}
		</a>
	</div>

	@include('fleet.containers.edit_tabs', ['active_checklists' => true])

	@component('components.card')
		@slot('title', 'Checklist '.$container_checklist->checklist->name)

        {!! Form::model($container_checklist, [
            'route' => ['fleet.container-checklists.update', $container_checklist],
            'method' => 'PUT',
            'class' => 'w-full'
        ]) !!}  

		@include('fleet.containers.checklist.form')

        <div class="flex justify-end mt-6">
            <button type="submit" class="btn-indigo">{{ __('Guardar') }}</button>
        </div>

        {!! Form::close() !!}

	@endcomponent

@endsection

