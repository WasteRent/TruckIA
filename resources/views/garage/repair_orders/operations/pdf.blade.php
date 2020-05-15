<table>
  <thead>
    <tr>
      <th><strong>Descripción</strong></th>
      <th><strong>Tiempo (hrs)</strong></th>
    </tr>
  </thead>
  <tbody>
  		@foreach($repair_order->operations as $operation)
  		<tr>
  		  <td>
  		  	> {{ $operation->operation_name }}<br>
  		  	<small>{{ $operation->operation_description }}</small>
  		  </td>
  		  <td>{{ $operation->estimated_time_in_hours }}</td>
  		</tr>
  		@endforeach
  </tbody>
</table>