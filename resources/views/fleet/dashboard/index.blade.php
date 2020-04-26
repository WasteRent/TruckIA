@extends('layouts.fleet')

@section('content')
	
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($counters as $counter) 	
		<a href="{{ route('fleet.vehicles.show', $counter->vehicle) }}">
			<div class="bg-white overflow-hidden shadow rounded-lg">
			  <div class="px-4 py-5">
				<div class="flex justify-between">
					<div class="text-2xl leading-8 font-semibold text-gray-900">
						{{ $counter->vehicle->plate }}
						<div class="text-xs ">
							{{ $counter->vehicle->chassis }}
						</div>
					</div>

					<img class="w-16 h-16 rounded mb-2" src="{{ optional($counter->vehicle->cover)->getLink() }}">
				</div>
				@include('fleet.vehicles.counters.progress')
			  </div>
			</div>
		</a>
	@endforeach
	</div>

@endsection
