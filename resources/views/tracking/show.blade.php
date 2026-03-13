@extends('layouts.fleet')

@section('title', __('Análisis de telemetría'))

@section('content')
    @component('components.card')
        <p class="text-sm text-gray-700 mb-2">
            <span class="font-semibold">{{ __('Proveedor') }}:</span> {{ $debug->provider }}<br>
            <span class="font-semibold">{{ __('Servicio') }}:</span> {{ $debug->service_key }}<br>
            <span class="font-semibold">{{ __('Estado') }}:</span> {{ $debug->status }}<br>
            <span class="font-semibold">{{ __('Creado') }}:</span> {{ $debug->created_at }}<br>
            @if($debug->status === 'error' && $debug->error_message)
                <span class="font-semibold text-red-600">{{ __('Error') }}:</span> {{ $debug->error_message }}
            @endif
        </p>
        <a href="{{ route('tracking.debug.index') }}" class="text-sm text-indigo-600 hover:underline">
            {{ __('Volver al listado') }}
        </a>
    @endcomponent

    @if(!empty($rows))
        @component('components.card', ['is_table' => true])
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Matrícula') }}</th>
                        <th>{{ __('Kms') }}</th>
                        <th>{{ __('Horas motor') }}</th>
                        <th>{{ __('Meta') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{ $row['plate'] ?? '' }}</td>
                            <td>
                                @if(isset($row['kms']) && $row['kms'] !== null)
                                    {{ number_format($row['kms'], 2, ',', '.') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if(isset($row['engine_hours']) && $row['engine_hours'] !== null)
                                    {{ number_format($row['engine_hours'], 2, ',', '.') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-xs text-gray-500">
                                @if(isset($row['meta']) && is_array($row['meta']))
                                    @foreach($row['meta'] as $key => $value)
                                        <div>
                                            <span class="font-semibold">{{ $key }}:</span>
                                            <span>{{ $value }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endcomponent
    @endif
@endsection

