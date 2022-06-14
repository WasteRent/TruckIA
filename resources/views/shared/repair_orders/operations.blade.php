<table>
  <thead>
    <tr>
      <th>{{ __('Descripción') }}</th>
      <th>{{ __('H. Reales') }}</th>
      <th>{{ __('Total') }}</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($repair_order->operations as $operation)
    <tr>
      <td>
      	<div class="text-gray-700 py-1">
      		{{ $operation->operation_code }} &middot; {{ $operation->operation_name }}
          @if($operation->operationFile)
            <a href="{{$operation->operationFile->getLink()}}" target="_blank">
              <i class="fas fa-question-circle"></i>
            </a>
          @endif
      	</div>
      </td>
      <td class="">{{ $operation->real_time_in_hours }}</td>
      <td class="">{{ $operation->amount }}&euro;</td>
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