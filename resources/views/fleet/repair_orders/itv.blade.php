@component('components.card')
	@slot('title', 'ITV')

	<div class="flex">
		<div class="w-1/2">
			<ul>
				<li class="flex items-center py-3">
					@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_SENT_TO_GARAGE))
						<i class="fas fa-check-circle fa-lg text-green-600"></i>
					@else
						<form method="POST" action="{{ route('fleet.repair-orders.state.update', $repair_order) }}">
							@csrf
							@method('PUT')
							<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_SENT_TO_GARAGE}}">
							<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
						</form>
					@endif
					<div class="ml-4">
						<p>Documentación enviada al taller</p>
					</div>
				</li>

				<li class="flex items-center py-3">
					@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_RECEIVED_FROM_GARAGE))
						<i class="fas fa-check-circle fa-lg text-green-600"></i>
					@else
						<form method="POST" action="{{ route('fleet.repair-orders.state.update', $repair_order) }}">
							@csrf
							@method('PUT')
							<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_RECEIVED_FROM_GARAGE}}">
							<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
						</form>
					@endif
					<div class="ml-4">
						<p>Documentación recibida del taller</p>
					</div>
				</li>
			</ul>
		</div>
		<div class="w-1/2">
			<form method="POST" action="{{ route('fleet.repair-orders.itv.update', $repair_order) }}" class="max-w-sm">
				@csrf
				@method('PUT')
				<label class="form-label">
				  Cita ITV
				</label>
				<div class="flex">
					<input type="text" name="scheduled_itv_date" value="{{ $repair_order->scheduled_itv_date }}" class="form-input datepicker">
					<button class="btn-indigo ml-2"><i class="fas fa-save"></i></button>
				</div>
			</form>
			@if($repair_order->itv_file_id)
				Documento
				<a target="_blank" href="{{ $repair_order->itvFile->getLink() }}">
					<i class="fas fa-cloud-download-alt"></i>
				</a>
			@endif
		</div>
	</div>
@endcomponent