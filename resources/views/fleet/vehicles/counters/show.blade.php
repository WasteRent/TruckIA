@if($vehicle->counters()->count() > 0)

	@component('components.card')
		@slot('title', 'Mantenimientos Chasis')

		<display-more>
			<template v-slot:head>
				@foreach($vehicle->counters->where('vehicle_category', 'chassis')->sortByDesc('completedPercent')->take(5) as $counter)
					<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
				@endforeach
			</template>
			<template v-slot:body>
				@foreach($vehicle->counters->where('vehicle_category', 'chassis')->sortByDesc('completedPercent')->slice(5) as $counter)
					<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
				@endforeach
			</template>
		</display-more>
		
	@endcomponent

	@component('components.card')
		@slot('title', 'Mantenimientos Equipos')

		<display-more>
			<template v-slot:head>
				@foreach($vehicle->counters->where('vehicle_category', 'equipment')->sortByDesc('completedPercent')->take(5) as $counter)
					<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
				@endforeach
			</template>
			<template v-slot:body>
				@foreach($vehicle->counters->where('vehicle_category', 'equipment')->sortByDesc('completedPercent')->slice(5) as $counter)
					<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
				@endforeach
			</template>
		</display-more>
		
	@endcomponent

@endif
