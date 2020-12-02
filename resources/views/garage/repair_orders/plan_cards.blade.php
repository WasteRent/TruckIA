<ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
	@foreach($repair_order->operations->groupBy('maintenance_plan_id') as $plan_ops)

	  <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow">
	    <div class="flex-1 flex flex-col p-8">
	      
	      <h3 class="text-gray-900 text-sm leading-5 font-medium h-24">
	      	{{ $plan_ops->first()->maintenance_plan_name }}
	      </h3>
	      <dl class="mt-1 flex-grow flex flex-col justify-between">
	      	<dd>
	      		<a href="{{ route('garage.show.operation', [$repair_order, 'plan_id' => $plan_ops->first()->maintenance_plan_id]) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:ring-indigo-100 active:bg-indigo-200 transition ease-in-out duration-150">
	      		  Ver operaciones
	      		</a>
	      	</dd>
	      	<dd>
	      		<a href="{{ route('garage.repair-orders.operations.pdf', [$repair_order, 'plan_id' => $plan_ops->first()->maintenance_plan_id]) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:ring-indigo-100 active:bg-indigo-200 transition ease-in-out duration-150">
	      		  Descargar checklist
	      		</a>
	      	</dd>
	      	<dd>	      		  
	      		<show-plan-spare-parts :parts="{{ $repair_order->parts->toJson() }}"></show-plan-spare-parts>
	      	</dd>
	        <dd class="text-gray-500 text-sm leading-5 mt-4">Tiempo Estimado: ?h</dd>
	        <dd class="text-gray-500 text-sm leading-5 mt-4">
	        	<div class="flex items-center justify-center">
	        		<span>Tiempo Real:</span>
	        		@if($plan_ops->first()->maintenance_plan_id)
		        		<div>
		        			<form method="POST" action="{{ route('garage.repair-orders.plan.finish', [$repair_order, $plan_ops->first()->maintenance_plan_id]) }}">
		        				@csrf
			        			<input required type="number" name="finish_total_time" class="w-15 px-2 border-b mr-1" value="{{ $plan_ops->sum('real_time_in_hours') }}">h
			        			<button><i class="fas fa-save fa-lg"></i></button>
		        			</form>
		        		</div>
	        		@endif
	        	</div>
	        </dd>
	        <dd class="mt-3">
	        	@if($plan_ops->whereNull('completed_at')->isEmpty())
	        		<span class="px-2 py-1 text-green-800 text-xs leading-4 font-medium bg-green-200 rounded-full">
	        			Completado  {{$plan_ops->whereNotNull('completed_at')->count()}}/{{$plan_ops->count()}}
	        		</span>
	        	@else
		        	<span class="px-2 py-1 text-red-800 text-xs leading-4 font-medium bg-red-200 rounded-full">
		        		Pendiente {{$plan_ops->whereNotNull('completed_at')->count()}}/{{$plan_ops->count()}}
		        	</span>
	        	@endif
	        </dd>
	      </dl>
	    </div>
	  </li>

	@endforeach
</ul>

