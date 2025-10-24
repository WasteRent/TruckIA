<table>
  <thead>
    <tr>
      <th class="w-full">{{ __('Descripción') }}</th>
      <th>{{ __('Marca') }}</th>
      <th>{{ __('Referencia') }}</th>
      <th>{{ __('Cantidad') }}</th>
      <th>{{ __('Total') }}</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($repair_order->parts as $part)
    <tr>
      <td class="w-full">
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="text" name="description" value="{{ $part->description }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="text" name="manufacturer" value="{{ $part->manufacturer }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="text" name="reference" value="{{ $part->reference }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-sm text-center font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="number" step="any" name="quantity" value="{{ $part->quantity }}"/>
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-28 px-3 py-2 border border-gray-300 rounded-lg text-sm text-right font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="number" step="any" name="total_price" value="{{ $part->total_price }}"/>
      	</form>
      </td>
    </tr>
    @endforeach
    <tr class="bg-green-50">
    	<td></td>
    	<td></td>
    	<td></td>
    	<td class="text-right"><span class="font-bold text-gray-900">{{ __('Total') }}</span></td>
    	<td class="text-right font-bold text-green-700">
    		{{ number_format($repair_order->parts->sum('total_price'), 2, ',', '.') }}&euro;
    	</td>
    </tr>
  </tbody>
</table>
