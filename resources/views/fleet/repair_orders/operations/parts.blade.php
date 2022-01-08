<div class="mt-4 rounded border border-gray-200 p-3">
	<div class="flex mb-2">
		<div class="flex items-center mr-3">
			<span class="uppercase tracking-wide text-sm text-gray-800 mr-2">Recambios</span>
			<add-part-to-repair-order
				endpoint="{{ route('fleet.repair-orders.spare-parts.store', $repair_order) }}"
				repair-order-id="{{ $repair_order->id }}"
				operation-id="{{ $operation->id }}">		
			</add-part-to-repair-order>
		</div>
	</div>

	

	@if($operation->parts()->count() > 0)
		<table>
			<thead>
				<tr>
					<th class="px-2 py-1">Descripción</th>
					<th class="px-2 py-1">Marca</th>
					<th class="px-2 py-1">Referencia</th>
					<th class="px-2 py-1">Total</th>
					<th class="px-2 py-1"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($operation->parts as $part)
				<tr>
					<td class="px-2 py-1">{{ $part->description }}</td>
					<td class="px-2 py-1">{{ $part->manufacturer }}</td>
					<td class="px-2 py-1">
						{{ $part->reference }}
						@if($part->quantity > 1)
							<span class="bg-indigo-600 rounded-full px-1 text-white text-xs">x{{ number_format($part->quantity, 0) }}</span>
						@endif

					</td>
					<td class="px-2 py-1">{{ $part->total_price }}&euro;</td>
					<td class="px-2 py-1">
						<div class="flex">
							<edit-repair-order-part 
								endpoint="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part->id]) }}"
								:current-part="{{ $part->toJson() }}"
								class="mr-2">
							</edit-repair-order-part>

							<form method="POST" action="{{ route('fleet.repair-orders.spare-parts.destroy', [ $repair_order, $part]) }}" onsubmit="return confirmDelete()">
								@csrf
								@method('DELETE')
								<button><i class="fas fa-trash-alt text-red-700"></i></button>
							</form>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>	
	@endif
</div>