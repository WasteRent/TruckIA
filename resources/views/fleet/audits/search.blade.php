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
        <label for="user_id" class="form-label">Usuario</label>
        <select name="user_id" id="user_id" class="form-select">
            <option value="">Todos</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="auditable_id" class="form-label">ID Interno</label>
        <input
            type="text"
            name="auditable_id"
            id="auditable_id"
            value="{{ request('auditable_id') }}"
            class="form-input"
            placeholder="ID interno del vehículo"
        >
    </div>

    <div>
        <label for="plate" class="form-label">Matrícula</label>
        <input
            type="text"
            name="plate"
            id="plate"
            value="{{ request('plate') }}"
            class="form-input"
            placeholder="Matrícula del vehículo"
        >
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
