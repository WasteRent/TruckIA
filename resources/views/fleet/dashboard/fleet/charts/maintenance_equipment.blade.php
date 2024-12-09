<canvas id="myChartVehicleMaintenanceEquipment" width="200" height="50"></canvas>

@push('js')

  <script>
  var ctx = document.getElementById('myChartVehicleMaintenanceEquipment');

  var up_to_date = {{ $maintenance_equipment->where('state', 'Al día')->count() }}
  var past = {{ $maintenance_equipment->where('state', 'Pasado')->count() }}
  var count = {{$maintenance_equipment->count()}}

  const dataEquipment = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*past/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, past],
        borderColor: ['#2dd4bf', '#fb923c'],
        backgroundColor: ['#2dd4bf', '#fb923c'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const configEquipment = {
    type: 'pie',
    data: dataEquipment,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Mantenimiento equipos'
        }
      }
    },
  };

  var myChart = new Chart(ctx, configEquipment);
  </script>
@endpush