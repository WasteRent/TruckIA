<div class="pt-4 pb-10 flex items-center justify-between">
	<img class="w-32" src="{{ asset('img/truckts_logo.png') }}">
	<div class="flex items-center">
		<a href="#" class="flex-shrink-0 group block focus:outline-none mr-8">
		  <div class="flex items-center">
		    <div>
		      <img class="inline-block h-9 w-9 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
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