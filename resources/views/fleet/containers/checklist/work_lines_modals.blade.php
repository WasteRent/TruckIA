@push('head')
<style>
	#add-labor-modal.show .work-line-modal-content,
	#add-part-modal.show .work-line-modal-content,
	#edit-labor-modal.show .work-line-modal-content,
	#edit-part-modal.show .work-line-modal-content {
		transform: translateY(0) !important;
	}
	@media (min-width: 640px) {
		#add-labor-modal.show .work-line-modal-content,
		#add-part-modal.show .work-line-modal-content,
		#edit-labor-modal.show .work-line-modal-content,
		#edit-part-modal.show .work-line-modal-content {
			transform: translate(-50%, -50%) scale(1) !important;
		}
	}
</style>
@endpush

<!-- Modal Añadir mano de obra -->
<div id="add-labor-modal" class="fixed inset-0 z-50 hidden">
	<div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeAddLaborModal()"></div>
	<div class="work-line-modal-content absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl sm:rounded-2xl sm:bottom-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:max-w-md sm:w-full transform transition-transform duration-300 translate-y-full sm:translate-y-0 sm:scale-95 max-h-[90vh] overflow-y-auto">
		<div class="sm:hidden flex justify-center pt-3 pb-2">
			<div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
		</div>
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
			<h3 class="text-lg font-semibold text-gray-900">{{ __('Añadir mano de obra') }}</h3>
			<button type="button" onclick="closeAddLaborModal()" class="p-2 hover:bg-gray-100 rounded-full">
				<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>
		<form method="POST" action="{{ route('fleet.container-checklists.work-lines.store', [$container_checklist]) }}" class="js-no-button-spinner p-6">
			@csrf
			<input type="hidden" name="line_type" value="labor">
			<div class="mb-4">
				<label for="add-labor-description" class="form-label form-required">{{ __('Descripción') }}</label>
				<input type="text" id="add-labor-description" name="description" class="form-input w-full" required maxlength="500">
			</div>
			<div class="mb-6">
				<label for="add-labor-hours" class="form-label form-required">{{ __('Horas') }}</label>
				<input type="number" id="add-labor-hours" name="time_in_hours" class="form-input w-full" step="0.01" min="0" required>
			</div>
			<div class="flex gap-3">
				<button type="button" onclick="closeAddLaborModal()" class="btn-outline-gray flex-1 py-3">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo flex-1 py-3">{{ __('Añadir') }}</button>
			</div>
		</form>
	</div>
</div>

<!-- Modal Añadir recambio -->
<div id="add-part-modal" class="fixed inset-0 z-50 hidden">
	<div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeAddPartModal()"></div>
	<div class="work-line-modal-content absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl sm:rounded-2xl sm:bottom-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:max-w-md sm:w-full transform transition-transform duration-300 translate-y-full sm:translate-y-0 sm:scale-95 max-h-[90vh] overflow-y-auto">
		<div class="sm:hidden flex justify-center pt-3 pb-2">
			<div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
		</div>
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
			<h3 class="text-lg font-semibold text-gray-900">{{ __('Añadir recambio') }}</h3>
			<button type="button" onclick="closeAddPartModal()" class="p-2 hover:bg-gray-100 rounded-full">
				<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>
		<form method="POST" action="{{ route('fleet.container-checklists.work-lines.store', [$container_checklist]) }}" class="js-no-button-spinner p-6">
			@csrf
			<input type="hidden" name="line_type" value="part">
			<div class="mb-4">
				<label for="add-part-description" class="form-label form-required">{{ __('Descripción') }}</label>
				<input type="text" id="add-part-description" name="description" class="form-input w-full" required maxlength="500">
			</div>
			<div class="mb-6">
				<label for="add-part-price" class="form-label">{{ __('Precio (€)') }}</label>
				<input type="number" id="add-part-price" name="price" class="form-input w-full" step="0.01" min="0">
			</div>
			<div class="flex gap-3">
				<button type="button" onclick="closeAddPartModal()" class="btn-outline-gray flex-1 py-3">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo flex-1 py-3">{{ __('Añadir') }}</button>
			</div>
		</form>
	</div>
</div>

