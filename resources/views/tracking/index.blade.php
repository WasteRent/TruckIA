@extends('layouts.fleet')

@section('title', __('Análisis de telemetría'))

@section('content')
    @component('components.card')
        <form method="POST" action="{{ route('tracking.debug.store') }}" class="space-y-4">
            @csrf
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

    @if($debugs->count())
        @component('components.card', ['is_table' => true])
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Proveedor') }}</th>
                        <th>{{ __('Servicio') }}</th>
                        <th>{{ __('Estado') }}</th>
                        <th>{{ __('Creado') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($debugs as $debug)
                        <tr>
                            <td>{{ $debug->id }}</td>
                            <td>{{ $debug->provider }}</td>
                            <td>{{ $debug->service_key }}</td>
                            <td>
                                @if($debug->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        {{ __('Pendiente') }}
                                    </span>
                                @elseif($debug->status === 'success')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        {{ __('Correcto') }}
                                    </span>
                                @elseif($debug->status === 'error')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        {{ __('Error') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $debug->status }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $debug->created_at }}</td>
                            <td>
                                @if($debug->status === 'success')
                                    <a href="{{ route('tracking.debug.show', $debug) }}" class="text-indigo-600">
                                        {{ __('Ver datos') }}
                                    </a>
                                @elseif($debug->status === 'error')
                                    <span class="text-red-600" title="{{ $debug->error_message }}">
                                        {{ __('Error') }}
                                    </span>
                                @else
                                    <span class="text-gray-500">
                                        {{ __('Pendiente') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $debugs->links() }}
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

