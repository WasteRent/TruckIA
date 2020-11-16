@extends('layouts.garage')

@section('title', 'Orden de Reparación #' . $repair_order->id)

@section('content')


	
	@if($repair_order->isFinished())
		@component('components.alert-success')
			<p>Todas las operaciones han sido completadas</p>
		@endcomponent
	@else
		<div class="flex justify-end">
			<form method="POST" action="{{ route('garage.repair-orders.finish', $repair_order) }}">
				@csrf
				<div class="flex">
					<div>
						<label class="form-label">Tiempo invertido (h)</label>
						<input required class="form-input" type="number" name="finish_total_time">
					</div>
					<div>
						<button class="btn-indigo mt-8 ml-2">Finalizar todas las operaciones</button>
					</div>
				</div>
			</form>
		</div>
	@endif


	<a href="{{ route('garage.repair-orders.show', $repair_order) }}">
		<i class="fas fa-long-arrow-alt-left fa-3x"></i>
	</a>

	<div class="w-full">
		@include('garage.repair_orders.execute.progress')
		<br>

		@foreach($operations as $operation)
			@component('components.card')
				@slot('title')
					{{ $operation->operation_code }} &middot; {{ $operation->operation_name }}

					@if($operation->operationAttachment)
						<a href="{{$operation->operationAttachment->getLink()}}" target="_blank">
							<i class="fas fa-question-circle"></i>
						</a>
					@endif
				@endslot

				@slot('corner')
					@if($operation->isCompleted())
						<span class="bg-green-200 text-green-800 rounded-full px-3 py-1 text-xs">
				  	  		Completada
				  	  	</span>
					@else
						<span class="bg-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs">
				  	  		Pendiente
				  	  	</span>
					@endif
				@endslot

				<div class="sm:flex">
					<div class="sm:w-1/2">
						@component('components.table')
							@slot('items', [
								'Área' => $operation->operation_family,
								'Descripción' => $operation->operation_description,
								'Tiempo estimado (h)' => $operation->estimated_time_in_hours
							])
						@endcomponent

						@if($operation->file)
							<br>
							<a href="{{ $operation->file->getLink() }}" class="text-indigo-600" target="_blank">
								<i class="fas fa-cloud-download-alt"></i> Archivo
							</a>
						@endif

						@include('garage.repair_orders.execute.parts')
					</div>
					<div class="sm:w-1/2 mt-6 sm:mt-0">
						@if(!$operation->isCompleted())
							@include('garage.repair_orders.execute.create', ['current_operation' => $operation])
						@else
							@include('garage.repair_orders.execute.edit', ['current_operation' => $operation])
						@endif
					</div>
				</div>
			@endcomponent
		@endforeach


		
	</div>
@endsection
