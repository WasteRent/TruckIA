<div class="grid grid-cols-4 gap-4 mb-6">
    <div>
        <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
        {!! Form::date("date", $vehicle_checklist->date ?? today(), ['class' => 'form-input mt-1 block w-full', 'id' => 'date']) !!}
    </div>
    <div>
        <label for="engine_hours" class="block text-sm font-medium text-gray-700">Horas Motor</label>
        {!! Form::number("engine_hours", $vehicle_checklist->engine_hours, ['class' => 'form-input mt-1 block w-full', 'id' => 'engine_hours']) !!}
    </div>
    <div>
        <label for="tdf_hours" class="block text-sm font-medium text-gray-700">Horas TDF</label>
        {!! Form::number("tdf_hours", $vehicle_checklist->tdf_hours, ['class' => 'form-input mt-1 block w-full', 'id' => 'tdf_hours']) !!}
    </div>
</div>

@foreach ($vehicle_checklist->items->groupBy('checklistItem.category') as $category => $items)
    <div class="mb-8">
        <label class="text-base font-medium text-gray-900">{{ $category }}</label>
        @foreach ($items as $item)
            <fieldset class="mt-4 border-0 px-0">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5 text-sm">
                        {!! Form::radio("items[$item->id]", 'bien', $item->result == 'bien' ? 1 : 0, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
                        {!! Form::radio("items[$item->id]", 'regular', $item->result == 'regular' ? 1 :0, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
                        {!! Form::radio("items[$item->id]", 'mal', $item->result == 'mal' ? 1 : 0, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
                    </div>
                    <div class="ml-3 text-sm">
                    <label class="font-semibold text-gray-700">{{$item->checklistItem->description}}</label>
                    </div>
                </div>
            </fieldset>
        @endforeach
    </div>
@endforeach
