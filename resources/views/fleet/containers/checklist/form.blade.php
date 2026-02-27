@php
    $totalItems = $container_checklist->items->count();
    $checkedItems = $container_checklist->items->where('is_checked', true)->count();
@endphp

<!-- Barra de progreso -->
<div class="mb-6 bg-gray-100 rounded-xl p-4">
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-medium text-gray-700">{{ __('Progreso') }}</span>
        <span class="text-sm font-bold text-gray-900" id="checklist-progress-text">{{ $checkedItems }}/{{ $totalItems }}</span>
    </div>
    <div class="w-full bg-gray-300 rounded-full h-3 overflow-hidden">
        <div id="checklist-progress-bar" class="h-3 rounded-full transition-all duration-300 {{ $checkedItems == $totalItems ? 'bg-green-600' : 'bg-green-400' }}" style="width: {{ $totalItems > 0 ? ($checkedItems / $totalItems * 100) : 0 }}%"></div>
    </div>
</div>

@foreach ($container_checklist->items->groupBy('checklistItem.category') as $category => $items)
    <div class="mb-6">
        <!-- Cabecera de categoría -->
        <div class="flex items-center mb-3">
            <div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
            <h3 class="text-base font-semibold text-gray-900">{{ $category }}</h3>
            <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $items->count() }} items</span>
        </div>

        <!-- Items de checklist -->
        <div class="space-y-2">
            @foreach ($items as $item)
                <label class="checklist-item block cursor-pointer select-none" data-item-id="{{ $item->id }}">
                    <input
                        type="checkbox"
                        name="items[{{ $item->id }}]"
                        value="1"
                        {{ $item->is_checked ? 'checked' : '' }}
                        class="hidden checklist-checkbox"
                    >
                    <div class="checklist-card flex items-center p-4 rounded-xl border-2 transition-all duration-200
                        {{ $item->is_checked ? 'bg-green-50 border-green-300' : 'bg-white border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}
                        active:scale-[0.98]">

                        <!-- Checkbox visual -->
                        <div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center transition-all duration-200
                            {{ $item->is_checked ? 'bg-green-500' : 'bg-gray-200' }}">
                            <svg class="w-4 h-4 text-white transition-transform duration-200 {{ $item->is_checked ? 'scale-100' : 'scale-0' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>

                        <!-- Descripción -->
                        <span class="ml-4 flex-1 text-sm font-medium transition-colors duration-200
                            {{ $item->is_checked ? 'text-green-800' : 'text-gray-700' }}">
                            {{ $item->checklistItem->description }}
                        </span>

                        <!-- Indicador de estado -->
                        <div class="flex-shrink-0 ml-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full transition-all duration-200
                                {{ $item->is_checked ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                @if($item->is_checked)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                @endif
                            </span>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>
@endforeach

@include('fleet.containers.checklist.work_lines_list')

<!-- Observaciones -->
<div class="mt-6">
    <label for="observations" class="block text-sm font-semibold text-gray-900 mb-2">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            {{ __('Observaciones') }}
        </span>
    </label>
    <x-trix name="observations">
        {{ $container_checklist->observations }}
    </x-trix>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checklistItems = document.querySelectorAll('.checklist-item');
    const totalItems = {{ $totalItems }};

    checklistItems.forEach(item => {
        const checkbox = item.querySelector('.checklist-checkbox');
        const card = item.querySelector('.checklist-card');
        const checkIcon = card.querySelector('.w-7 svg');
        const checkBox = card.querySelector('.w-7');
        const description = card.querySelector('span.flex-1');
        const statusIcon = card.querySelector('.w-6');

        item.addEventListener('click', function(e) {
            e.preventDefault();
            checkbox.checked = !checkbox.checked;
            updateItemVisual(card, checkBox, checkIcon, description, statusIcon, checkbox.checked);
            updateProgress();
        });
    });

    function updateItemVisual(card, checkBox, checkIcon, description, statusIcon, isChecked) {
        if (isChecked) {
            card.classList.remove('bg-white', 'border-gray-200', 'hover:border-gray-300', 'hover:bg-gray-50');
            card.classList.add('bg-green-50', 'border-green-300');
            checkBox.classList.remove('bg-gray-200');
            checkBox.classList.add('bg-green-500');
            checkIcon.classList.remove('scale-0');
            checkIcon.classList.add('scale-100');
            description.classList.remove('text-gray-700');
            description.classList.add('text-green-800');
            statusIcon.classList.remove('bg-gray-100', 'text-gray-400');
            statusIcon.classList.add('bg-green-100', 'text-green-600');
            statusIcon.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
        } else {
            card.classList.add('bg-white', 'border-gray-200', 'hover:border-gray-300', 'hover:bg-gray-50');
            card.classList.remove('bg-green-50', 'border-green-300');
            checkBox.classList.add('bg-gray-200');
            checkBox.classList.remove('bg-green-500');
            checkIcon.classList.add('scale-0');
            checkIcon.classList.remove('scale-100');
            description.classList.add('text-gray-700');
            description.classList.remove('text-green-800');
            statusIcon.classList.add('bg-gray-100', 'text-gray-400');
            statusIcon.classList.remove('bg-green-100', 'text-green-600');
            statusIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>';
        }
    }

    function updateProgress() {
        const checkedCount = document.querySelectorAll('.checklist-checkbox:checked').length;
        const progressBar = document.getElementById('checklist-progress-bar');
        const progressText = document.getElementById('checklist-progress-text');
        const percentage = totalItems > 0 ? (checkedCount / totalItems * 100) : 0;

        progressBar.style.width = percentage + '%';
        progressText.textContent = checkedCount + '/' + totalItems;

        if (checkedCount === totalItems) {
            progressBar.classList.remove('bg-green-400');
            progressBar.classList.add('bg-green-600');
        } else {
            progressBar.classList.add('bg-green-400');
            progressBar.classList.remove('bg-green-600');
        }
    }
});
</script>
@endpush