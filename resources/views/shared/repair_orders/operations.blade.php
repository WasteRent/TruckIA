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
          <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" type="text" name="operation_name" rows="2">{{ $operation->operation_name }}</textarea> 
        </form>
        @if($operation->garage_observations)
          <details class="mt-2">
            <summary class="cursor-pointer text-xs font-semibold text-green-600 hover:text-green-700">{{ __('Observaciones') }}</summary>
            <div class="mt-2 p-3 text-xs text-gray-700 bg-gray-50 rounded-lg border border-gray-200">{!! $operation->garage_observations !!}</div>
          </details>
        @endif
      </td>
      <td>
        <form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.custom-operation.update', [$repair_order, $operation]) }}">
          @csrf
          @method('PUT')
          <input class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-sm text-center font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all autocomplete_price" step="any" type="number" name="real_time_in_hours" value="{{ $operation->real_time_in_hours }}">
        </form>
      </td>
      <td>
        <form class="auto_submit" method="POST" action="{{ route('fleet.repair-orders.custom-operation.update', [$repair_order, $operation]) }}">
          @csrf
          @method('PUT')
          <input class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-sm text-right font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" step="any" type="number" name="amount" value="{{ $operation->amount }}">
        </form>
      </td>
    </tr>
    @endforeach
    <tr class="bg-green-50">
    	<td class=""><span class="font-bold text-gray-900">{{ __('Total') }}</span></td>
      <td class="text-center font-bold text-green-700">
        {{ number_format($repair_order->operations->sum('real_time_in_hours'), 2, ',', '.') }} h
      </td>
    	<td class="text-right font-bold text-green-700">
    		{{ number_format($repair_order->operations->sum('amount'), 2, ',', '.') }}&euro;
    	</td>
    </tr>
  </tbody>
</table>
