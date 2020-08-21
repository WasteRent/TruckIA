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
<div>
	<label class="block tracking-wide text-gray-800 text-xs font-medium mt-3 text-right">
		{{$counter->description}}
		&middot;
		@if($counter->vehicle_category == 'chassis')
			Chasis
		@else
			Equipo
		@endif	
	</label>
	<div class="bg-gray-200 rounded-full">
		<div role="progressbar" aria-valuenow="{{number_format($counter->current)}}" aria-valuemin="0" aria-valuemax="{{$counter->max}}" class="{{$color}} text-xs leading-none text-center text-white rounded-full" style="width: {{ $percent > 100 ? 100 : $percent }}%">

			@if($counter->type == 'natural_hours')
				{{number_format($counter->current/24/30, 1)}} meses
			@else
				{{number_format($counter->current)}}h 
			@endif
		</div>
	</div>
</div>