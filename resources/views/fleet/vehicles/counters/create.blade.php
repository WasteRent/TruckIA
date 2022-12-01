@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Nuevo contador ' . $vehicle->plate)

		{!! Form::open([
		  'route' => ['fleet.vehicles.counters.store', $vehicle],
		  'method' => 'POST',
		  'files' => true,
		  'class' => 'w-full'
		]) !!}  


		  @include('fleet.vehicles.counters.form')


		  <p class="mb-2">Listado de operaciones (opcional)</p>

		  <div id="plan-operations">
		  	<div class="form-line flex flex-wrap items-center -mx-3 mb-2">
		  	  <div class="w-full md:w-11/12 px-3 mb-6 md:mb-0">
		  	    <label class="form-label" >
		  	      {{ __('Operación') }}
		  	    </label>
		  	    {!! Form::text('operations[]', null, ['class' => 'form-input']) !!}
		  	  </div>
		  	  <i class="mt-6 fas fa-times remove-operation-line text-red-700 cursor-pointer"></i>
		  	</div>
		  </div>

		  <div class="flex space-x-10 pt-1">
		  	<span class="text-blue-700 flex items-center cursor-pointer" id="add-operation-line">
		  		<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
		  		  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
		  		</svg>
		  		<span>Añadir más operaciones</span>
		  	</span>
		  </div>

		  <div class="flex justify-end">
		    <button class="btn-indigo">Guardar</button>
		  </div>

		{!! Form::close() !!}
	@endcomponent

@endsection

@push('js')
<script type="text/javascript">
	$('#add-operation-line').click(function(e) {
		$('#plan-operations').append(`<div class="form-line flex flex-wrap items-center -mx-3 mb-2">
		  	  <div class="w-full md:w-11/12 px-3 mb-6 md:mb-0">
		  	    <label class="form-label" >
		  	      {{ __('Operación') }}
		  	    </label>
		  	    {!! Form::text('operations[]', null, ['class' => 'form-input']) !!}
		  	  </div>
		  	  <i class="mt-6 fas fa-times remove-operation-line text-red-700 cursor-pointer"></i>
		  	</div>`);
	})

	$('#plan-operations').on('click', '.remove-operation-line', function() {
		$(this).parent('.form-line').remove()
	});
</script>
@endpush