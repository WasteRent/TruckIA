@component('components.card')
	@slot('title', 'Perfil')

	{!! Form::model($user, [
		'route' => ['auth.profile.update'],
		'files' => true,
		'method' => 'PUT',
		'class' => 'w-full'
	]) !!}	
	  <div>
	    <div>
	      <div class="mt-6 sm:mt-5">
	        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
	          <label for="username" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
	            Usuario
	          </label>
	          <div class="mt-1 sm:mt-0 sm:col-span-2">
	            <div class="max-w-xs rounded-md shadow-sm">
	            	{!! Form::text('username', null, ['class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5']) !!}
	            </div>
	          </div>
	        </div>
	        <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
	          <label for="last_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
	            Nombre
	          </label>
	          <div class="mt-1 sm:mt-0 sm:col-span-2">
	            <div class="max-w-xs rounded-md shadow-sm">
	              {!! Form::text('name', null, ['class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5']) !!}
	            </div>
	          </div>
	        </div>
	        <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
	          <label for="last_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
	            Email
	          </label>
	          <div class="mt-1 sm:mt-0 sm:col-span-2">
	            <div class="max-w-xs rounded-md shadow-sm">
	              {!! Form::email('email', null, ['class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5']) !!}
	            </div>
	          </div>
	        </div>


	        <div class="mt-6 sm:mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
	          <label for="photo" class="block text-sm leading-5 font-medium text-gray-700">
	            Avatar <span class="text-xs">(600x600)</span>
	          </label>
	          <div class="mt-2 sm:mt-0 sm:col-span-2">
	            <div class="flex items-center">
	              <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">

	              	@if(Auth::user()->avatar)
	              		<img class="inline-block rounded-full" src="{{ Auth::user()->avatar->getLink() }}"/>
	              	@else
	              		<svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
	              		  <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
	              		</svg>
	              	@endif

	              </span>
	              <span class="ml-5 rounded-md shadow-sm">
	                {!! Form::file('avatar', ['class' => '']) !!}
	              </span>
	            </div>
	          </div>
	        </div>

	      </div>
	    </div>
	    <div class="text-right mt-6">
	    	<button class="btn-indigo">Guardar</button>
	    </div>
	  </div>
	{!! Form::close() !!}

@endcomponent