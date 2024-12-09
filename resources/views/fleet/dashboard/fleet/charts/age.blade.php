<canvas id="myChartAge" width="400" height="200"></canvas>

@push('js')
  <script>
  var ctxAge = document.getElementById('myChartAge');

  var source = {!! json_encode($fleet_age) !!}

  const dataAge = {
    labels: source.years.map(x => x.year),
    datasets: [
      {
        type: 'bar',
        label: 'Vehículos',
        data: source.years.map(x => x.total),
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
        cubicInterpolationMode: 'monotone',
        tension: 0.4,
        yAxisID: 'y'
      }
    ]
  };

  const configAge = {
    data: dataAge,
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      stacked: false,
      plugins: {
        title: {
          display: true,
          text: 'Antigüedad de la flota: ' + source.avg_years + ' años'
        }
      },
      scales: {
        y: {
          type: 'linear',
          display: true,
          position: 'left',
        }
      }
    },
  };

  var myChartAge = new Chart(ctxAge, configAge);
  </script>
@endpush