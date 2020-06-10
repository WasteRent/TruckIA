<table>
    <tr>
      <td width="90%"><strong>Descripción</strong></td>
      <td width="10%"><strong>T. (hrs)</strong></td>
    </tr>
  		@foreach($repair_order->operations as $i => $operation)
  		<tr>
  		  <td width="90%">
  		  	{{$i+1}} &middot; {{ $operation->operation_name }}<br>
  		  	<small>{{ $operation->operation_description }}</small>
          @if($operation->operationAttachment)
          <br>
            <img src="{{ $operation->operationAttachment->getLink() }}">
          @endif
  		  </td>
  		  <td width="10%">{{ $operation->estimated_time_in_hours }}</td>
  		</tr>
  		@endforeach
</table>