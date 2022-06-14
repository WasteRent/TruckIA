
	<table>
	  <thead>
	    <tr>
	      <th class="w-full">{{ __('Descripción') }}</th>
	      <th>{{ __('Marca') }}</th>
	      <th>{{ __('Referencia') }}</th>
	      <th class="text-right">{{ __('Precio unitario') }}</th>
	      <th class="text-right">{{ __('Total') }}</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($repair_order->parts as $part)
	    <tr>
	      <td class="w-full">{{ $part->description }}</td>
	      <td>{{ $part->manufacturer }}</td>
	      <td>{{ $part->reference }}</td>
	      <td class="text-right">
	      	{{ $part->unit_price }}&euro;
	      	@if($part->quantity > 1)
	      		<span class="bg-indigo-600 rounded-full px-1 text-white text-xs">x{{ number_format($part->quantity, 0) }}</span>
	      	@endif
	      </td>
	      <td class="text-right">{{ $part->total_price }}&euro;</td>
	    </tr>
	    @endforeach
	    <tr class="font-bold">
	    	<td></td>
	    	<td></td>
	    	<td></td>
	    	<td class="text-right"><span class="font-medium">{{ __('Total') }}</span></td>
	    	<td class="text-right">
	    		{{ number_format($repair_order->parts->sum('total_price'), 2, ',', '.') }}&euro;
	    	</td>
	    </tr>
	  </tbody>
	</table>
