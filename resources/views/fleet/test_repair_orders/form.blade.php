
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label form-required">
        Fecha 
        </label>
        {!! Form::text('date', '2021-12-04', ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Nombre
        </label>
        {!! Form::text('name', 'Ismael', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Kilómetros
        </label>
        {!! Form::text('km', 'kilómetros', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
        H. Chásis
        </label>
        {!! Form::text('chassis_hours', '(h. chasis)', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
        H. Equipo
        </label>
        {!! Form::text('equipment_hours', '(h. equipo)', ['class' => 'form-input']) !!}
    </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Matrícula
        </label>
        {!! Form::text('matricula', '0548HTL', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Marca
        </label>
        {!! Form::text('marca', 'Mercedes Antos 2533 (EU6)', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Equipo
        </label>
        {!! Form::text('equipo', 'Faun Vari o press 5 / Hiab X HiPro 408', ['class' => 'form-input']) !!}
    </div>
</div>
