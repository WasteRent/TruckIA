<div class="flex flex-wrap -mx-3 mb-6 ml-1 mr-1">
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        {!! Form::text('ID', 'ID', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        {!! Form::text('created_at', '2011-04-01', ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        {!! Form::text('n_pedido', 'Nº Pedido / OR', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
        {!! Form::select('Creado por', ['Creado por' => 'Creado por', '-' => '-'], 'Creado por', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
        {!! Form::select('Estado', ['Estado' => 'Estado', '-' => '-'], 'Estado', ['class' => 'form-select']) !!}
    </div>


    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
        Datos Vehículo:
        </label>
        {!! Form::text('Matrícula', 'Matrícula', ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Marca Chasis', ['Marca Chasis' => 'Marca Chasis', '-' => '-'], 'Marca Chasis', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Mod. Chasis', ['Mod. Chasis' => 'Mod. Chasis', '-' => '-'], 'Mod. Chasis', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Marca Equipo', ['Marca Equipo' => 'Marca Equipo', '-' => '-'], 'Marca Equipo', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Mod. Equipo', ['Mod. Equipo' => 'Mod. Equipo', '-' => '-'], 'Mod. Equipo', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Cliente', ['Cliente' => 'Cliente', '-' => '-'], 'Cliente', ['class' => 'form-select']) !!}
    </div>

    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
         Tipo de intervención:
        </label>
        {!! Form::select('OR_type', ['¿Prev. o corre.?' => '¿Prev. o corre.?', '-' => '-'], '¿Prev. o corre.?', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Taller', ['Taller' => 'Taller', '-' => '-'], 'Taller', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Técnico', ['Técnico' => 'Técnico', '-' => '-'], 'Técnico', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Siniestro', ['' => '¿Siniestro?','0' => 'NO', '1' => 'SI'], '¿Siniestro?', ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 mt-5">
        {!! Form::select('Mal_Uso', ['' => '¿Mal uso?','0' => 'NO', '1' => 'SI'], '¿Mal uso?', ['class' => 'form-select']) !!}
    </div>
</div>