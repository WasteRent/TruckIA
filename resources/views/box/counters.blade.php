@if($vehicle->counters()->count() > 0)
<div class="grid sm:grid-cols-2 gap-4">
	<div class="col-span-1 flex">
		@component('components.card', ['no_shadow' => true])
			@slot('title', __('Mantenimientos chasis'))

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
	</div>
	<div class="col-span-1 flex">
		@component('components.card', ['no_shadow' => true])
			@slot('title', __('Mantenimientos equipos'))

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
	</div>
</div>
@endif
