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
	<label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-1 text-right">
		{{$counter->max}}
		@if($counter->type == 'kms')
			Kms
		@else
			H
		@endif	
	</label>
	<div class="bg-gray-200 rounded-full">
		<div role="progressbar" aria-valuenow="{{number_format($counter->current)}}" aria-valuemin="0" aria-valuemax="{{$counter->max}}" class="{{$color}} text-xs leading-none text-center text-white rounded-full" style="padding: 1px 0px 1px 0px; width: {{ $percent > 100 ? 100 : $percent }}%">
			{{number_format($counter->current)}}h
		</div>
	</div>
</div>