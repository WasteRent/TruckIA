@extends('layouts.fleet')

@section('title', $plan->name . ' ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name . ' > Operaciones')

@section('content')

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones incluídas')
		@slot('corner')
		@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			<div class="flex items-center space-x-2">
				<button id="bulkDeleteIncludedBtn" class="btn-outline-red hidden" onclick="bulkDeleteIncluded()">
					<i class="icon fas fa-trash-alt mr-2"></i>
					Eliminar seleccionados
				</button>
				<a href="{{ route('fleet.maintenance-plans.operations.create', $plan) }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					Nuevo
				</a>
			</div>
		@endif
		@endslot

		<form id="bulkDeleteIncludedForm" method="POST" action="{{ route('fleet.maintenance-plans.operations.bulk-destroy', $plan) }}">
			@csrf
			@method('DELETE')
		</form>

		<table>
		  <thead>
		    <tr>
		      <th class="w-12">
		        <input type="checkbox" id="selectAllIncluded" onchange="toggleAllIncludedCheckboxes()" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
		      </th>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
			  				  		@if(!$operation->isRestricted())
		  		<tr>
		  		  <td>
		  		    <input type="checkbox" name="selected_operations[]" value="{{ $operation->id }}"
		  		           onchange="toggleBulkDeleteIncludedButton()"
		  		           class="operation-included-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
		  		  </td>
		  		  <td>
		  		  	@if($operation->subfamily)
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  	@endif
		  		  </td>
			  		  <td>{{ $operation->name }}</td>
			  		  <td>
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td>{{ $operation->time_in_hours }}</td>
			  		  <td>
			  		  	@if($operation->attachment)
			  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}">
			  		  			@if($operation->attachment->content_type == 'application/pdf')
			  		  				<i class="fas fa-file-pdf fa-2x text-red-700"></i>
			  		  			@else
			  		  				<img src="{{ $operation->attachment->getLink() }}">
			  		  			@endif
			  		  		</a>
			  		  	@endif
			  		  </td>
			  		  <td>
			  		  	<div class="flex">
							@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			  		  		<form class="mr-2" method="POST" action="{{ route('fleet.maintenance-plans.restrictions.update', $plan->id) }}">
			  		  			@csrf
			  		  			@method('PUT')
			  		  			<input type="hidden" name="operation_id" value="{{ $operation->id }}">
			  		  			<button class="">Excluir</button>
			  		  		</form>
							@endif
			  		  		<a href="{{ route('fleet.maintenance-plans.operations.edit', [$plan, $operation]) }}" class="mr-3">
			  		  			<i class="icon fas fa-edit"></i>
			  		  		</a>
							@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			  		  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
			  		  			@csrf
			  		  			@method('DELETE')
			  		  			<button><i class="icon fas fa-trash-alt"></i></button>
			  		  		</form>
							@endif
			  		  	</div>
			  		  </td>
			  		</tr>
			  		@endif
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones excluidas')
		@slot('corner')
		@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			<button id="bulkDeleteExcludedBtn" class="btn-outline-red hidden" onclick="bulkDeleteExcluded()">
				<i class="icon fas fa-trash-alt mr-2"></i>
				Eliminar seleccionados
			</button>
		@endif
		@endslot

		<form id="bulkDeleteExcludedForm" method="POST" action="{{ route('fleet.maintenance-plans.operations.bulk-destroy', $plan) }}">
			@csrf
			@method('DELETE')
		</form>

		<table>
		  <thead>
		    <tr>
		      <th class="w-12">
		        <input type="checkbox" id="selectAllExcluded" onchange="toggleAllExcludedCheckboxes()" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
		      </th>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
			  				  		@if($operation->isRestricted())
		  		<tr>
		  		  <td>
		  		    <input type="checkbox" name="selected_operations[]" value="{{ $operation->id }}"
		  		           onchange="toggleBulkDeleteExcludedButton()"
		  		           class="operation-excluded-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
		  		  </td>
		  		  <td>
		  		  	@if($operation->subfamily)
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  	@endif
		  		  </td>
			  		  <td>{{ $operation->name }}</td>
			  		  <td>
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td>{{ $operation->time_in_hours }}</td>
			  		  <td>
			  		  	@if($operation->attachment)
			  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}">
			  		  			@if($operation->attachment->content_type == 'application/pdf')
			  		  				<i class="fas fa-file-pdf fa-2x text-red-700"></i>
			  		  			@else
			  		  				<img src="{{ $operation->attachment->getLink() }}">
			  		  			@endif
			  		  		</a>
			  		  	@endif
			  		  </td>
			  		  <td>
			  		  	<div class="flex">
							@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			  		  		<form class="mr-2" method="POST" action="{{ route('fleet.maintenance-plans.restrictions.update', $plan->id) }}">
			  		  			@csrf
			  		  			@method('PUT')
			  		  			<input type="hidden" name="operation_id" value="{{ $operation->id }}">
			  		  			<button class="">Incluir</button>
			  		  		</form>
							@endif

			  		  		<a href="{{ route('fleet.maintenance-plans.operations.edit', [$plan, $operation]) }}" class="mr-3">
			  		  			<i class="icon fas fa-edit"></i>
			  		  		</a>
							@if(auth()->user()->job != 'contract_manager' && auth()->user()->job !== 'zone_administrator')
			  		  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
			  		  			@csrf
			  		  			@method('DELETE')
			  		  			<button><i class="icon fas fa-trash-alt"></i></button>
			  		  		</form>
							@endif
			  		  	</div>
			  		  </td>
			  		</tr>
			  		@endif
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection

