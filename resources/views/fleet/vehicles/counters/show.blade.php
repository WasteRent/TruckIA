@if($vehicle->counters()->count() > 0)

@component('components.card')
	@slot('title', 'Contadores')
	<div>
	@foreach($vehicle->counters as $counter)
		<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
	@endforeach
	</div>
@endcomponent

@endif
