<canvas id="myChartVehicleMaintenance" width="200" height="50"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctx = document.getElementById('myChartVehicleMaintenance');

  var up_to_date = {{ $maintenance->where('state', 'Al día')->count() }}
  var past = {{ $maintenance->where('state', 'Pasado')->count() }}
  var count = {{$maintenance->count()}}

  const data = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*past/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, past],
        borderColor: ['#20c997', '#fd3550'],
        backgroundColor: ['#20c997', '#fd3550'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Mantenimiento'
        }
      }
    },
  };

  var myChart = new Chart(ctx, config);
  </script>
@endpush