<canvas id="myChartVehicleMaintenanceChassis" width="200" height="50"></canvas>

@push('js')

  <script>
  var ctx = document.getElementById('myChartVehicleMaintenanceChassis');

  var up_to_date = {{ $maintenance_chassis->where('state', 'Al día')->count() }}
  var past = {{ $maintenance_chassis->where('state', 'Pasado')->count() }}
  var count = {{$maintenance_chassis->count()}}

  const dataChassis = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*past/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, past],
        borderColor: ['#22c55e', '#ef4444'],
        backgroundColor: ['#22c55e', '#ef4444'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const configChassis = {
    type: 'pie',
    data: dataChassis,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Mantenimiento chasis'
        }
      }
    },
  };

  var myChart = new Chart(ctx, configChassis);
  </script>
@endpush