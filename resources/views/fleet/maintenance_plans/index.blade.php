@extends('layouts.fleet')

@section('title', 'Planes de mantenimiento')

@push('styles')
<style>
	.group-header {
		cursor: pointer;
		user-select: none;
		transition: background-color 0.2s;
	}
	.group-header:hover {
		background-color: #e5e7eb !important;
	}
	.group-icon {
		transition: transform 0.2s;
		display: inline-block;
		width: 16px;
	}
</style>
@endpush

@section('content')

	@component('components.search-card')
		@include('fleet.maintenance_plans.search', ['route' => 'fleet.maintenance-plans.index'])
	@endcomponent



	@component('components.card', ['is_table' => true])
		@slot('corner')
			<div class="flex space-x-4 items-center">
				@if($groupedPlans)
				<div class="flex space-x-2">
					<button type="button" onclick="collapseAll()" class="btn-outline-gray flex items-center text-sm py-1 px-3" title="Colapsar todos los grupos">
						<i class="fas fa-compress-alt mr-2"></i>
						Colapsar todos
					</button>
					<button type="button" onclick="expandAll()" class="btn-outline-gray flex items-center text-sm py-1 px-3" title="Expandir todos los grupos">
						<i class="fas fa-expand-alt mr-2"></i>
						Expandir todos
					</button>
				</div>
				@endif
				<form class="mr-4" method="POST" action="{{ route('fleet.maintenance-plans.pdf') }}">
					@csrf
					<input type="hidden" name="plan_ids" value="3419">
					<button><i class="fas fa-file-pdf fa-2x text-red-700"></i></button>
				</form>
				@if(auth()->user()->job != 'contract_manager')
				<a href="{{ route('fleet.maintenance-plans.create') }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					Crear plan a medida
				</a>
				@endif
			</div>
		@endslot

		<table>
		  <thead>
		    <tr>
		      <th></th>
			  <th>ID</th>
		      <th>Nombre</th>
		      <th>Marca</th>
		      <th>Modelo</th>
		      <th>Den. Com.</th>
		      <th>Euro</th>
		      <th>Tipo</th>
		      <th>Frecuencia</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@if($groupedPlans)
		  		{{-- Vista agrupada --}}
			  	@foreach($groupedPlans as $groupName => $groupPlans)
			  		@php
			  			$groupId = md5($groupName);
			  		@endphp
			  		<tr class="bg-gray-100 group-header cursor-pointer hover:bg-gray-200" data-group-id="{{ $groupId }}" onclick="toggleGroup('{{ $groupId }}')">
			  			<td colspan="10" class="font-bold text-gray-700 text-sm px-4 py-3">
			  				<i class="group-icon fas fa-chevron-down mr-2" id="icon-{{ $groupId }}"></i>
			  				<i class="fas fa-folder-open mr-2"></i>
			  				{{ $groupPlans->first()->name }} ({{ $groupPlans->count() }} {{ $groupPlans->count() == 1 ? 'plan' : 'planes' }})
			  			</td>
			  		</tr>
			  		@foreach($groupPlans as $plan)
				  	<tr class="group-row group-{{ $groupId }}">
				  	  <td>
				  	  	<input class="add-plan" type="checkbox" name="plan_id[]" value="{{ $plan->id }}">
				  	  </td>
					  <td>{{ $plan->id }}</td>
				  	  <td>{{ $plan->name }}</td>
				  	  <td>{{ optional($plan->manufacturer)->name }}</td>
				  	  <td>{{ optional($plan->model)->name }}</td>
				  	  <td>{{ optional($plan->version)->name }}</td>
				  	  <td>{{ $plan->euro }}</td>
				  	  <td>{{ $plan->type == 'periodic' ? 'Periódico' : 'Sólo una vez'  }}</td>
				  	  <td>
				  	  	@if($plan->kms)
				  	  		{{ $plan->kms }} kms <br>
				  	  	@endif
				  	  	@if($plan->natural_hours)
				  	  		{{ $plan->natural_hours }} Horas Naturales <br>
				  	  	@endif
				  	  	@if($plan->work_hours)
				  	  		{{ $plan->work_hours }} Horas de Trabajo <br>
				  	  	@endif
				  	  	@if($plan->can_hours)
				  	  		{{ $plan->can_hours }} Horas CAN <br>
				  	  	@endif
				  	  	@if($plan->grua_hours)
				  	  		{{ $plan->grua_hours }} Horas Uso Grua <br>
				  	  	@endif
				  	  </td>
						<td>
			  	  	<a href="{{ route('fleet.maintenance-plans.operations.index', $plan) }}" class="mr-3">
			  	  		<i class="icon fas fa-cogs"></i>
			  	  	</a>

					@if(auth()->user()->job != 'contract_manager')
			  	  		@if(!$plan->original)
						<a href="{{ route('fleet.maintenance-plans.edit', $plan) }}" class="mr-3">
							<i class="icon fas fa-edit"></i>
						</a>
						<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.destroy', $plan) }}">
							@csrf
							@method('DELETE')
							<button><i class="icon fas fa-trash-alt"></i></button>
						</form>
						@endif
			  	  	@endif
					@if(auth()->user()->job != 'contract_manager')
			  	  	<form class="mr-3" method="POST" action="{{ route('fleet.maintenance-plans.clone', $plan) }}">
			  	  		@csrf
			  	  		<button><i class="icon fas fa-clone"></i></button>
			  	  	</form>
					@endif
			  	  </td>
				  	</tr>
			  		@endforeach
			  	@endforeach
		  	@else
		  		{{-- Vista sin agrupar --}}
		  		@foreach($plans as $plan)
			  	<tr>
			  	  <td>
			  	  	<input class="add-plan" type="checkbox" name="plan_id[]" value="{{ $plan->id }}">
			  	  </td>
				  <td>{{ $plan->id }}</td>
			  	  <td>{{ $plan->name }}</td>
			  	  <td>{{ optional($plan->manufacturer)->name }}</td>
			  	  <td>{{ optional($plan->model)->name }}</td>
			  	  <td>{{ optional($plan->version)->name }}</td>
			  	  <td>{{ $plan->euro }}</td>
			  	  <td>{{ $plan->type == 'periodic' ? 'Periódico' : 'Sólo una vez'  }}</td>
			  	  <td>
			  	  	@if($plan->kms)
			  	  		{{ $plan->kms }} kms <br>
			  	  	@endif
			  	  	@if($plan->natural_hours)
			  	  		{{ $plan->natural_hours }} Horas Naturales <br>
			  	  	@endif
			  	  	@if($plan->work_hours)
			  	  		{{ $plan->work_hours }} Horas de Trabajo <br>
			  	  	@endif
			  	  	@if($plan->can_hours)
			  	  		{{ $plan->can_hours }} Horas CAN <br>
			  	  	@endif
			  	  	@if($plan->grua_hours)
			  	  		{{ $plan->grua_hours }} Horas Uso Grua <br>
			  	  	@endif
			  	  </td>
					<td>
		  	  	<a href="{{ route('fleet.maintenance-plans.operations.index', $plan) }}" class="mr-3">
		  	  		<i class="icon fas fa-cogs"></i>
		  	  	</a>

				@if(auth()->user()->job != 'contract_manager')
		  	  		@if(!$plan->original)
					<a href="{{ route('fleet.maintenance-plans.edit', $plan) }}" class="mr-3">
						<i class="icon fas fa-edit"></i>
					</a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.destroy', $plan) }}">
						@csrf
						@method('DELETE')
						<button><i class="icon fas fa-trash-alt"></i></button>
					</form>
					@endif
		  	  	@endif
				@if(auth()->user()->job != 'contract_manager')
		  	  	<form class="mr-3" method="POST" action="{{ route('fleet.maintenance-plans.clone', $plan) }}">
		  	  		@csrf
		  	  		<button><i class="icon fas fa-clone"></i></button>
		  	  	</form>
				@endif
		  	  </td>
			  	</tr>
		  		@endforeach
		  	@endif
		  </tbody>
		</table>
	@endcomponent

	{{ $plans->appends(request()->query())->links() }}

