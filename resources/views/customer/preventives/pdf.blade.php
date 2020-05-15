<ul>
@foreach($preventive->operations as $operation)
	<li>
		<p><strong>{{ $operation->operation_name }}</strong> <small>{{ $operation->operation_description }}</small></p>
	</li>
@endforeach
</ul>