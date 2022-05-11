@component('components.card', ['is_table' => true])
	@slot('title')
		<div class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
			</svg>
			<span>{{ __('Actividad reciente') }}</span>
		</div>
	@endslot
	@slot('corner')
		<a class="text-xs flex items-center text-blue-700" href="{{ route('fleet.feed.index') }}">
			<span class="mr-2">Ver más</span>
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
			</svg>
		</a>
	@endslot
	<ul role="list" class="divide-y divide-gray-200">
		@foreach($latest_activity as $item)
		  <li class="py-2 px-2 flex">
		  	@if($item->user && $item->user->avatar)
		  	  <img loading="lazy" class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="{{ $item->user->avatar->getLink() }}"/>
		  	@else
		  	  <svg class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" fill="currentColor" viewBox="0 0 24 24">
		  	    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
		  	  </svg>                
		  	@endif
		    <div class="ml-3">
		      <p class="text-sm text-gray-900">{{ $item->title }}</p>
		      <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
		    </div>
		  </li>
		@endforeach
	</ul>
@endcomponent