<!-- Modal Editar mano de obra -->
<div id="edit-labor-modal" class="fixed inset-0 z-50 hidden">
	<div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeEditLaborModal()"></div>
	<div class="work-line-modal-content absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl sm:rounded-2xl sm:bottom-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:max-w-md sm:w-full transform transition-transform duration-300 translate-y-full sm:translate-y-0 sm:scale-95 max-h-[90vh] overflow-y-auto">
		<div class="sm:hidden flex justify-center pt-3 pb-2">
			<div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
		</div>
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
			<h3 class="text-lg font-semibold text-gray-900">{{ __('Editar mano de obra') }}</h3>
			<button type="button" onclick="closeEditLaborModal()" class="p-2 hover:bg-gray-100 rounded-full">
				<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>
		<form id="edit-labor-form" method="POST" action="" class="js-no-button-spinner p-6">
			@csrf
			@method('PUT')
			<div class="mb-4">
				<label for="edit-labor-description" class="form-label form-required">{{ __('Descripción') }}</label>
				<input type="text" id="edit-labor-description" name="description" class="form-input w-full" required maxlength="500">
			</div>
			<div class="mb-6">
				<label for="edit-labor-hours" class="form-label form-required">{{ __('Horas') }}</label>
				<input type="number" id="edit-labor-hours" name="time_in_hours" class="form-input w-full" step="0.01" min="0" required>
			</div>
			<div class="flex gap-3">
				<button type="button" onclick="closeEditLaborModal()" class="btn-outline-gray flex-1 py-3">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo flex-1 py-3">{{ __('Guardar') }}</button>
			</div>
		</form>
	</div>
</div>

<!-- Modal Editar recambio -->
<div id="edit-part-modal" class="fixed inset-0 z-50 hidden">
	<div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeEditPartModal()"></div>
	<div class="work-line-modal-content absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl sm:rounded-2xl sm:bottom-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:max-w-md sm:w-full transform transition-transform duration-300 translate-y-full sm:translate-y-0 sm:scale-95 max-h-[90vh] overflow-y-auto">
		<div class="sm:hidden flex justify-center pt-3 pb-2">
			<div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
		</div>
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
			<h3 class="text-lg font-semibold text-gray-900">{{ __('Editar recambio') }}</h3>
			<button type="button" onclick="closeEditPartModal()" class="p-2 hover:bg-gray-100 rounded-full">
				<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>
		<form id="edit-part-form" method="POST" action="" class="js-no-button-spinner p-6">
			@csrf
			@method('PUT')
			<div class="mb-4">
				<label for="edit-part-description" class="form-label form-required">{{ __('Descripción') }}</label>
				<input type="text" id="edit-part-description" name="description" class="form-input w-full" required maxlength="500">
			</div>
			<div class="mb-6">
				<label for="edit-part-price" class="form-label">{{ __('Precio (€)') }}</label>
				<input type="number" id="edit-part-price" name="price" class="form-input w-full" step="0.01" min="0">
			</div>
			<div class="flex gap-3">
				<button type="button" onclick="closeEditPartModal()" class="btn-outline-gray flex-1 py-3">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo flex-1 py-3">{{ __('Guardar') }}</button>
			</div>
		</form>
	</div>
</div>

@push('js')
<script>
(function() {
	var updateUrlTemplate = "{{ route('fleet.container-checklists.work-lines.update', [$container_checklist, 0]) }}";

	function showModal(id) {
		var el = document.getElementById(id);
		if (el) {
			el.classList.remove('hidden');
			el.classList.add('show');
			document.body.style.overflow = 'hidden';
		}
	}
	function hideModal(id) {
		var el = document.getElementById(id);
		if (el) {
			el.classList.add('hidden');
			el.classList.remove('show');
			document.body.style.overflow = '';
		}
	}

	window.openLaborLineModal = function() {
		showModal('add-labor-modal');
	};
	window.closeAddLaborModal = function() {
		hideModal('add-labor-modal');
	};
	window.openPartLineModal = function() {
		showModal('add-part-modal');
	};
	window.closeAddPartModal = function() {
		hideModal('add-part-modal');
	};

	window.openEditLaborLineModal = function(lineId, description, timeInHours) {
		var form = document.getElementById('edit-labor-form');
		if (form) {
			form.action = updateUrlTemplate.replace(/\/0$/, '/' + lineId);
		}
		document.getElementById('edit-labor-description').value = description || '';
		document.getElementById('edit-labor-hours').value = timeInHours != null ? timeInHours : '';
		showModal('edit-labor-modal');
	};
	window.closeEditLaborModal = function() {
		hideModal('edit-labor-modal');
	};
	window.openEditPartLineModal = function(lineId, description, price) {
		var form = document.getElementById('edit-part-form');
		if (form) {
			form.action = updateUrlTemplate.replace(/\/0$/, '/' + lineId);
		}
		document.getElementById('edit-part-description').value = description || '';
		document.getElementById('edit-part-price').value = price != null ? price : '';
		showModal('edit-part-modal');
	};
	window.closeEditPartModal = function() {
		hideModal('edit-part-modal');
	};

	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape') {
			closeAddLaborModal();
			closeAddPartModal();
			closeEditLaborModal();
			closeEditPartModal();
		}
	});
})();
</script>
@endpush
