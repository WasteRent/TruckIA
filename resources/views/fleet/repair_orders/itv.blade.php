@component('components.card')
	@slot('title', 'ITV')

	@if($repair_order->scheduled_itv_date)
	<p>Cita ITV {{ Carbon\Carbon::parse($repair_order->scheduled_itv_date)->format('d/m/Y') }}</p>
	@endif

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
@endcomponent