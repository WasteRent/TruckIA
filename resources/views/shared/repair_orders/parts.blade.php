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
      	  <input class="w-full" type="text" name="description" value="{{ $part->description }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="" type="text" name="manufacturer" value="{{ $part->manufacturer }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="" type="text" name="reference" value="{{ $part->reference }}"/> 
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-20" type="number" step="any" name="quantity" value="{{ $part->quantity }}"/>
      	</form>
      </td>
      <td>
      	<form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.spare-parts.update', [$repair_order, $part]) }}">
      	  @csrf
      	  @method('PUT')
      	  <input class="w-20" type="number" step="any" name="total_price" value="{{ $part->total_price }}"/>
      	</form>
      </td>
    </tr>
    @endforeach
    <tr class="font-bold">
    	<td></td>
    	<td></td>
    	<td class="text-right"><span class="font-medium">{{ __('Total') }}</span></td>
    	<td class="text-right">
    		{{ number_format($repair_order->parts->sum('total_price'), 2, ',', '.') }}&euro;
    	</td>
    </tr>
  </tbody>
</table>
