<div class="pt-4 pb-10 flex items-center justify-between">
	@if(Auth::user()->hasRole('fleet') && Auth::user()->fleet->logo)
		<img class="w-32" src="{{ Auth::user()->fleet->logo }}">
	@else
		<img class="w-32" src="{{ asset('img/truckts_logo.png') }}">
	@endif

	<div class="flex items-center">
		<a href="{{ route('auth.profile.index') }}" class="flex-shrink-0 group block focus:outline-none mr-8">
		  <div class="flex items-center">
		    <div>
		    	@if(Auth::user()->avatar)
		    		<img class="inline-block h-9 w-9 rounded-full" src="{{ Auth::user()->avatar->getLink() }}"/>
		    	@else
		    		<span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-400">
		    		  <span class="text-lg font-medium leading-none text-white uppercase">
		    		  	{{ Str::limit(Auth::user()->name, 1, '') }}
		    		  </span>
		    		</span>
		    	@endif
		    </div>
		    <div class="ml-3">
		      <p class="text-sm leading-5 font-medium text-gray-700 group-hover:text-gray-900">
		        {{ Auth::user()->name }}
		      </p>
		      <p class="text-xs leading-4 font-medium text-gray-500 group-hover:text-gray-700 group-focus:underline transition ease-in-out duration-150">
		        Perfil
		      </p>
		    </div>
		  </div>
		</a>
		<form method="POST" action="{{ route('logout') }}">
			@csrf
			<button><i class="fas fa-power-off"></i></button>
		</form>
	</div>
</div>