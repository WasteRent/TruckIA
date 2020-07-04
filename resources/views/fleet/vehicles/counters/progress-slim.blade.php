@if($counter)

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

<div class="rounded-full bg-gray-200">
	<div role="progressbar" aria-valuenow="{{number_format($counter->current)}}" aria-valuemin="0" aria-valuemax="{{$counter->max}}" class="{{$color}} h-3 text-xs leading-none text-center text-white rounded-full" style="width: {{ $percent > 100 ? 100 : $percent }}%">

		<div class="font-medium" style="font-size: 0.7rem;">
			{{number_format($counter->current)}}
			@if($counter->type == 'natural_hours')
				H
			@elseif($counter->type == 'work_hours')
				H
			@elseif($counter->type == 'kms')
				kms
			@endif
		</div>

	</div>
</div>

@endif