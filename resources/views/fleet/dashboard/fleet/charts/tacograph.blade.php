<canvas id="myChartVehicleTacograph" width="200" height="50"></canvas>

@push('js')

  <script>
  var ctx = document.getElementById('myChartVehicleTacograph');

  var up_to_date = {{ $tacograph_stats['up_to_date'] }}
  var passed = {{ $tacograph_stats['passed'] }}
  var count = {{$tacograph_stats['total']}}

  const dataTacograph = {
    labels: [`Al día ${(100*up_to_date/count).toFixed(2)}%`, `Pasado ${(100*passed/count).toFixed(2)}%`],
    datasets: [
      {
        label: 'Vehículo',
        data: [up_to_date, passed],
        borderColor: ['#4b0082', '#ffa500'],
        backgroundColor: ['#4b0082', '#ffa500'],
        cubicInterpolationMode: 'monotone',
        tension: 0.4
      }
    ]
  };

  const configTacograph = {
    type: 'pie',
    data: dataTacograph,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Tacógrafos'
        }
      }
    },
  };

  var myChart = new Chart(ctx, configTacograph);
  </script>
@endpush