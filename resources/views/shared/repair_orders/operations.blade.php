<table>
  <thead>
    <tr>
      <th>Descripción</th>
      <th>Estado</th>
      <th>H. Estimadas</th>
      <th>H. Reales</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($repair_order->operations as $operation)
    <tr>
      <td>
      	<div class="text-gray-700 py-1">
      		{{ $operation->operation_code }} &middot; {{ $operation->operation_name }}
      		<p class="text-sm text-gray-600">{{ $operation->operation_description }}</p>
      	</div>
      </td>
      <td>
      	<div class="flex items-center">
      		@if($operation->isCompleted())
      			<i class="fas fa-check fa-xs text-green-600 mr-1"></i>
      			<span class="text-xs text-gray-600 mr-2">
      				{{ Carbon\Carbon::parse($operation->completed_at)->format('d/m/Y H:i:s') }} &middot; {{ optional($operation->user)->name }}
      			</span>
      			@if($operation->file)
      				<a href="{{ $operation->file->getLink() }}">
      					<i class="fas fa-cloud-download-alt"></i>
      				</a>
      			@endif
      		@else	
      			<i class="fas fa-exclamation-circle fa-xs text-red-600 mr-1"></i>
      			Pendiente
      		@endif
      	</div>
      	<p class="text-xs mt-1">
      		{{ $operation->garage_observations }}
      	</p>
      </td>
      <td class="text-center">{{ $operation->estimated_time_in_hours }}</td>
      <td class="text-center">{{ $operation->real_time_in_hours }}</td>
      <td class="text-right">{{ $operation->getAmount() }}&euro;</td>
    </tr>
    @endforeach
    <tr>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class="text-center"><span class="font-medium">Total</span></td>
    	<td class="text-right">
    		{{ number_format($repair_order->getAmount(), 2, ',', '.') }}&euro;
    	</td>
    </tr>
  </tbody>
</table>