@push('js')
<script>
// Functions for included operations
function toggleAllIncludedCheckboxes() {
    const selectAll = document.getElementById('selectAllIncluded');
    const checkboxes = document.querySelectorAll('.operation-included-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });

    toggleBulkDeleteIncludedButton();
}

function toggleBulkDeleteIncludedButton() {
    const checkboxes = document.querySelectorAll('.operation-included-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteIncludedBtn');
    const selectAll = document.getElementById('selectAllIncluded');
    const allCheckboxes = document.querySelectorAll('.operation-included-checkbox');

    // Show/hide bulk delete button
    if (checkboxes.length > 0) {
        bulkDeleteBtn.classList.remove('hidden');
    } else {
        bulkDeleteBtn.classList.add('hidden');
    }

    // Update select all checkbox state
    if (checkboxes.length === allCheckboxes.length) {
        selectAll.checked = true;
        selectAll.indeterminate = false;
    } else if (checkboxes.length > 0) {
        selectAll.checked = false;
        selectAll.indeterminate = true;
    } else {
        selectAll.checked = false;
        selectAll.indeterminate = false;
    }
}

function bulkDeleteIncluded() {
    const checkboxes = document.querySelectorAll('.operation-included-checkbox:checked');

    if (checkboxes.length === 0) {
        alert('Por favor selecciona al menos una operación para eliminar.');
        return;
    }

    if (!confirm(`¿Estás seguro de que quieres eliminar ${checkboxes.length} operación(es) incluída(s)? Esta acción no se puede deshacer.`)) {
        return;
    }

    const form = document.getElementById('bulkDeleteIncludedForm');

    // Add selected operation IDs to the form
    checkboxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'operation_ids[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });

    form.submit();
}

// Functions for excluded operations
function toggleAllExcludedCheckboxes() {
    const selectAll = document.getElementById('selectAllExcluded');
    const checkboxes = document.querySelectorAll('.operation-excluded-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });

    toggleBulkDeleteExcludedButton();
}

function toggleBulkDeleteExcludedButton() {
    const checkboxes = document.querySelectorAll('.operation-excluded-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteExcludedBtn');
    const selectAll = document.getElementById('selectAllExcluded');
    const allCheckboxes = document.querySelectorAll('.operation-excluded-checkbox');

    // Show/hide bulk delete button
    if (checkboxes.length > 0) {
        bulkDeleteBtn.classList.remove('hidden');
    } else {
        bulkDeleteBtn.classList.add('hidden');
    }

    // Update select all checkbox state
    if (checkboxes.length === allCheckboxes.length) {
        selectAll.checked = true;
        selectAll.indeterminate = false;
    } else if (checkboxes.length > 0) {
        selectAll.checked = false;
        selectAll.indeterminate = true;
    } else {
        selectAll.checked = false;
        selectAll.indeterminate = false;
    }
}

function bulkDeleteExcluded() {
    const checkboxes = document.querySelectorAll('.operation-excluded-checkbox:checked');

    if (checkboxes.length === 0) {
        alert('Por favor selecciona al menos una operación para eliminar.');
        return;
    }

    if (!confirm(`¿Estás seguro de que quieres eliminar ${checkboxes.length} operación(es) excluída(s)? Esta acción no se puede deshacer.`)) {
        return;
    }

    const form = document.getElementById('bulkDeleteExcludedForm');

    // Add selected operation IDs to the form
    checkboxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'operation_ids[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });

    form.submit();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleBulkDeleteIncludedButton();
    toggleBulkDeleteExcludedButton();
});
</script>
@endpush
