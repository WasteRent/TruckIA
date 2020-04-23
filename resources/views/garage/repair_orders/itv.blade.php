@component('components.card')
	@slot('title', 'ITV')
	<ul>
		<li class="flex items-center py-3">
			@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_RECEIVED_BY_GARAGE))
				<i class="fas fa-check-circle fa-lg text-green-600"></i>
			@else
				<form method="POST" action="{{ route('garage.repair-orders.state.update', $repair_order) }}">
					@csrf
					@method('PUT')
					<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_RECEIVED_BY_GARAGE}}">
					<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
				</form>
			@endif
			<div class="ml-4">
				<p>Documentación recibida</p>
			</div>
		</li>

		<li class="flex items-center py-3">
			@if($repair_order->scheduled_itv_date)
				<i class="fas fa-check-circle fa-lg text-green-600"></i>
			@else
				<i class="fas fa-check-circle fa-lg text-gray-400"></i>
			@endif
			<span class="mx-4">Cita ITV</span>
			<form method="POST" action="{{ route('garage.repair-orders.itv.update', $repair_order) }}">
				@csrf
				@method('PUT')
				<input type="text" name="scheduled_itv_date" value="{{ $repair_order->scheduled_itv_date }}" class="bg-gray-100 rounded border px-2 datepicker">
				<button><i class="fas fa-save"></i></button>
			</form>
		</li>

		<li class="flex items-center py-3">
			@if($repair_order->itv_correct == 1)
				<i class="fas fa-check-circle fa-lg text-green-600"></i>
			@else
				<i class="fas fa-check-circle fa-lg text-gray-400"></i>
			@endif
			<span class="mx-4">
				ITV pasada 
				<small>
					(Cargar pegatina)
					@if($repair_order->itvFile && $repair_order->itv_correct == 1)
					<a href="{{ $repair_order->itvFile->getLink() }}" target="_blank"><i class="fas fa-cloud-download-alt"></i></a>
					@endif
				</small>
			</span>
			<form method="POST" enctype="multipart/form-data" action="{{ route('garage.repair-orders.itv.update', $repair_order) }}">
				@csrf
				@method('PUT')
				<input type="file" name="itv_correct_file" class="bg-gray-100 rounded border px-2">
				<button><i class="fas fa-save"></i></button>
			</form>
		</li>

		<li class="flex items-center py-3">
			@if($repair_order->itv_correct === 0)
				<i class="fas fa-times-circle fa-lg text-red-500"></i>
			@else
				<i class="fas fa-times-circle fa-lg text-gray-400"></i>
			@endif
			<span class="mx-4">
				ITV fallida 
				<small>
					(Cargar no conformidades) 
					@if($repair_order->itvFile && $repair_order->itv_correct === 0)
					<a href="{{ $repair_order->itvFile->getLink() }}" target="_blank"><i class="fas fa-cloud-download-alt"></i></a>
					@endif
				</small>
			</span>

			<form method="POST" enctype="multipart/form-data" action="{{ route('garage.repair-orders.itv.update', $repair_order) }}">
				@csrf
				@method('PUT')
				<input type="file" name="itv_failed_file" class="bg-gray-100 rounded border px-2">
				<button><i class="fas fa-save"></i></button>
			</form>
		</li>

		<li class="flex items-center py-3">
			@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_RETURNED_BY_GARAGE))
				<i class="fas fa-check-circle fa-lg text-green-600"></i>
			@else
				<form method="POST" action="{{ route('garage.repair-orders.state.update', $repair_order) }}">
					@csrf
					@method('PUT')
					<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_RETURNED_BY_GARAGE}}">
					<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
				</form>
			@endif
			<div class="ml-4">
				<p>Documentación enviada de vuelta</p>
			</div>
		</li>
	</ul>
@endcomponent