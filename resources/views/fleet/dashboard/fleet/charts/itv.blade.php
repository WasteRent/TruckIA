<canvas id="myChartVehicleItv" width="200" height="50"></canvas>

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
  var ctx = document.getElementById('myChartVehicleItv');

  var up_to_date = {{ $itv_stats['up_to_date'] }}
  var passed = {{ $itv_stats['passed'] }}
  var count = {{$itv_stats['total']}}

  const dataItv = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*passed/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, passed],
        borderColor: ['#3b82f6', '#f59e0b'],
        backgroundColor: ['#3b82f6', '#f59e0b'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const configItv = {
    type: 'pie',
    data: dataItv,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'ITV'
        }
      }
    },
  };

  var myChart = new Chart(ctx, configItv);
  </script>
@endpush