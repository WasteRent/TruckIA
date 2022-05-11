<div class="flex items-center justify-center py-4 px-3">
	@foreach($steps as $step)
		<a href="{{ $step['url'] }}">
			<div class="relative p-2 rounded-full bg-white border-2 border-blue-700 @if(isset($step['active']) && $step['active']) bg-blue-700 @endif inline-flex justify-center">

				@if(isset($step['warning']) && $step['warning'] == true && $step['active'] == false)
					<i class="fas fa-exclamation-circle text-red-600"></i>
				@else
					<i class="@if(isset($step['icon'])) {{ $step['icon'] }} @endif @if(isset($step['active']) && $step['active']) text-white @else text-gray-600 @endif text-xs"></i>
				@endif
				
				<div class="hidden sm:block absolute mt-8 w-16 text-center @if(isset($step['active']) && $step['active']) text-gray-800 font-medium @endif text-gray-600 text-xs uppercase">
					<span>{{ $step['name'] }}</span>
				</div>

			</div>
		</a>
		@if(!$loop->last)
			<div class="h-1 w-full bg-blue-700"></div>
		@endif
	@endforeach
</div>