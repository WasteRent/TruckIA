<ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
	@foreach($repair_order->operations->groupBy('maintenance_plan_id') as $plan_ops)

	  <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow">
	    <div class="flex-1 flex flex-col p-8">
	      
	      <h3 class="text-gray-900 text-sm leading-5 font-medium h-24">
	      	{{ $plan_ops->first()->maintenance_plan_name }}
	      </h3>
	      <dl class="mt-1 flex-grow flex flex-col justify-between">
	      	<dd>
	      		<button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
	      		  Ver operaciones
	      		</button>
	      	</dd>
	      	<dd>
	      		<a href="{{ route('garage.repair-orders.operations.pdf', [$repair_order, 'plan_id' => $plan_ops->first()->maintenance_plan_id]) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
	      		  Descargar checklist
	      		</a>
	      	</dd>
	      	<dd>
	      		<button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
	      		  Recambios asociados
	      		</button>
	      	</dd>
	        <dd class="text-gray-500 text-sm leading-5 mt-4">Tiempo Estimado: 3h</dd>
	        <dd class="mt-3">
	          <span class="px-2 py-1 text-green-800 text-xs leading-4 font-medium bg-green-200 rounded-full">Completado</span>
	        </dd>
	      </dl>
	    </div>
	  </li>

	@endforeach
</ul>

