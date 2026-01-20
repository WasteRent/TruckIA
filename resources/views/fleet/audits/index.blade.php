@extends('layouts.fleet')

@section('title', 'Log de modificaciones')

@section('content')

    @component('components.search-card')
        @include('fleet.audits.search')
    @endcomponent

    @component('components.card', ['is_table' => true, 'title' => 'Log de modificaciones'])
        <table>
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Evento</th>
                <th>Tipo</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($audits as $audit)
                <tr>
                    <td class="text-xs whitespace-nowrap">
                        {{ $audit->created_at?->format('d/m/Y H:i:s') }}
                    </td>
                    <td class="text-sm">
                        @if ($audit->user)
                            {{ $audit->user->name ?? $audit->user->email ?? $audit->user->username }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td>
                        @if($audit->event === 'created')
                            <span class="badge bg-green-100 text-green-700">
                                {{ __('Creado') }}
                            </span>
                        @elseif($audit->event === 'updated')
                            <span class="badge bg-blue-100 text-blue-700">
                                {{ __('Actualizado') }}
                            </span>
                        @elseif($audit->event === 'deleted')
                            <span class="badge bg-red-100 text-red-700">
                                {{ __('Eliminado') }}
                            </span>
                        @else
                            <span class="badge bg-gray-100 text-gray-700">
                                {{ __('Otro') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-xs">
                        {{ class_basename($audit->auditable_type) }}
                    </td>
                    <td>
                        <a href="{{ route('fleet.audits.show', $audit->id) }}" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        No hay registros de modificaciones para mostrar.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endcomponent

    @if($audits->count())
        <div class="mt-4">
            {{ $audits->appends(request()->query())->links() }}
        </div>
    @endif

@endsection
