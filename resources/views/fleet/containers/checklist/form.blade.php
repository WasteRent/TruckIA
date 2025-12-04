@foreach ($container_checklist->items->groupBy('checklistItem.category') as $category => $items)
    <div class="mb-8 ">
        <label class="text-base font-medium text-gray-900">{{ $category }}</label>
        @foreach ($items as $item)
            <fieldset class="mt-4 border-0 px-0">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        {!! Form::checkbox("items[$item->id]", 1, $item->is_checked, ['class' => 'focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded']) !!}
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="font-medium text-gray-700">{{$item->checklistItem->description}}</label>
                    </div>
                </div>
            </fieldset>
        @endforeach
    </div>
@endforeach

<div class="mt-8">
    <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">
        {{ __('Observaciones') }}
    </label>
    {!! Form::textarea('observations', $container_checklist->observations ?? null, [
        'class' => 'form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm',
        'rows' => 4,
        'placeholder' => __('Escribe aquí las observaciones...')
    ]) !!}
</div>