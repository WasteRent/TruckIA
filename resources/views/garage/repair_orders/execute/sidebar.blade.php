@foreach($repair_order->operations->groupBy('family_id') as $operations)
	<h1 class="font-medium uppercase text-xs tracking-wide text-gray-600">{{ $operations->first()->family->name }}</h1>
	<ul class="text-sm mb-8">
		@foreach($operations as $operation)
			<li class="pl-4 {{ $current_operation->id == $operation->id ? 'font-bold text-blue-800' : 'text-gray-700' }}">
				<a href="{{ route('garage.show.operation', [$repair_order, $operation]) }}">
					@if($operation->pivot->completed)
						<i class="fas fa-check fa-xs mr-1"></i>
						<span class="line-through text-gray-600">{{ $operation->name }}</span>
					@else
						<span class="mr-1">&middot;</span>
						{{ $operation->name }}
					@endif
				</a>
			</li>
		@endforeach
	</ul>
@endforeach



