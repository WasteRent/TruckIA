<form method="GET" class="grid sm:grid-cols-3 gap-4">
    <div>
        <label for="event" class="form-label">Evento</label>
        <select name="event" id="event" class="form-select">
            <option value="">Todos</option>
            @foreach (['created' => 'Creado', 'updated' => 'Actualizado', 'deleted' => 'Eliminado'] as $eventValue => $eventLabel)
                <option value="{{ $eventValue }}" @selected(request('event') === $eventValue)>
                    {{ $eventLabel }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="date_from" class="form-label">Fecha desde</label>
        <input
            type="date"
            name="date_from"
            id="date_from"
            value="{{ request('date_from') }}"
            class="form-input"
        >
    </div>

    <div>
        <label for="date_to" class="form-label">Fecha hasta</label>
        <input
            type="date"
            name="date_to"
            id="date_to"
            value="{{ request('date_to') }}"
            class="form-input"
        >
    </div>

    <div class="flex items-end gap-4">
        <button class="btn-search">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>
