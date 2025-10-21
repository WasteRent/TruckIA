<fieldset class="space-y-5 mt-4 border-0 px-0">
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_security', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_security', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_security', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_security', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Seguridades</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_training', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_training', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_training', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_training', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Formación</label>
    </div>
  </div>
    <div class="relative flex items-start">
      <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_gps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_gps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_gps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_gps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
      </div>
      <div class="ml-3 text-sm">
        <label class="font-semibold text-gray-700">GPS</label>
      </div>
    </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_front_tires', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_front_tires', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_front_tires', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_front_tires', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumáticos delanteros</label>
      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_tires_2_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_tires_2_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_tires_2_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_tires_2_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumáticos 2º eje</label>
      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_tires_3_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_tires_3_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_tires_3_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_tires_3_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumáticos 3º eje</label>
      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_extinguisher', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_extinguisher', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_extinguisher', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_extinguisher', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Extintor</label>
      <p class="text-gray-500">Comprobar estado visual y fecha de última revisión.</p>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_clean_cabin', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_clean_cabin', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_clean_cabin', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_clean_cabin', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Limpieza interior</label>
      <p class="text-gray-500">Comprobar cabina interior.</p>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_clean_exterior', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_clean_exterior', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_clean_exterior', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_clean_exterior', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Limpieza exterior</label>
      <p class="text-gray-500">Comprobar exteriores y caja vaciada.</p>
    </div>
  </div>

  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_full_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_full_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_full_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_full_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Prueba de equipo ciclo completo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_dump_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_dump_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_dump_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_dump_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Ciclo de descarga</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Luces</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_itv', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_itv', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_itv', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_itv', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">ITV</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_tacograph', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_tacograph', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_tacograph', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_tacograph', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Tacógrafo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_preventive_chassis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_preventive_chassis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_preventive_chassis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_preventive_chassis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Preventivo chasis</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_preventive_equipment', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_preventive_equipment', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_preventive_equipment', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_preventive_equipment', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Preventivo equipo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_security_triangles', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_security_triangles', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_security_triangles', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_security_triangles', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Triángulos de Seguridad</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_reflective_vest', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_reflective_vest', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_reflective_vest', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_reflective_vest', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Chaleco reflectante</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_documents', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_documents', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_documents', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_documents', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Documentación del vehículo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_fluid_levels', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_fluid_levels', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_fluid_levels', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_fluid_levels', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Niveles de fluidos</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_rubber_status', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_rubber_status', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_rubber_status', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_rubber_status', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Estado goma culera</label>
    </div>
  </div>

</fieldset>