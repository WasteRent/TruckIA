@extends('layouts.admin')

@section('title', 'Manuales de ' . $manufacturer->name . " " . $model->name)

@section('content')
	
	@component('components.card')
		@slot('title', 'Manuales')
		<div class="flex">
			@if($model->technicalHandbook)
				<div class="w-1/2 flex items-center">
					<span class="mr-3">Manual Técnico</span>
					<a class="mr-3" target="_blank" href="{{ $model->technicalHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i></a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.handbooks.technical.destroy', $model) }}">
						@csrf
						@method('DELETE')
						<button><i class="icon fas fa-trash-alt"></i></button>
					</form>
				</div>
			@endif
			@if($model->usageHandbook)
				<div class="w-1/2 flex items-center">
					<span class="mr-3">Manual de Uso</span>
					<a class="mr-3" target="_blank" href="{{ $model->usageHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i></a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.handbooks.usage.destroy', $model) }}">
						@csrf
						@method('DELETE')
						<button><i class="icon fas fa-trash-alt"></i></button>
					</form>
				</div>
			@endif	
		</div>
	@endcomponent

	<br><br>

	@if(!$model->technicalHandbook)
		@component('components.card')
			@slot('title', 'Cargar Manual Técnico')
			{!! Form::open([
			  'route' => ['admin.handbooks.technical.store', $model],
			  'files' => true,
			  'method' => 'POST',
			  'class' => 'w-full'
			]) !!}  
			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
			    <label class="form-label form-required">
			      Archivo
			    </label>
			      {!! Form::file('file', ['class' => 'form-input']) !!}
			   </div>
			</div>
			<div class="flex justify-end">
			  <button class="btn-indigo">Guardar</button>
			</div>
			{!! Form::close() !!}
		@endcomponent
	@endif

	@if(!$model->usageHandbook)
		@component('components.card')
			@slot('title', 'Cargar Manual de Uso')
			{!! Form::open([
			  'route' => ['admin.handbooks.usage.store', $model],
			  'files' => true,
			  'method' => 'POST',
			  'class' => 'w-full'
			]) !!}  
			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
			    <label class="form-label form-required">
			      Archivo
			    </label>
			      {!! Form::file('file', ['class' => 'form-input']) !!}
			   </div>
			</div>
			<div class="flex justify-end">
			  <button class="btn-indigo">Guardar</button>
			</div>
			{!! Form::close() !!}
		@endcomponent
	@endif

@endsection
