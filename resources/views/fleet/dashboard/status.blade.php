<h4 class="text-3xl leading-6 font-medium text-gray-900 mt-8">{{ __('Flota') }}</h4>
<small class="text-gray-500 mt-2">* {{ __('Estado de la flota por tipo y marca') }}.</small>

<div class="flex flex-wrap mt-8">
@foreach($status as $typeGroup)
	<div class="p-1">
		<a href="#{{ $typeGroup->first()[0]['type']['id'] }}">
			<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">{{ __($typeGroup->first()[0]['type']['name']) }} ({{ $typeGroup->sum(fn($i) => $i->count()) }})</span>
		</a>
	</div>
@endforeach
</div>

@foreach($status as $typeGroup)
	<div class="relative mb-4 mt-8" id="{{ $typeGroup->first()[0]['type']['id'] }}">
	  <div class="absolute inset-0 flex items-center" aria-hidden="true">
	    <div class="w-full border-t border-gray-300"></div>
	  </div>
	  <div class="relative flex justify-start">
	    <span class="pr-3 bg-gray-100 text-lg text-gray-800">{{ __($typeGroup->first()[0]['type']['name']) }} ({{ $typeGroup->sum(fn($i) => $i->count()) }})</span>
	  </div>
	</div>


	<div class="mb-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-6 justify-evenly">
	@foreach($typeGroup as $makerGroup)

		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-3 pt-5">
			<div class="font-medium text-blue-900">
				{{$makerGroup[0]['maker']}}
				<p class="text-xs text-gray-700 my-2">Total: {{ count($makerGroup) }}</p>
			</div>
				
			<div class="pb-3 text-xs">
				<ul class="text-blue-700">
				@foreach(collect($makerGroup)->groupBy('state.name') as $stateGroup)
					<li class="flex justify-between">
						<span>{{$stateGroup[0]['state']['name']}}</span> <span>({{count($stateGroup)}}) {{ number_format(count($stateGroup) / count($makerGroup) * 100, 2)  }}%</span>
					</li>
				@endforeach
				</ul>
			</div>
		
		  </div>
		</div>
	@endforeach
	</div>
@endforeach