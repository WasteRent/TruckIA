@extends('layouts.fleet')

@section('title')
    <div class="flex justify-between items-center">
        <div class="mr-20">{{ $washing->vehicle->plate }} - {{ $washing->created_at->format('d/m/Y H:i') }}</div>
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
