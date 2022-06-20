<table>
  <thead>
    <tr>
      <th class="w-full">{{ __('Descripción') }}</th>
      <th>{{ __('H. Reales') }}</th>
      <th>{{ __('Total') }}</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($repair_order->operations as $operation)
    <tr>
      <td>
        <form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.custom-operation.update', [$repair_order, $operation]) }}">
          @csrf
          @method('PUT')
          <textarea class="w-full" type="text" name="operation_name">{{ $operation->operation_name }}</textarea> 
        </form>
      </td>
      <td>
        <form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.custom-operation.update', [$repair_order, $operation]) }}">
          @csrf
          @method('PUT')
          <input class="w-20" step="any" type="number" name="real_time_in_hours" value="{{ $operation->real_time_in_hours }}">
        </form>
      </td>
      <td>
        <form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.custom-operation.update', [$repair_order, $operation]) }}">
          @csrf
          @method('PUT')
          <input class="w-20" step="any" type="number" name="amount" value="{{ $operation->amount }}">
        </form>
      </td>
    </tr>
    @endforeach
    <tr class="font-bold">
    	<td class=""><span class="font-medium">{{ __('Total') }}</span></td>
      <td class="">
        {{ number_format($repair_order->operations->sum('real_time_in_hours'), 2, ',', '.') }}
      </td>
    	<td class="">
    		{{ number_format($repair_order->operations->sum('amount'), 2, ',', '.') }}&euro;
    	</td>
    </tr>
  </tbody>
</table>