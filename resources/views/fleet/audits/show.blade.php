@extends('layouts.fleet')

@section('title', 'Detalle de modificación')

@section('content')

    <div class="mb-4">
        <a href="{{ route('fleet.audits.index', request()->query()) }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>

    @component('components.card', ['title' => 'Reporte completo de modificación'])
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Resumen</h3>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-700">
                        Se registró un evento de tipo <strong>{{ ucfirst($audit->event) }}</strong> 
                        en la entidad <strong>{{ class_basename($audit->auditable_type) }}</strong> 
                        con ID <strong>{{ $audit->auditable_id }}</strong>.
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Fecha</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                            {{ $audit->created_at?->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Usuario</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-user mr-2 text-gray-500"></i>
                            @if ($audit->user)
                                {{ $audit->user->name ?? $audit->user->email ?? $audit->user->username }}
                            @else
                                <span class="text-gray-400">Usuario no encontrado</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Evento</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        @if($audit->event === 'created')
                            <span class="badge bg-green-100 text-green-700">
                                <i class="fas fa-plus-circle mr-1"></i>
                                {{ __('Creado') }}
                            </span>
                        @elseif($audit->event === 'updated')
                            <span class="badge bg-blue-100 text-blue-700">
                                <i class="fas fa-edit mr-1"></i>
                                {{ __('Actualizado') }}
                            </span>
                        @elseif($audit->event === 'deleted')
                            <span class="badge bg-red-100 text-red-700">
                                <i class="fas fa-trash mr-1"></i>
                                {{ __('Eliminado') }}
                            </span>
                        @else
                            <span class="badge bg-gray-100 text-gray-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ __('Otro') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Entidad</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-database mr-2 text-gray-500"></i>
                            <strong>{{ class_basename($audit->auditable_type) }}</strong>
                            <span class="text-gray-500">(ID: {{ $audit->auditable_id }})</span>
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Cambios</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-semibold mb-2 text-gray-700">Valores anteriores</h4>
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            @if(!empty($audit->old_values))
                                <pre class="text-xs leading-relaxed whitespace-pre-wrap text-gray-800 overflow-auto max-h-96">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            @else
                                <p class="text-sm text-gray-500 italic">Sin valores anteriores</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold mb-2 text-gray-700">Valores nuevos</h4>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            @if(!empty($audit->new_values))
                                <pre class="text-xs leading-relaxed whitespace-pre-wrap text-gray-800 overflow-auto max-h-96">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            @else
                                <p class="text-sm text-gray-500 italic">Sin valores nuevos</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent

@endsection

