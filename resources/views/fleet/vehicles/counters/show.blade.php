@if($vehicle->counters()->count() > 0)

@component('components.card')
	@slot('title', 'Mantenimientos')

	<display-more>
		<template v-slot:head>
			@foreach($vehicle->counters->sortByDesc('completedPercent')->take(5) as $counter)
				<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
			@endforeach
		</template>
		<template v-slot:body>
			@foreach($vehicle->counters->sortByDesc('completedPercent')->slice(5) as $counter)
				<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
			@endforeach
		</template>
	</display-more>
	
@endcomponent

@endif
