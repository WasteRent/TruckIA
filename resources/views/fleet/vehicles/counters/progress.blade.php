@php
	$percent = ($counter->current / $counter->max) * 100;
	$color = 'progress-bar-step1';
	if($percent > 70 && $percent < 90) {
		$color = 'progress-bar-step2';
	} elseif($percent > 90 && $percent < 100) {
		$color = 'progress-bar-step3';
	} elseif($percent > 100) {
		$color = 'bg-red-500';
	} 
@endphp
<div class="mb-1">
	<label class="block flex items-center">
		<span class="tracking-wide text-gray-600 text-xs font-medium ">{{$counter->description}}</span>
		@if($counter->plan)
		<modal-card>
			<template v-slot:head>
				<button class="ml-2">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-700">
					  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
					</svg>
				</button>
			</template>
			<template v-slot:body>
				<h1 class="font-bold text-2xl">{{ $counter->plan->name }}</h1>
				<ul class="text-gray-600 text-sm list-decimal px-3">
				@foreach($counter->plan->operations as $operation)
					<li>{{ $operation->name }}</li>
				@endforeach
				</ul>
			</template>
		</modal-card>
		@endif
	</label>
	<div class="bg-gray-200 rounded-full">
		<div role="progressbar" aria-valuenow="{{number_format($counter->current)}}" aria-valuemin="0" aria-valuemax="{{$counter->max}}" class="{{$color}} text-xs leading-none text-center text-white rounded-full" style="width: {{ $percent > 100 ? 100 : $percent }}%">

			@if($counter->type == 'natural_hours')
				{{number_format($counter->current/24/30, 1)}} {{ __('meses') }}
			@elseif($counter->type == 'kms')
			{{number_format($counter->current)}} km
			@else
				{{number_format($counter->current)}} h 
			@endif
		</div>
	</div>
</div>