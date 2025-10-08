<fieldset class="space-y-5 mt-4 border-0 px-0">
    <div class="relative flex items-start">
        <div class="flex items-center h-5 text-sm">
            {!! Form::radio('check_front_tire_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_tire_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_tire_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_tire_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
        </div>
        <div class="ml-3 text-sm">
          <label class="font-semibold text-gray-700">Neumático delantero derecho</label>
        </div>
    </div>
    <div class="relative flex items-start">
        <div class="flex items-center h-5 text-sm">
            {!! Form::radio('check_front_tire_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_tire_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_tire_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_tire_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
        </div>
        <div class="ml-3 text-sm">
          <label class="font-semibold text-gray-700">Neumático delantero izquierdo</label>
        </div>
    </div>
    <div class="relative flex items-start">
      <div class="flex items-center h-5 text-sm">
          {!! Form::radio('check_tire_2_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
          {!! Form::radio('check_tire_2_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
          {!! Form::radio('check_tire_2_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
          {!! Form::radio('check_tire_2_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
      </div>
      <div class="ml-3 text-sm">
        <label class="font-semibold text-gray-700">Neumático 2º eje derecho</label>
      </div>
    </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_tire_2_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_tire_2_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_tire_2_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_tire_2_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumático 2º eje izquierdo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_tire_3_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_tire_3_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_tire_3_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_tire_3_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumático 3º eje derecho</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_tire_3_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_tire_3_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_tire_3_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_tire_3_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Neumático 3º eje izquierdo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_front_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_front_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_front_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_front_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Faldillas eje delantero</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_axle_2_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_axle_2_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_axle_2_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_axle_2_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Faldillas 2º eje</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_axle_3_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_axle_3_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_axle_3_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_axle_3_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Faldillas 3º eje</label>
    </div>
  </div>

  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_fire_extinguishers', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_fire_extinguishers', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_fire_extinguishers', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_fire_extinguishers', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Extintores</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_battery_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_battery_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_battery_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_battery_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Tapa baterias </label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_windows_glass', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_windows_glass', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_windows_glass', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_windows_glass', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Luna y cristales</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_fuel_adblue_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_fuel_adblue_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_fuel_adblue_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_fuel_adblue_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Tapón gasoil / adblue</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_rotating_work_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_rotating_work_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_rotating_work_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_rotating_work_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Rotativos-Faros de trabajo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_headlights_pilots_lamps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_headlights_pilots_lamps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_headlights_pilots_lamps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_headlights_pilots_lamps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Faros-Pilotos y tulipas</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_right_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_right_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_right_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_right_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Retrovisor derecho</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_left_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_left_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_left_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_left_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Retrovisor izquierdo</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_interior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_interior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_interior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_interior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Limpieza interior</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
      {!! Form::radio('check_exterior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_exterior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_exterior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_exterior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Limpieza exterior</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">
        {!! Form::radio('check_vest_triangle_light', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
        {!! Form::radio('check_vest_triangle_light', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
        {!! Form::radio('check_vest_triangle_light', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
        {!! Form::radio('check_vest_triangle_light', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Chaleco y triángulo (luz)</label>
    </div>
  </div>
  <div class="relative flex items-start">
    <div class="flex items-center h-5 text-sm">

      {!! Form::radio('check_documentation', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
      {!! Form::radio('check_documentation', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
      {!! Form::radio('check_documentation', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
      {!! Form::radio('check_documentation', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
    </div>
    <div class="ml-3 text-sm">
      <label class="font-semibold text-gray-700">Documentación </label>
    </div>
  </div>

</fieldset>