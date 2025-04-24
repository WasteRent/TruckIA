@extends('layouts.fleet')

@section('title')
    <div class="flex justify-between items-center">
        <div class="mr-20">{{ __('Lavados') }}</div>
    </div>
@endsection

@section('content')
    @component('components.card')
        @slot('title', __('Lavados realizados'))
        {!! Form::open([
            'route' => ['fleet.washing-checklists.store', ['vehicle_washing_id' => $washing->id]],
            'method' => 'POST',
            'class' => 'w-full',
        ]) !!}
        
        @slot('corner')
            <a class="mr-4 text-green-600" href="{{ route('fleet.export.vehicle-washing-checklist', ['vehicle_washing' => $washing->id]) }}"><i class="fas fa-lg fa-file-excel"></i></a>
        @endslot

        <div class="flex flex-col justify-start items-start gap-2">
            <div class="flex flex-col gap-3">
                @foreach ($vehicle_washing_types as $type)
                    <div class="text-sm">
                        <label>
                            {!! Form::hidden("vehicle_washing_types[$type->id]", 0) !!}

                            {!! Form::checkbox("vehicle_washing_types[$type->id]", 1, optional($washing->vehicleWashingChecklists->firstWhere('vehicle_washing_type_id', $type->id))->is_checked == 1 ? true : false) !!}
                            {{ __($type->name) }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="btn-outline-gray mt-2">
                <button>{{ __('Actualizar') }}</button>
            </div>
        </div>

        {!! Form::close() !!}
    @endcomponent
@endsection
