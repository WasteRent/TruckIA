@if($vehicle->counters()->count() > 0)

@component('components.card')
	@slot('title', 'Mantenimientos')
	<div>
	@foreach($vehicle->counters->where('completedPercent', '>=', 75)->sortByDesc('completedPercent') as $counter)
		<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
	@endforeach
	</div>
@endcomponent

@endif
