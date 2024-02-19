
	@if(!$repair_order->isFinished())
		<div class="flex justify-end mb-6">
			@if(request()->plan_id)
			<form method="POST" action="{{ route('garage.repair-orders.plan.finish', [$repair_order, request()->plan_id]) }}">
				@csrf
				<div class="flex">
					<div>
						<label class="form-label">Tiempo invertido (h)</label>
						<input required class="form-input bg-white border" step="any" type="number" name="finish_total_time">
					</div>
					<div>
						<button class="btn-indigo mt-8 ml-2">Finalizar todas las operaciones</button>
					</div>
				</div>
			</form>
			@endif
		</div>
	@endif

	<div class="w-full">
		@include('garage.repair_orders.execute.progress')
		<br>

		@foreach($repair_order->operations->sortBy(function ($operation) {
		    return $operation->isCompleted();
		}) as $operation)
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

				<p class="text-gray-800">
					{{ $operation->operation_description }}
				</p>

				<hr class="my-4">

				<div class="sm:flex">
					<div class="sm:w-1/2">
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
