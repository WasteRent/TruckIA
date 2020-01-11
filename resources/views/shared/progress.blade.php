<div class="flex items-center justify-center py-4 px-3">
	@foreach($steps as $step)
		<div class="relative p-1 rounded-full bg-white border-2 border-blue-800 @if($step['completed']) bg-blue-800 @endif inline-flex justify-center">
			<ion-icon class="text-xl text-white" name="ios-checkmark"></ion-icon>
			<a href="{{ $step['url'] }}" class="absolute mt-10 w-16 text-center text-gray-800 text-xs uppercase">{{ $step['name'] }}</a>
		</div>
		@if(!$loop->last)
			<div class="h-1 w-48 bg-blue-800"></div>
		@endif
	@endforeach
</div>