@endsection

@push('js')
<script type="text/javascript">
	var plan_ids = []
	$('.add-plan').click(function() {
		if ($(this).is(':checked')) {
			plan_ids.push($(this).val())
		} else {
			const index = plan_ids.indexOf($(this).val());
			plan_ids.splice(index, 1)
		}

		$('input[name="plan_ids"]').val(plan_ids)
	})

	// Función para colapsar/expandir grupos
	function toggleGroup(groupId) {
		const rows = document.querySelectorAll('.group-' + groupId);
		const icon = document.getElementById('icon-' + groupId);
		const isCollapsed = rows[0].style.display === 'none';

		rows.forEach(row => {
			row.style.display = isCollapsed ? '' : 'none';
		});

		// Cambiar el icono
		if (isCollapsed) {
			icon.classList.remove('fa-chevron-right');
			icon.classList.add('fa-chevron-down');
		} else {
			icon.classList.remove('fa-chevron-down');
			icon.classList.add('fa-chevron-right');
		}

		// Guardar estado en localStorage
		saveGroupState(groupId, !isCollapsed);
	}

	// Guardar estado del grupo
	function saveGroupState(groupId, isCollapsed) {
		let collapsedGroups = JSON.parse(localStorage.getItem('collapsedMaintenanceGroups') || '{}');
		collapsedGroups[groupId] = isCollapsed;
		localStorage.setItem('collapsedMaintenanceGroups', JSON.stringify(collapsedGroups));
	}

	// Restaurar estado de los grupos al cargar la página
	function restoreGroupStates() {
		const collapsedGroups = JSON.parse(localStorage.getItem('collapsedMaintenanceGroups') || '{}');

		Object.keys(collapsedGroups).forEach(groupId => {
			if (collapsedGroups[groupId]) {
				const rows = document.querySelectorAll('.group-' + groupId);
				const icon = document.getElementById('icon-' + groupId);

				if (rows.length > 0) {
					rows.forEach(row => {
						row.style.display = 'none';
					});

					if (icon) {
						icon.classList.remove('fa-chevron-down');
						icon.classList.add('fa-chevron-right');
					}
				}
			}
		});
	}

	// Colapsar todos los grupos
	function collapseAll() {
		const groupHeaders = document.querySelectorAll('.group-header');

		groupHeaders.forEach(header => {
			const groupId = header.getAttribute('data-group-id');
			const rows = document.querySelectorAll('.group-' + groupId);
			const icon = document.getElementById('icon-' + groupId);

			rows.forEach(row => {
				row.style.display = 'none';
			});

			if (icon) {
				icon.classList.remove('fa-chevron-down');
				icon.classList.add('fa-chevron-right');
			}

			saveGroupState(groupId, true);
		});
	}

	// Expandir todos los grupos
	function expandAll() {
		const groupHeaders = document.querySelectorAll('.group-header');

		groupHeaders.forEach(header => {
			const groupId = header.getAttribute('data-group-id');
			const rows = document.querySelectorAll('.group-' + groupId);
			const icon = document.getElementById('icon-' + groupId);

			rows.forEach(row => {
				row.style.display = '';
			});

			if (icon) {
				icon.classList.remove('fa-chevron-right');
				icon.classList.add('fa-chevron-down');
			}

			saveGroupState(groupId, false);
		});
	}

	// Ejecutar al cargar la página
	$(document).ready(function() {
		restoreGroupStates();
	});
</script>
@endpush
