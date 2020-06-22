<div class="flex items-center justify-center py-4 px-3">
	@foreach($steps as $step)
		<a href="{{ $step['url'] }}">
			<div class="relative p-2 rounded-full bg-white border-2 border-blue-800 @if(isset($step['active']) && $step['active']) bg-blue-800 @endif inline-flex justify-center">

				<i class="@if(isset($step['icon'])) {{ $step['icon'] }} @endif @if(isset($step['active']) && $step['active']) text-white @else text-gray-600 @endif text-xs"></i>
				
				<span class="hidden sm:block absolute mt-8 w-16 text-center  @if(isset($step['active']) && $step['active']) text-gray-800 font-medium @endif text-gray-600 text-xs uppercase">
					{{ $step['name'] }}
				</span>

			</div>
		</a>
		@if(!$loop->last)
			<div class="h-1 w-48 bg-blue-800"></div>
		@endif
	@endforeach
</div>