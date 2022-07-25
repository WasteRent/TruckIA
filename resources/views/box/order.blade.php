@component('components.card', ['is_table' => true, 'no_shadow' => true])
	@slot('title', __('Plan de mantenimiento'))
	<table>
	  <tbody>

	  	<display-more>
	  		<template v-slot:head>
	  			@foreach($order->operations->take(5) as $operation)
	  				<tr class="w-full"><td class="w-full">{{$operation->operation_name}}</td></tr>
	  			@endforeach
	  		</template>
	  		<template v-slot:body>
	  			@foreach($order->operations->slice(5) as $operation)
	  				<tr class="w-full"><td class="w-full">{{$operation->operation_name}}</td></tr>
	  			@endforeach
	  		</template>
	  	</display-more>

	  </tbody>
	</table>
@endcomponent

@component('components.card', ['is_table' => true, 'no_shadow' => true])
	@slot('title', __('Facturación'))
	<div class="grid grid-cols-2 gap-6 p-4">
		<div class="">
			<!-- This example requires Tailwind CSS v2.0+ -->
			<button type="button" class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
			  <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
			    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
			  </svg>
			  <span class="mt-2 block text-sm font-medium text-gray-900"> Adjuntar factura </span>
			</button>
		</div>
		<div class="">
			<div class="border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-sky-600 focus-within:border-sky-600 mb-4">
			  <label for="name" class="block text-xs font-medium text-gray-900">Neto M.O</label>
			  <input type="number" step="any" name="labor" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="0,00 €">
			</div>

			<div class="border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-sky-600 focus-within:border-sky-600 mb-4">
			  <label for="name" class="block text-xs font-medium text-gray-900">Neto Recambios</label>
			  <input type="number" step="any" name="parts" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="0,00 €">
			</div>

			<p class="font-bold uppercase text-2xl">Total: <span id="total">0,00</span>€</p>
		</div>
	</div>
@endcomponent

@push('js')
<script type="text/javascript">
	$('input[name="labor"]').change(function() {
		var labor = Number($('input[name="labor"]').val())
		var parts = Number($('input[name="parts"]').val())
		var total = labor + parts
		$('#total').html(total)
	})
	$('input[name="parts"]').change(function() {
		var labor = Number($('input[name="labor"]').val())
		var parts = Number($('input[name="parts"]').val())
		var total = labor + parts
		$('#total').html(total)
	})
</script>
@endpush
