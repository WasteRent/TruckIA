@foreach ($container_checklist->items->groupBy('checklistItem.category') as $category => $items)
    <div class="mb-8 ">
        <label class="text-base font-medium text-gray-900">{{ $category }}</label>
        @foreach ($items as $item)
            <fieldset class="mt-4 border-0 px-0">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        {!! Form::checkbox("items[$item->id]", 1, $item->is_checked, ['class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded']) !!}
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="font-medium text-gray-700">{{$item->checklistItem->description}}</label>
                    </div>
                </div>
            </fieldset>
        @endforeach
    </div>
@endforeach
