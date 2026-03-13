@extends('layouts.fleet')

@section('title', __('Diagnóstico de telemetría'))

@section('content')
    @component('components.card')
        <form method="GET" action="{{ route('tracking.debug.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="provider">
                        {{ __('Proveedor') }}
                    </label>
                    <select
                        id="provider"
                        name="provider"
                        class="form-select mt-1 block w-full"
                        required
                    >
                        <option value="">{{ __('Selecciona un proveedor') }}</option>
                        @foreach($providers as $provider_option)
                            <option
                                value="{{ $provider_option }}"
                                @if($selected_provider === $provider_option) selected @endif
                            >
                                {{ $provider_option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="service_key">
                        {{ __('Servicio') }}
                    </label>
                    <select
                        id="service_key"
                        name="service_key"
                        class="form-select mt-1 block w-full"
                        required
                    >
                        <option value="">{{ __('Selecciona un servicio') }}</option>
                        @if(!empty($service_keys_for_provider))
                            @foreach($service_keys_for_provider as $service_option)
                                <option
                                    value="{{ $service_option }}"
                                    @if($selected_service_key === $service_option) selected @endif
                                >
                                    {{ $service_option }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="btn-gray"
                >
                    {{ __('Buscar') }}
                </button>
            </div>
        </form>
    @endcomponent

    @if(!empty($rows))
        @component('components.card', ['is_table' => true])
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Servicio') }}</th>
                        <th>{{ __('Matrícula') }}</th>
                        <th>{{ __('Kms') }}</th>
                        <th>{{ __('Horas motor') }}</th>
                        <th>{{ __('Meta') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{ $row['service'] ?? '' }}</td>
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

@push('js')
    <script>
        (function () {
            var servicesByProvider = @json($service_keys_by_provider ?? []);
            var providerSelect = document.getElementById('provider');
            var serviceSelect = document.getElementById('service_key');

            if (!providerSelect || !serviceSelect) {
                return;
            }

            function refreshServiceOptions() {
                var provider = providerSelect.value;
                var options = servicesByProvider[provider] || [];

                while (serviceSelect.firstChild) {
                    serviceSelect.removeChild(serviceSelect.firstChild);
                }

                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '{{ __('Selecciona un servicio') }}';
                serviceSelect.appendChild(defaultOption);

                options.forEach(function (serviceKey) {
                    var option = document.createElement('option');
                    option.value = serviceKey;
                    option.textContent = serviceKey;
                    serviceSelect.appendChild(option);
                });
            }

            // Inicializar opciones al cargar la página
            refreshServiceOptions();

            providerSelect.addEventListener('change', function () {
                refreshServiceOptions();
            });
        })();
    </script>
@endpush

